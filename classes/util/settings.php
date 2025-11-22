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
 * Privacy Subsystem implementation for theme_govbrds.
 *
 * @package    theme_govbrds
 * @copyright  2025 Fábio Santos <fabio.santos@ifrr.edu.br>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_govbrds\util;

use theme_config;

/**
 * Helper to load a theme configuration.
 *
 * @package    theme_govbrds
 * @copyright  2025 Fábio Santos <fabio.santos@ifrr.edu.br>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class settings
{
    /**
     * @var \stdClass $theme The theme object.
     */
    protected $theme;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->theme = theme_config::load('govbrds');
    }

    /**
     * Magic method to get theme settings
     *
     * @param string $name
     *
     * @return false|string|null
     */
    public function __get(string $name)
    {

        if (empty($this->theme->settings->$name)) {
            return false;
        }

        return $this->theme->settings->$name;
    }

    /**
     * Get footer settings
     *
     * @return array
     */
    public function footer()
    {
        global $CFG;

        $templatecontext = [];

        $settings = [
            'tiktok', 'facebook', 'twitter', 'linkedin', 'youtube', 'instagram'
        ];

        $templatecontext['hasfootercontact'] = false;
        $templatecontext['hasfootersocial'] = false;
        foreach ($settings as $setting) {
            $templatecontext[$setting] = $this->$setting;

            if (in_array($setting, ['website', 'mobile', 'mail']) && !empty($templatecontext[$setting])) {
                $templatecontext['hasfootercontact'] = true;
            }

            $socialsettings = [
                'facebook', 'twitter', 'linkedin', 'youtube', 'instagram', 'whatsapp', 'telegram', 'tiktok', 'pinterest'
            ];

            if (in_array($setting, $socialsettings) && !empty($templatecontext[$setting])) {
                $templatecontext['hasfootersocial'] = true;
            }
        }

        $templatecontext['enablemobilewebservice'] = $CFG->enablemobilewebservice;

        if ($CFG->enablemobilewebservice) {
            $iosappid = get_config('tool_mobile', 'iosappid');
            if (!empty($iosappid)) {
                $templatecontext['iosappid'] = $iosappid;
            }

            $androidappid = get_config('tool_mobile', 'androidappid');
            if (!empty($androidappid)) {
                $templatecontext['androidappid'] = $androidappid;
            }

            $setuplink = get_config('tool_mobile', 'setuplink');
            if (!empty($setuplink)) {
                $templatecontext['mobilesetuplink'] = $setuplink;
            }
        }

        return $templatecontext;
    }

    /**
     * Get frontpage settings
     *
     * @return array
     */
    public function frontpage()
    {
        return array_merge(
            $this->frontpage_features()
        );
    }


    /**
     * Get config theme features
     *
     * @return array
     */
    public function frontpage_features()
    {
        if ($templatecontext['display_features'] = $this->features) {
            $templatecontext['featuresheading'] = format_text($this->featuresheading, FORMAT_HTML);
            $templatecontext['featurescontent'] = format_text($this->featurescontent, FORMAT_HTML);


            for ($i = 1, $j = 0; $i < 5; $i++, $j++) {
                $featureicon = 'feature' . $i . 'icon';
                $featureheading = 'feature' . $i . 'heading';
                $featurecontent = 'feature' . $i . 'content';
                $feature_btntext = 'feature' . $i . '_btntext';
                $feature_btnurl = 'feature' . $i . '_btnurl';

                $templatecontext['features'][$j]['icon'] = $this->$featureicon ?
                    $this->$featureicon : 'fa-id-card';
                $templatecontext['features'][$j]['heading'] = $this->$featureheading ?
                    format_text($this->$featureheading, FORMAT_HTML) : 'Lorem';
                $templatecontext['features'][$j]['content'] = $this->$featurecontent ?
                    format_text($this->$featurecontent, FORMAT_HTML) :
                    'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.';

                $templatecontext['features'][$j]['btntext'] = $this->$feature_btntext;
                $templatecontext['features'][$j]['btnurl'] = $this->$feature_btnurl;

            }
        }

        return $templatecontext;
    }

}
