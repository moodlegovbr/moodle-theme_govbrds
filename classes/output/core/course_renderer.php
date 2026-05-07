<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Privacy Subsystem implementation for theme_govbrds.
 *
 * @package    theme_govbrds
 * @copyright  2025 Fábio Santos <fabio.santos@ifrr.edu.br>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_govbrds\output\core;

use html_writer;
use coursecat_helper;
use stdClass;
use core_course_list_element;
use core_course_category;
use theme_govbrds\util\course;
use moodle_url;

/**
 * Custom course renderer for the theme.
 *
 * @package    theme_govbrds
 * @copyright  2019 Fábio Santos <fabio.santos@ifrr.edu.br>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_renderer extends \core_course_renderer {
    /**
     * Renders the course catalogue page with flat course list and search/filter bar.
     *
     * Overrides the core method to avoid the redirect to management.php and to display
     * all courses as a flat card list instead of a category tree.
     *
     * @param int|stdClass|core_course_category $category
     * @return string
     */
    public function course_category($category) {
        global $CFG;

        if (empty($category)) {
            $coursecat = core_course_category::user_top();
        } else if (is_object($category) && $category instanceof core_course_category) {
            $coursecat = $category;
        } else {
            $coursecat = core_course_category::get(is_object($category) ? $category->id : $category);
        }

        $search  = optional_param('search', '', PARAM_TEXT);
        $page    = optional_param('page', 0, PARAM_INT);
        $perpage = max(1, (int) ($CFG->coursesperpage ?: 20));

        $catfilter = (int) $coursecat->id;

        // Build category options for the filter dropdown.
        $allcats = core_course_category::make_categories_list();
        $categoryoptions = [];
        foreach ($allcats as $catid => $catname) {
            $categoryoptions[] = [
                'id'       => $catid,
                'name'     => $catname,
                'selected' => ($catid === $catfilter),
            ];
        }

        $hasactivefilter = !empty($search) || !empty($catfilter);
        [$courses, $totalcount] = $this->get_catalogue_courses($search, $catfilter, $page, $perpage);

        $paginationparams = [];
        if (!empty($search)) {
            $paginationparams['search'] = $search;
        }
        if (!empty($catfilter)) {
            $paginationparams['categoryid'] = $catfilter;
        }

        $chelper = new coursecat_helper();
        $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED)
                ->set_courses_display_options([
                    'limit'         => $perpage,
                    'offset'        => $page * $perpage,
                    'paginationurl' => new moodle_url('/course/index.php', $paginationparams),
                ])
                ->set_attributes(['class' => 'course-catalogue-list']);

        $formaction = (new moodle_url('/course/index.php'))->out(false);

        $output = $this->render_from_template('theme_govbrds/course_catalogue_filters', [
            'formaction'           => $formaction,
            'search'               => $search,
            'categoryid'           => $catfilter,
            'allcategoriesselected'=> empty($catfilter),
            'categories'           => $categoryoptions,
            'hasactivefilter'      => $hasactivefilter,
            'totalcount'           => $totalcount,
        ]);

        if (!$totalcount) {
            $msg = !empty($search)
                ? get_string('nocoursesfound', '', $search)
                : get_string('nocoursesyet');
            $output .= html_writer::div($msg, 'alert alert-info mt-3');
        } else {
            $output .= $this->coursecat_courses($chelper, $courses, $totalcount);
        }

        return $output;
    }

    /**
     * Fetches courses for the catalogue applying optional name and category filters.
     *
     * Uses a direct DB query so that search and category (with subcategories) can be
     * combined without the pagination distortion that post-filtering would cause.
     *
     * @param string $search     Partial name to search (empty = no filter)
     * @param int    $catfilter  Category ID to restrict to (0 = all categories)
     * @param int    $page       Zero-based page index
     * @param int    $perpage    Records per page
     * @return array [core_course_list_element[], int $totalcount]
     */
    private function get_catalogue_courses(string $search, int $catfilter, int $page, int $perpage): array {
        global $DB;

        $conditions = ['c.id <> :siteid', 'c.visible = 1'];
        $params     = ['siteid' => SITEID];
        $joins      = '';

        if (!empty($catfilter)) {
            $catrecord = $DB->get_record('course_categories', ['id' => $catfilter], 'id, path');
            if ($catrecord) {
                $joins .= ' JOIN {course_categories} cc ON c.category = cc.id';
                $conditions[] = '(cc.id = :catid OR ' . $DB->sql_like('cc.path', ':catpath') . ')';
                $params['catid']   = $catfilter;
                $params['catpath'] = $catrecord->path . '/%';
            }
        }

        if (!empty($search)) {
            $escaped = '%' . $DB->sql_like_escape($search) . '%';
            $conditions[] = '(' . $DB->sql_like('c.fullname', ':fsearch', false)
                          . ' OR ' . $DB->sql_like('c.shortname', ':ssearch', false) . ')';
            $params['fsearch'] = $escaped;
            $params['ssearch'] = $escaped;
        }

        $where = implode(' AND ', $conditions);
        $base  = "FROM {course} c{$joins} WHERE {$where}";

        $totalcount = (int) $DB->count_records_sql("SELECT COUNT(DISTINCT c.id) {$base}", $params);
        $records    = $DB->get_records_sql(
            "SELECT DISTINCT c.* {$base} ORDER BY c.fullname ASC",
            $params,
            $page * $perpage,
            $perpage
        );

        $courses = [];
        foreach ($records as $record) {
            $courses[$record->id] = new core_course_list_element($record);
        }

        return [$courses, $totalcount];
    }

    /**
     * Returns HTML to print tree of course categories (with number of courses) for the frontpage
     *
     * @return string
     */
    public function frontpage_categories_list() {
        global $DB;

        try {
            // Search for visible top-level categories.
            $categories = $DB->get_records_sql("
                SELECT cc.id, cc.name, cc.coursecount, cc.visible, cc.sortorder
                FROM {course_categories} cc
                WHERE cc.parent = 0
                AND cc.visible = 1
                ORDER BY cc.sortorder ASC
                LIMIT 20
            ");

            if (empty($categories)) {
                return '';
            }
            // Start building the HTML.
            $output = '';
            $output .= \html_writer::start_div('frontpage-category-buttons-container');
            // Title.
            $title = \theme_config::load('govbrds')->settings->listcoursestitle;
            $output .= \html_writer::tag(
                'h2',
                $title,
                ['class' => 'frontpage-categories-title']
            );
            // Container flex for buttons.
            $output .= \html_writer::start_div('category-buttons-flex p-3');
            foreach ($categories as $category) {
                // URL for category.
                $categoryurl = new \moodle_url('/course/index.php', ['categoryid' => $category->id]);
                $categoryname = format_string($category->name);
                $coursecount = intval($category->coursecount);
                // Create button.
                $buttonattributes = [
                    'class' => 'br-button primary mr-3 mb-3',
                    'data-categoryid' => $category->id,
                    'title' => $categoryname . ($coursecount > 0 ? " ( {$coursecount} )" : ''),
                    'role' => 'button',
                ];
                $buttoncontent = \html_writer::div($categoryname, 'category-name');
                $output .= \html_writer::link($categoryurl, $buttoncontent, $buttonattributes);
            }
            $output .= \html_writer::end_div(); // Category buttons flex.
            $output .= \html_writer::end_div(); // Frontpage category buttons container.
            return $output;
        } catch (Exception $e) {
            debugging('Error loading categories: ' . $e->getMessage(), DEBUG_DEVELOPER);
            // Fallback: return friendly message.
            $output = \html_writer::div(
                'Unable to load categories at this time.',
                'alert alert-info'
            );
            return $output;
        }
    }

    /**
     * Renders the list of courses
     *
     * This is internal function, please use core_course_renderer::courses_list() or another public
     * method from outside of the class
     *
     * If list of courses is specified in $courses; the argument $chelper is only used
     * to retrieve display options and attributes, only methods get_show_courses(),
     * get_courses_display_option() and get_and_erase_attributes() are called.
     *
     * @param coursecat_helper $chelper various display options
     * @param array $courses the list of courses to display
     * @param int|null $totalcount total number of courses (affects display mode if it is AUTO or pagination if applicable),
     *     defaulted to count($courses)
     * @return string
     */
    protected function coursecat_courses(coursecat_helper $chelper, $courses, $totalcount = null) {
        global $CFG;
        if ($totalcount === null) {
            $totalcount = count($courses);
        }
        if (!$totalcount) {
            // Courses count is cached during courses retrieval.
            return '';
        }
        if ($chelper->get_show_courses() == self::COURSECAT_SHOW_COURSES_AUTO) {
            // In 'auto' course display mode we analyse if number of courses is more or less than $CFG->courseswithsummarieslimit.
            if ($totalcount <= $CFG->courseswithsummarieslimit) {
                $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED);
            } else {
                $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_COLLAPSED);
            }
        }
        // Prepare content of paging bar if it is needed.
        $paginationurl = $chelper->get_courses_display_option('paginationurl');
        $paginationallowall = $chelper->get_courses_display_option('paginationallowall');
        if ($totalcount > count($courses)) {
            // There are more results that can fit on one page.
            if ($paginationurl) {
                // The option paginationurl was specified, display pagingbar.
                $perpage = $chelper->get_courses_display_option('limit', $CFG->coursesperpage);
                $page = $chelper->get_courses_display_option('offset') / $perpage;
                $pagingbar = $this->paging_bar(
                    $totalcount,
                    $page,
                    $perpage,
                    $paginationurl->out(false, ['perpage' => $perpage])
                );
                if ($paginationallowall) {
                    $pagingbar .= html_writer::tag('div', html_writer::link(
                        $paginationurl->out(false, ['perpage' => 'all']),
                        get_string('showall', '', $totalcount)
                    ), ['class' => 'paging paging-showall']);
                }
            } else if ($viewmoreurl = $chelper->get_courses_display_option('viewmoreurl')) {
                // The option for 'View more' link was specified, display more link.
                $viewmoretext = $chelper->get_courses_display_option('viewmoretext', new \lang_string('viewmore'));
                $morelink = html_writer::tag(
                    'div',
                    html_writer::link($viewmoreurl, $viewmoretext, ['class' => 'btn btn-secondary']),
                    ['class' => 'paging paging-morelink']
                );
            }
        } else if (($totalcount > $CFG->coursesperpage) && $paginationurl && $paginationallowall) {
            // There are more than one page of results and we are in 'view all' mode, suggest to go back to paginated view mode.
            $pagingbar = html_writer::tag(
                'div',
                html_writer::link(
                    $paginationurl->out(false, ['perpage' => $CFG->coursesperpage]),
                    get_string('showperpage', '', $CFG->coursesperpage)
                ),
                ['class' => 'paging paging-showperpage']
            );
        }
        // Display list of courses.
        $attributes = $chelper->get_and_erase_attributes('courses');
        $content = html_writer::start_tag('div', $attributes);
        if (!empty($pagingbar)) {
            $content .= $pagingbar;
        }
        $coursecount = 1;
        $content .= html_writer::start_tag('div', ['class' => 'card-deck dashboard-card-deck mt-2']);
        foreach ($courses as $course) {
            $content .= $this->coursecat_coursebox($chelper, $course);
            if ($coursecount % 3 == 0) {
                $content .= html_writer::end_tag('div');
                $content .= html_writer::start_tag('div', ['class' => 'card-deck dashboard-card-deck mt-2']);
            }
            $coursecount++;
        }
        $content .= html_writer::end_tag('div');
        if (!empty($pagingbar)) {
            $content .= $pagingbar;
        }
        if (!empty($morelink)) {
            $content .= $morelink;
        }
        $content .= html_writer::end_tag('div'); // End courses.
        return $content;
    }

    /**
     * Displays one course in the list of courses.
     *
     * This is an internal function, to display an information about just one course
     * please use core_course_renderer::course_info_box()
     *
     * @param coursecat_helper $chelper various display options
     * @param core_course_list_element|stdClass $course
     * @param string $additionalclasses additional classes to add to the main <div> tag (usually
     *    depend on the course position in list - first/last/even/odd)
     * @return string
     *
     * @throws \coding_exception
     * @throws \dml_exception
     * @throws \moodle_exception
     */
    protected function coursecat_coursebox(coursecat_helper $chelper, $course, $additionalclasses = '') {
        if (!isset($this->strings->summary)) {
            $this->strings->summary = get_string('summary');
        }
        if ($chelper->get_show_courses() <= self::COURSECAT_SHOW_COURSES_COUNT) {
            return '';
        }
        if ($course instanceof stdClass) {
            $course = new core_course_list_element($course);
        }
        return $this->coursecat_coursebox_content($chelper, $course);
    }

    /**
     * Returns HTML to display course content (summary, course contacts and optionally category name)
     *
     * This method is called from coursecat_coursebox() and may be re-used in AJAX
     *
     * @param coursecat_helper $chelper various display options
     * @param stdClass|core_course_list_element $course
     *
     * @return string
     *
     * @throws \coding_exception
     * @throws \dml_exception
     * @throws \moodle_exception
     */
    protected function coursecat_coursebox_content(coursecat_helper $chelper, $course) {
        if ($course instanceof stdClass) {
            $course = new core_course_list_element($course);
        }
        $courseutil = new course($course);
        $coursecontacts = $courseutil->get_course_contacts();
        $courseenrolmenticons = $courseutil->get_enrolment_icons();
        $courseenrolmenticons = !empty($courseenrolmenticons) ? $this->render_enrolment_icons($courseenrolmenticons) : false;
        $courseprogress = $courseutil->get_progress();
        $hasprogress = $courseprogress != null;

        $metadata = []; // Array de data_controller.
        // Get the custom field handler for courses.
        $handler = \core_course\customfield\course_handler::create();
        // Retrieves all custom field data for the course.
        $customfields = $handler->get_instance_data($course->id, true);
        foreach ($customfields as $fieldcontroller) {
            $field = $fieldcontroller->get_field();
            if ($field->get('type') != 'textarea') {
                $metadata[] = [
                    'id' => $field->get('id'),
                    'name' => $field->get('name'),
                    'value' => $fieldcontroller->get_value(),
                ];
            }
        }
        $data = [
            'id' => $course->id,
            'fullname' => $chelper->get_course_formatted_name($course),
            'visible' => $course->visible,
            'image' => $courseutil->get_summary_image(),
            'summary' => $courseutil->get_summary($chelper),
            'category' => $courseutil->get_category(),
            'customfields' => $courseutil->get_custom_fields(),
            'hasprogress' => $hasprogress,
            'progress' => (int) $courseprogress,
            'hasenrolmenticons' => $courseenrolmenticons != false,
            'enrolmenticons' => $courseenrolmenticons,
            'hascontacts' => !empty($coursecontacts),
            'contacts' => $coursecontacts,
            'courseurl' => $this->get_course_url($course->id),
            'metadata' => $metadata,
        ];
        return $this->render_from_template('theme_govbrds/coursecard', $data);
    }

    /**
     * Returns enrolment icons
     *
     * @param array $icons
     *
     * @return array
     */
    protected function render_enrolment_icons(array $icons): array {
        $data = [];

        foreach ($icons as $icon) {
            $data[] = $this->render($icon);
        }

        return $data;
    }

    /**
     * Returns the course URL based on some criterias.
     *
     * @param int $courseid
     *
     * @return moodle_url
     * @throws \moodle_exception
     */
    private function get_course_url($courseid) {
        if (class_exists('\local_course\output\index')) {
            return new moodle_url('/local/course/index.php', ['id' => $courseid]);
        }
        return new moodle_url('/course/view.php', ['id' => $courseid]);
    }
}
