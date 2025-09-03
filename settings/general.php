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
 * @copyright  2018 Fábio Santos {@link https://www.ifrr.edu.br}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$settings = new theme_boost_admin_settingspage_tabs('themesettinggovbrds',
    get_string('configtitle', 'theme_govbrds'));

$page = new admin_settingpage('theme_govbrds_general', get_string('generalsettings', 'theme_govbrds'));

// Organization.
$setting = new admin_setting_configtext('theme_govbrds/organization', get_string('organization',
    'theme_govbrds'), get_string('organization_desc', 'theme_govbrds'), 'Sitename here',
    PARAM_RAW);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Subordination.
$setting = new admin_setting_configtext('theme_govbrds/subordination', get_string('subordination',
    'theme_govbrds'), get_string('subordination_desc', 'theme_govbrds'), 'Site subordination here',
    PARAM_RAW);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Footer Manual.
$setting = new admin_setting_confightmleditor('theme_govbrds/addressm', get_string('addressm',
    'theme_govbrds'), get_string('addressm_desc', 'theme_govbrds'), '',
    PARAM_RAW);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Layout Fix or Fluid.
$setting = new admin_setting_configcheckbox('theme_govbrds/layout', get_string('layout',
    'theme_govbrds'), get_string('layout_desc', 'theme_govbrds'), 'Fluid', 'Fluid', 'Fixed');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Accessibility.
$setting = new admin_setting_confightmleditor('theme_govbrds/accessibility', get_string('accessibility',
    'theme_govbrds'), get_string('accessibility_desc', 'theme_govbrds'), '',
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

$name = 'theme_govbrds/preset';
$title = get_string('preset', 'theme_govbrds');
$description = get_string('preset_desc', 'theme_govbrds');
$default = 'template-verde.scss';

$context = context_system::instance();
$fs = get_file_storage();
$files = $fs->get_area_files($context->id, 'theme_govbrds', 'preset', 0,
    'itemid, filepath, filename', false);

$choices = [];
foreach ($files as $file) {
    $choices[$file->get_filename()] = $file->get_filename();
}

$choices['template-verde'] = 'template-verde';
$choices['template-amarelo'] = 'template-amarelo';
$choices['template-azul'] = 'template-azul';
$choices['template-branco'] = 'template-branco';

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