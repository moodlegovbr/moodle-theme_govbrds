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

// Add block button in editing mode.
$addblockbutton = $OUTPUT->addblockbutton();

if (isloggedin()) {
    $courseindexopen = (get_user_preferences('drawer-open-index', true) == true);
    $blockdraweropen = (get_user_preferences('drawer-open-block') == true);
} else {
    $courseindexopen = false;
    $blockdraweropen = false;
}

if (defined('BEHAT_SITE_RUNNING') && get_user_preferences('behat_keep_drawer_closed') != 1) {
    $blockdraweropen = true;
}

$extraclasses = ['uses-drawers'];
if ($courseindexopen) {
    $extraclasses[] = 'drawer-open-index';
}

$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = (strpos($blockshtml, 'data-block=') !== false || !empty($addblockbutton));
if (!$hasblocks) {
    $blockdraweropen = false;
}
$courseindex = core_course_drawer();
if (!$courseindex) {
    $courseindexopen = false;
}

$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$forceblockdraweropen = $OUTPUT->firstview_fakeblocks();

$secondarynavigation = false;
$overflow = '';
if ($PAGE->has_secondary_navigation()) {
    $tablistnav = $PAGE->has_tablist_secondary_navigation();
    $moremenu = new \core\navigation\output\more_menu($PAGE->secondarynav, 'nav-tabs', true, $tablistnav);
    $secondarynavigation = $moremenu->export_for_template($OUTPUT);
    $overflowdata = $PAGE->secondarynav->get_overflow_menu_data();
    if (!is_null($overflowdata)) {
        $overflow = $overflowdata->export_for_template($OUTPUT);
    }
}

$primary = new core\navigation\output\primary($PAGE);
$renderer = $PAGE->get_renderer('core');
$primarymenu = $primary->export_for_template($renderer);
$buildregionmainsettings = !$PAGE->include_region_main_settings_in_header_actions() && !$PAGE->has_secondary_navigation();
// If the settings menu will be included in the header then don't add it here.
$regionmainsettingsmenu = $buildregionmainsettings ? $OUTPUT->region_main_settings_menu() : false;

$header = $PAGE->activityheader;
$headercontent = $header->export_for_template($renderer);

$context = context_system::instance();
$fs = get_file_storage();
$files = $fs->get_area_files($context->id, 'theme_govbrds', 'logo', 0, 'itemid, filepath, filename', false);

if ($files) {
    $file = reset($files);
    $url = moodle_url::make_pluginfile_url(
        $file->get_contextid(),
        $file->get_component(),
        $file->get_filearea(),
        $file->get_itemid(),
        $file->get_filepath(),
        $file->get_filename()
    );
}

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

include_once(__DIR__ . '/images.php');

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'fullname' => format_string($SITE->fullname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    
    'logo' => $logo_url,

    'partners_url' => $partners_url,

    'organization' => get_config('theme_govbrds', 'organization'),

    'subordination' => get_config('theme_govbrds', 'subordination'),

    'addressm' => get_config('theme_govbrds', 'addressm'),

    'output' => $OUTPUT,
    'sidepreblocks' => $blockshtml,
    'hasblocks' => $hasblocks,
    'bodyattributes' => $bodyattributes,
    'courseindexopen' => $courseindexopen,
    'blockdraweropen' => $blockdraweropen,
    'courseindex' => $courseindex,
    'primarymoremenu' => $primarymenu['moremenu'],
    'secondarymoremenu' => $secondarynavigation ?: false,
    'mobileprimarynav' => $primarymenu['mobileprimarynav'],
    'usermenu' => $primarymenu['user'],
    'langmenu' => $primarymenu['lang'],
    'forceblockdraweropen' => $forceblockdraweropen,
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
    'overflow' => $overflow,
    'headercontent' => $headercontent,
    'addblockbutton' => $addblockbutton,

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
$relatedcourses = array_filter($relatedcourses, function($c) use ($course) {
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