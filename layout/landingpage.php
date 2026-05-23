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
 * A frontpage layout for the GovBR-DS theme
 *
 * @package    theme_govbrds
 * @copyright  2018-2026 Fábio Santos {@link https://www.ifrr.edu.br}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/behat/lib.php');
require_once($CFG->dirroot . '/course/lib.php');

require_once(__DIR__ . '/layout.inc.php');
require_once(__DIR__ . '/images.inc.php');

$course = get_course($COURSE->id);
$data = \core_course\customfield\course_handler::create()->get_instance_data($course->id);
$content = [];

$customfields = []; // Array of data_controller.

foreach ($data as $fieldcontroller) {
    $field = $fieldcontroller->get_field();
    if ($field->get('type') == 'textarea') {
        $customfields[] = [
            'id' => $field->get('id'),
            'name' => $field->get('name'),
            'value' => $fieldcontroller->get_value(),
        ];
    }
}

$templatecontext = $templatecontext + [
    'course' => $COURSE,
    'fields' => $customfields,
];

$startdate = $COURSE->startdate;
$enddate = $COURSE->enddate ?? null;

if ($startdate) {
    $templatecontext['startdate'] = userdate($startdate, get_string('strftimedate', 'langconfig'));
}
if ($enddate) {
    $templatecontext['enddate'] = userdate($enddate, get_string('strftimedate', 'langconfig'));
}

// Search for other courses in the same category.
$relatedcourses = get_courses($course->category, 'fullname ASC', 'c.id, c.fullname, c.summary');

// Filter the current course.
$relatedcourses = array_filter($relatedcourses, function ($c) use ($course) {
    return $c->id !== $course->id;
});

// Convert to indexed array, randomize and limit to 3 courses from same category.
$relatedcourses = array_values($relatedcourses);
shuffle($relatedcourses);
$relatedcourses = array_slice($relatedcourses, 0, 3);

$relatedcoursesformatted = [];
foreach ($relatedcourses as $c) {
    $relatedcoursesformatted[] = [
        'id' => $c->id,
        'fullname' => format_string($c->fullname),
        'url' => (new moodle_url('/course/view.php', ['id' => $c->id]))->out(false),
    ];
}

$templatecontext['relatedcourses'] = $relatedcoursesformatted;
$teachercontext = context_course::instance($course->id);
$fields = 'u.id, u.firstname, u.lastname, u.email, u.picture, u.imagealt,'
    . ' u.firstnamephonetic, u.lastnamephonetic, u.middlename, u.alternatename';
$teacherlist = [];
$seen = [];
foreach ([3, 4] as $roleid) { // Role IDs: editing teacher and teacher.
    foreach (get_role_users($roleid, $teachercontext, false, $fields) as $user) {
        if (!isset($seen[$user->id])) {
            $seen[$user->id] = true;
            $userutil = new \theme_govbrds\util\user($user);
            $teacherlist[] = [
                'fullname' => fullname($user),
                'picture'  => $userutil->get_user_picture(100),
            ];
        }
    }
}
$count = count($teacherlist);
$templatecontext['teachers'] = $teacherlist;
$templatecontext['teacherlabel'] = get_string($count === 1 ? 'teacher' : 'teachers', 'theme_govbrds');
echo $OUTPUT->render_from_template('theme_govbrds/landingpage', $templatecontext);
echo $OUTPUT->standard_footer_html();
echo $OUTPUT->standard_end_of_body_html();
