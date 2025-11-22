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
 * @package    theme_govbrds
 * @copyright  2025 Fábio Santos <fabio.santos@ifrr.edu.br>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

/*
* --------------------
* Social settings tab
* --------------------
*/
$page = new admin_settingpage('theme_govbrds_social', get_string('socialsettings', 'theme_govbrds'));


// TikTok url setting.
$name = 'theme_govbrds/tiktok';
$title = get_string('tiktok', 'theme_govbrds');
$description = get_string('tiktokdesc', 'theme_govbrds');
$setting = new admin_setting_configtext($name, $title, $description, '');
$page->add($setting);

// Facebook url setting.
$name = 'theme_govbrds/facebook';
$title = get_string('facebook', 'theme_govbrds');
$description = get_string('facebookdesc', 'theme_govbrds');
$setting = new admin_setting_configtext($name, $title, $description, '');
$page->add($setting);

// Twitter url setting.
$name = 'theme_govbrds/twitter';
$title = get_string('twitter', 'theme_govbrds');
$description = get_string('twitterdesc', 'theme_govbrds');
$setting = new admin_setting_configtext($name, $title, $description, '');
$page->add($setting);

// Linkdin url setting.
$name = 'theme_govbrds/linkedin';
$title = get_string('linkedin', 'theme_govbrds');
$description = get_string('linkedindesc', 'theme_govbrds');
$setting = new admin_setting_configtext($name, $title, $description, '');
$page->add($setting);

// Youtube url setting.
$name = 'theme_govbrds/youtube';
$title = get_string('youtube', 'theme_govbrds');
$description = get_string('youtubedesc', 'theme_govbrds');
$setting = new admin_setting_configtext($name, $title, $description, '');
$page->add($setting);

// Instagram url setting.
$name = 'theme_govbrds/instagram';
$title = get_string('instagram', 'theme_govbrds');
$description = get_string('instagramdesc', 'theme_govbrds');
$setting = new admin_setting_configtext($name, $title, $description, '');
$page->add($setting);

$settings->add($page);
