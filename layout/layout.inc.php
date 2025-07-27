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
 * GovBR-DS Layout
 *
 * @package    theme
 * @subpackage govbrds
 * @copyright  2018 Fábio Santos {@link https://www.ifrr.edu.br}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/*
 * user_preference_allow_ajax_update() is deprecated. Please use the "core_user/repository" module instead.
 * user_preference_allow_ajax_update('drawer-open-nav', PARAM_ALPHA);
 */

require_once($CFG->libdir . '/behat/lib.php');

if (isloggedin()) {
    $navdraweropen = (get_user_preferences('drawer-open-nav', 'true') == 'true');
} else {
    $navdraweropen = false;
}
$extraclasses = [];
if ($navdraweropen) {
    $extraclasses[] = 'drawer-open-left';
}
$bodyattributes = $OUTPUT->body_attributes($extraclasses);

$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = strpos($blockshtml, 'data-block=') !== false;

$homeleftblock = $OUTPUT->blocks('home-left');
$homelefthasblocks = strpos($homeleftblock, 'data-block=') !== false;

$homemiddleblock = $OUTPUT->blocks('home-middle');
$homemiddlehasblocks = strpos($homemiddleblock, 'data-block=') !== false;

$homerightblock = $OUTPUT->blocks('home-right');
$homerighthasblocks = strpos($homerightblock, 'data-block=') !== false;

$regionmainsettingsmenu = $OUTPUT->region_main_settings_menu();

$container = get_config('theme_govbrds', 'layout')?'container-fluid':'container';

$primary = new core\navigation\output\primary($PAGE);
$renderer = $PAGE->get_renderer('core');
$primarymenu = $primary->export_for_template($renderer);

$templatecontext = [
    // GovBRDS
    'fullname' => format_string($SITE->fullname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'shortname' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'organization' => get_config('theme_govbrds', 'organization'),
    'subordination' => get_config('theme_govbrds', 'subordination'),
    'addressm' => get_config('theme_govbrds', 'addressm'),
    'container' => $container,
    'brand' => $OUTPUT->image_url('ifrr-brand','theme_govbrds'),
    'barracodigo' => get_config('theme_govbrds', 'barracodigo'),
    'googlemetasearch' => get_config('theme_govbrds', 'googlemetasearch'),


    //Boost
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,

    'sidepreblocks' => $blockshtml,
    'hasblocks' => $hasblocks,
    'usermenu' => $primarymenu['user'],
    'langmenu' => $primarymenu['lang'],

    'bodyattributes' => $bodyattributes,
    'navdraweropen' => $navdraweropen,
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),

];

/* 
 * Flat navigation has been deprecated in favour of primary/secondary navigation concepts
 * $templatecontext['flatnavigation'] = $PAGE->flatnav;
 */

$templatecontext['primarynavigation'] = $PAGE->primarynav;
$templatecontext['secondarynavigation'] = $PAGE->secondarynav;

$PAGE->requires->js_call_amd('theme_govbrds/govbr', 'init');