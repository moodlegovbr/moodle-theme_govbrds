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
 * GovBR-DS Login Page
 *
 * @package    theme_govbrds
 * @copyright  2018-2026 Fábio Santos {@link https://www.ifrr.edu.br}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined("MOODLE_INTERNAL") || die();

$bodyattributes = $OUTPUT->body_attributes();

$lines = explode("\n", trim(get_config("theme_govbrds", "tab")));
$tabs = [];

foreach ($lines as $line) {
    $cols = explode("|", $line);
    $name = trim($cols[0] ?? "");
    $url = trim($cols[1] ?? "");
    $tooltip = trim($cols[2] ?? "");

    if ($name && $url) {
        $tabs[] = [
            "name" => $name,
            "url" => $url,
            "tooltip" => $tooltip,
        ];
    }
}

$templatecontext = [
    // GOvBRDS.
    "tabs" => $tabs,
    "fullname" => format_string($SITE->fullname, true, [
        "context" => context_course::instance(SITEID),
        "escape" => false,
    ]),
    "organization" => get_config("theme_govbrds", "organization"),
    "organization_url" => get_config("theme_govbrds", "organization_url"),
    "addressm" => get_config("theme_govbrds", "addressm"),

    // Boost.
    "sitename" => format_string($SITE->shortname, true, [
        "context" => context_course::instance(SITEID),
        "escape" => false,
    ]),
    "output" => $OUTPUT,
    "bodyattributes" => $bodyattributes,
];

echo $OUTPUT->render_from_template("theme_govbrds/login", $templatecontext);
