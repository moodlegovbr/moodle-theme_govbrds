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
 * GovBR-DS Login Settings
 *
 * @package    theme_govbrds
 * @copyright  2025 Fábio Santos <fabio.santos@ifrr.edu.br>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

/*
* --------------------
* Login settings tab links to another Moodle instance
* --------------------
*/
$page = new admin_settingpage('theme_govbrds_login', get_string('loginsettings', 'theme_govbrds'));

// TAB-1 url setting.
$name = 'theme_govbrds/tab';
$title = get_string('tab', 'theme_govbrds');
$description = get_string('tabdesc', 'theme_govbrds');
$setting = new admin_setting_configtextarea($name, $title, $description, '');
$page->add($setting);

$settings->add($page);
