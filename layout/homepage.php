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
 * A frontpage layout for the GovBR-DS theme
 *
 * @package    theme_govbrds
 * @copyright  2025 Fábio Santos {@link https://www.ifrr.edu.br}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/behat/lib.php');
require_once($CFG->dirroot . '/course/lib.php');

include_once(__DIR__ . '/layout.inc.php');
include_once(__DIR__ . '/images.inc.php');

$templatecontext = $templatecontext + [

    'autocadastro_ativo' => $CFG->registerauth === 'email',

    'herohtml' => get_config('theme_govbrds', 'herohtml'),
    'heroimage' => $OUTPUT->image_url('heroimage', 'theme'),
    'hero_url' => $hero_url,
    'heroimagealt' => get_config('theme_govbrds', 'heroimagealt'),
    'herocta' => get_config('theme_govbrds', 'herocta'),
    'heroctalink' => get_config('theme_govbrds', 'heroctalink'),

];

$themesettings = new \theme_govbrds\util\settings();

$templatecontext = array_merge($templatecontext, $themesettings->footer());
$templatecontext = array_merge($templatecontext, $themesettings->frontpage());

echo $OUTPUT->render_from_template('theme_govbrds/homepage', $templatecontext);
