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
 * @copyright  2018 Fábio Santos {@link https://www.ifrr.edu.br}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$settings = new theme_boost_admin_settingspage_tabs('themesettinggovbrds',
    get_string('configtitle', 'theme_govbrds'));

$page = new admin_settingpage('theme_govbrds_general', get_string('generalsettings', 'theme_govbrds'));


// Logo da organização.
$name = 'theme_govbrds/logo';
$title = get_string('logo', 'theme_govbrds');
$description = get_string('logo_desc', 'theme_govbrds');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

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

// Rodapé Manual.
$setting = new admin_setting_confightmleditor('theme_govbrds/addressm', get_string('addressm',
    'theme_govbrds'), get_string('addressm_desc', 'theme_govbrds'), '',
    PARAM_RAW);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Layout Fixo ou Fluid.
$setting = new admin_setting_configcheckbox('theme_govbrds/layout', get_string('layout',
    'theme_govbrds'), get_string('layout_desc', 'theme_govbrds'), 'Fluid', 'Fluid', 'Fixed');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Acessibilidade.
$setting = new admin_setting_confightmleditor('theme_govbrds/acessibilidade', get_string('acessibilidade',
    'theme_govbrds'), get_string('acessibilidade_desc', 'theme_govbrds'), '',
    PARAM_RAW);
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


// Código da Instituição para a Barra do Governo.
$setting = new admin_setting_configtext('theme_govbrds/barracodigo', get_string('barracodigo',
    'theme_govbrds'), get_string('barracodigo_desc', 'theme_govbrds'), '',
    PARAM_RAW);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Tag Meta para o Google Search Console.
$setting = new admin_setting_configtext('theme_govbrds/googlemetasearch', get_string('googlemetasearch',
    'theme_govbrds'), get_string('googlemetasearch_desc', 'theme_govbrds'), '',
    PARAM_RAW);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$settings->add($page);