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
 * GovBR-DS General Settings
 *
 * @package    theme
 * @subpackage govbrds
 * @copyright  2025 Fábio Santos {@link https://www.ifrr.edu.br}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

/*
* ----------------------
* Homepage settings tab
* ----------------------
*/
$page = new admin_settingpage('theme_govbrds_homepage', get_string('homepage_settings', 'theme_govbrds'));

// Field Richtext (HTML editor).
$page->add(new admin_setting_confightmleditor(
    'theme_govbrds/herohtml',
    get_string('herohtml', 'theme_govbrds'),
    get_string('herohtml_desc', 'theme_govbrds'),
    '<h1>Bem-vindo ao Moodle</h1><p>Texto inicial da sua hero section.</p>'
));

// Field upload image.
$page->add(new admin_setting_configstoredfile(
    'theme_govbrds/heroimage',
    get_string('heroimage', 'theme_govbrds'),
    get_string('heroimage_desc', 'theme_govbrds'),
    'heroimage' // Internal ID of file
));

$setting->set_updatedcallback('theme_reset_all_caches');
$settings->add($page);