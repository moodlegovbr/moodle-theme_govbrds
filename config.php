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
 * GovBR-DS Config
 *
 * @package    theme
 * @subpackage govbrds
 * @copyright  2018 Fábio Santos {@link https://www.ifrr.edu.br}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/lib.php');

$THEME->name = 'govbrds';
$THEME->sheets = [];
$THEME->editor_sheets = [];
$THEME->parents = ['boost'];
$THEME->haseditswitch = false;
$THEME->enable_dock = false;
$THEME->yuicssmodules = array();
$THEME->rendererfactory = 'theme_overridden_renderer_factory';
$THEME->requiredblocks = '';
$THEME->addblockposition = BLOCK_ADDBLOCK_POSITION_FLATNAV;

$THEME->sheets = array(
    'core',
);


$THEME->scss = function($theme) {
    return theme_govbrds_get_main_scss_content($theme);
};

$THEME->layouts = [
    // The site home page.
    'frontpage' => array(
        'file' => 'frontpage.php',
        'regions' => array('side-pre',
            'home-left', 'home-middle', 'home-right',
            'footer-left', 'footer-middle', 'footer-right'),
        'defaultregion' => 'side-pre',
        'options' => array('nonavbar' => true),
    ),
];