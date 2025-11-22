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
 * @copyright  2018 Fábio Santos {@link https://www.ifrr.edu.br}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/behat/lib.php');
require_once($CFG->dirroot . '/course/lib.php');

include_once(__DIR__ . '/layout.inc.php');
include_once(__DIR__ . '/images.inc.php');

$course = get_course($COURSE->id);
$data = \core_course\customfield\course_handler::create()->get_instance_data($course->id);
$content = [];

$customfields = []; // array de data_controller

foreach ($data as $fieldcontroller) {
    $field = $fieldcontroller->get_field(); // field_controller
    if ($field->get('type') == 'textarea') {
        $customfields[] = [
            'id' => $field->get('id'),
            'name' => $field->get('name'),
            'value' => $fieldcontroller->get_value()
        ];
    }
}

$templatecontext = $templatecontext + [
    'course' => $COURSE,
    'fields' => $customfields
];

$startdate = $COURSE->startdate;
$enddate = $COURSE->enddate ?? null; // enddate pode não estar definido

if ($startdate) {
    $templatecontext['startdate'] = userdate($startdate, get_string('strftimedate', 'langconfig'));
}
if ($enddate) {
    $templatecontext['enddate'] = userdate($enddate, get_string('strftimedate', 'langconfig'));
}

// Search for other courses in the same category
$relatedcourses = get_courses($course->category, 'fullname ASC', 'c.id, c.fullname, c.summary');

// Filter the current course
$relatedcourses = array_filter($relatedcourses, function ($c) use ($course) {
    return $c->id !== $course->id;
});

$templatecontext['relatedcourses'] = $relatedcourses ;
if (!empty($courseid)) {

    $context = context_course::instance($courseid);
    $teachers = get_role_users(3, $context, false, 'u.id, u.firstname, u.lastname, u.email');
    $templatecontext['teachers'] = $teachers;
}
echo $OUTPUT->render_from_template('theme_govbrds/landingpage', $templatecontext);
echo $OUTPUT->standard_footer_html();
echo $OUTPUT->standard_end_of_body_html();
