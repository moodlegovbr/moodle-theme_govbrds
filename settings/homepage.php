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

// Alt image.
$setting = new admin_setting_configtext(
    'theme_govbrds/heroimagealt',
    get_string(
        'heroimagealt',
        'theme_govbrds'
    ),
    get_string('heroimagealt_desc', 'theme_govbrds'),
    '',
    PARAM_RAW
);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Hero CTA.
$setting = new admin_setting_configtext(
    'theme_govbrds/herocta',
    get_string(
        'herocta',
        'theme_govbrds'
    ),
    get_string('herocta_desc', 'theme_govbrds'),
    '',
    PARAM_RAW
);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Hero Link.
$setting = new admin_setting_configtext(
    'theme_govbrds/heroctalink',
    get_string(
        'heroctalink',
        'theme_govbrds'
    ),
    get_string('heroctalink_desc', 'theme_govbrds'),
    '',
    PARAM_RAW
);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$setting = new admin_setting_heading('separator', '', '<hr>');
$page->add($setting);

$setting->set_updatedcallback('theme_reset_all_caches');

$name = 'theme_govbrds/features';
$title = get_string('features', 'theme_govbrds');
$description = get_string('featuresdesc', 'theme_govbrds');
$default = 1;
$choices = [0 => get_string('no'), 1 => get_string('yes')];
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$page->add($setting);

$features = get_config('theme_govbrds', 'features');

if ($features) {

    // featuresheading.
    $name = 'theme_govbrds/featuresheading';
    $title = get_string('featuresheading', 'theme_govbrds');
    $default = 'Awesome App Features';
    $setting = new admin_setting_configtext($name, $title, '', $default);
    $page->add($setting);

    // featurescontent.
    $name = 'theme_govbrds/featurescontent';
    $title = get_string('featurescontent', 'theme_govbrds');
    $default = 'govbrds is a Moodle template based on Boost with modern and creative design.';
    $setting = new admin_setting_confightmleditor($name, $title, '', $default);
    $page->add($setting);

    for ($i = 1; $i < 5; $i++) {

        $icons = [
            'fa-id-card' => 'ID Card',
            'fa-hand-pointer' => 'Pointer',
            'fa-calendar' => 'Calendar',
            'fa-certificate' => 'Certificate',
        ];
        $name = "theme_govbrds/feature{$i}icon";
        $title = get_string('featureicon', 'theme_govbrds', $i . '');
        $default = 'fa-id-card';
        $setting = new admin_setting_configselect($name, $title, '', $default, $icons);

        $page->add($setting);

        $name = "theme_govbrds/feature{$i}heading";
        $title = get_string('featureheading', 'theme_govbrds', $i . '');
        $default = 'Lorem';
        $setting = new admin_setting_configtext($name, $title, '', $default);
        $page->add($setting);

        $name = "theme_govbrds/feature{$i}content";
        $title = get_string('featurecontent', 'theme_govbrds', $i . '');
        $default = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.';
        $setting = new admin_setting_confightmleditor($name, $title, '', $default);
        $page->add($setting);

        // Button Text.
        $setting = new admin_setting_configtext(
            "theme_govbrds/feature{$i}_btntext",
            get_string(
                'feature_btntext',
                'theme_govbrds'
            ),
            get_string('feature_btntext_desc', 'theme_govbrds'),
            '',
            PARAM_RAW
        );
        $page->add($setting);

        // Button Link.
        $setting = new admin_setting_configtext(
            "theme_govbrds/feature{$i}_btnurl",
            get_string(
                'feature_btnurl',
                'theme_govbrds'
            ),
            get_string('feature_btnurl_desc', 'theme_govbrds'),
            '',
            PARAM_RAW
        );
        $page->add($setting);

    }
    $setting = new admin_setting_heading('displayfeaturesseparator', '', '<hr>');
    $page->add($setting);
}


$settings->add($page);
