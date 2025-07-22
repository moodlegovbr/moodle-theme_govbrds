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
 * GovBR-DS Lib
 *
 * @package    theme
 * @subpackage govbrds
 * @copyright  2018 Fábio Santos {@link https://www.ifrr.edu.br}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


function theme_govbrds_get_main_scss_content($theme) {
    global $CFG;
    $scss = file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    return $scss;
}

function theme_govbrds_user_preferences(): array {
    return [
        'your_preference_name' => [
            'type' => PARAM_ALPHA,
            'null' => NULL_NOT_ALLOWED,
            'default' => false,
            'permissioncallback' => [core_user::class, 'is_current_user'],
        ]
    ];
}
