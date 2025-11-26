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

namespace theme_govbrds\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\request\user_preference_provider;

/**
 * Privacy provider class for this plugin.
 *
 * Implements metadata and user preference export functionality
 * required by Moodle's privacy subsystem.
 *
 * @package   theme_govbrds
 * @category  privacy
 */
class provider implements
    \core_privacy\local\metadata\provider,
    user_preference_provider {
    /**
     * Returns metadata about this plugin's stored data.
     *
     * @param \core_privacy\local\metadata\collection $items The collection to add metadata to.
     * @return \core_privacy\local\metadata\collection Updated collection of metadata.
     */
    public static function get_metadata(collection $items): collection {
        $items->add_user_preference(
            'govbrds_user_setting',
            'privacy:metadata:govbrds_user_setting'
        );
        return $items;
    }

    /**
     * Exports user preferences for this plugin.
     *
     * @param int $userid The user ID whose preferences are to be exported.
     * @return void
     */
    public static function export_user_preferences(int $userid) {
        $value = get_user_preferences('yourtheme_user_setting', null, $userid);
        if ($value !== null) {
            \core_privacy\local\request\writer::export_user_preference(
                'theme_govbrds',
                'govbrds_user_setting',
                $value,
                get_string('privacy:metadata:govbrds_user_setting', 'theme_govbrds')
            );
        }
    }
}
