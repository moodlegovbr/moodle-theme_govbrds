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
 * GovBR-DS Theme functions.
 *
 * @package    theme_govbrds
 * @copyright  2025 Fábio Santos <fabio.santos@ifrr.edu.br>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Get the main SCSS content for the govbrds theme.
 *
 * This function loads the default SCSS preset file used by the govbrds theme
 * and returns its contents as a string. Moodle uses this SCSS to compile
 * the theme’s CSS during rendering.
 *
 * @param theme_config $theme The theme configuration object (currently unused).
 * @return string The SCSS content from the default preset file.
 */
function theme_govbrds_get_main_scss_content($theme) {
    global $CFG;
    $scss = file_get_contents($CFG->dirroot . '/theme/govbrds/scss/preset/default.scss');
    return $scss;
}

/**
 * Defines user preferences for the theme_govbrds plugin.
 *
 * This function registers custom user preferences that can be stored
 * and retrieved by Moodle's user preference system. Each preference
 * includes validation rules, default values, and permission checks.
 *
 * @return array An associative array of user preference definitions,
 *               keyed by preference name. Each definition includes:
 *               - type (PARAM_* constant): Validation type
 *               - null (NULL_ALLOWED/NULL_NOT_ALLOWED): Whether null is permitted
 *               - default (mixed): Default value if none is set
 *               - permissioncallback (callable): Function to check access permissions
 */
function theme_govbrds_user_preferences(): array {
    return [
        'your_preference_name' => [
            'type' => PARAM_ALPHA,
            'null' => NULL_NOT_ALLOWED,
            'default' => false,
            'permissioncallback' => [core_user::class, 'is_current_user'],
        ],
    ];
}

/**
 * Serves theme files for the theme_govbrds plugin.
 *
 * This function is responsible for delivering files stored in specific
 * file areas of the theme (such as logo, partners, and heroimage).
 * It restricts access to the system context and ensures only allowed
 * file areas are served. If the requested file does not exist or the
 * context/filearea is invalid, a "file not found" response is sent.
 *
 * @param stdClass      $course        The course object (unused in this context).
 * @param stdClass|null $cm            The course module object (unused in this context).
 * @param context       $context       The context in which the file is requested.
 * @param string        $filearea      The file area name (only 'logo', 'partners', 'heroimage' allowed).
 * @param array         $args          Arguments that define the file path and name.
 * @param bool          $forcedownload Whether the file should be forced to download.
 * @param array         $options       Additional options affecting file serving.
 *
 * @return void
 */
function theme_govbrds_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    // Allow access only within the context of the system and for specific areas.
    if ($context->contextlevel !== CONTEXT_SYSTEM || !in_array($filearea, ['logo', 'partners', 'heroimage'])) {
        send_file_not_found();
    }

    $itemid = array_shift($args);
    $filename = array_pop($args);
    $filepath = $args ? '/' . implode('/', $args) . '/' : '/';

    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'theme_govbrds', $filearea, $itemid, $filepath, $filename);

    if (!$file) {
        send_file_not_found();
    }

    send_stored_file($file, null, 0, $forcedownload, $options);
}

/**
 * Initializes page settings for the theme_govbrds plugin.
 *
 * This function customizes the page layout for specific Moodle page types.
 * In particular, it applies a custom layout when the enrolment index page
 * (`enrol-index`) is being displayed, ensuring that the theme uses the
 * appropriate landing page layout.
 *
 * @param moodle_page $page The Moodle page object being initialized.
 *
 * @return void
 */
function theme_govbrds_page_init(moodle_page $page) {
    // Force enrol-index layout for enrolment pages.
    if ($page->pagetype === 'enrol-index') {
        $page->set_pagelayout('enrol-index'); // Use the landingpage layout.
    }
}
