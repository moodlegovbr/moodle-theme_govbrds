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
 * @copyright  2018 Fábio Santos <fabio.santos@ifrr.edu.br>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This is used for performance, we don't need to know about these settings on every page in Moodle, only when
// we are looking at the admin settings pages.
defined('MOODLE_INTERNAL') || die();



// Boost provides a nice setting page which splits settings onto separate tabs. We want to use it here.
$settings = new theme_boost_admin_settingspage_tabs('themesettinggovbrds',
    get_string('configtitle', 'theme_govbrds'));


/*
* ----------------------
* General settings tab
* ----------------------
*/

$page = new admin_settingpage('theme_govbrds_general', get_string('generalsettings', 'theme_govbrds'));

// Organization.
$setting = new admin_setting_configtext('theme_govbrds/organization', get_string('organization',
    'theme_govbrds'), get_string('organization_desc', 'theme_govbrds'), 'University Demo',
    PARAM_RAW);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Organization URL.
$setting = new admin_setting_configtext('theme_govbrds/organization_url', get_string('organization_url',
    'theme_govbrds'), get_string('organization_url_desc', 'theme_govbrds'), 'https://www.universitydemo.com',
    PARAM_RAW);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// List Courses Title.
$setting = new admin_setting_configtext('theme_govbrds/listcoursestitle', get_string('listcoursestitle',
    'theme_govbrds'), get_string('listcoursestitle_desc', 'theme_govbrds'), 'Our Courses',
    PARAM_RAW);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Footer.
$setting = new admin_setting_confightmleditor('theme_govbrds/addressm', get_string('addressm',
    'theme_govbrds'), get_string('addressm_desc', 'theme_govbrds'), '',
    PARAM_RAW);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Fix or Fluid Layout.
$setting = new admin_setting_configcheckbox('theme_govbrds/layout', get_string('layout',
    'theme_govbrds'), get_string('layout_desc', 'theme_govbrds'), 'Fluid', 'Fluid', 'Fixed');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Variable $brand-color.
// We use an empty default value because the default colour should come from the preset.
$name = 'theme_govbrds/brandcolor';
$title = get_string('brandcolor', 'theme_govbrds');
$description = get_string('brandcolor_desc', 'theme_govbrds');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$settings->add($page);
