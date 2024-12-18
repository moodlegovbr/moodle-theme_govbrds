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
 * GovBR-DS Acessibilidade
 *
 * @package    theme
 * @subpackage govbrds
 * @copyright  2018 Fábio Santos {@link https://www.ifrr.edu.br}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');
require_once('../lib.php');

$PAGE->set_context(context_system::instance());
$thispageurl = new moodle_url('/theme/govbrds/pages/acessibilidade.php');
$PAGE->set_context(get_system_context());
$PAGE->set_pagelayout('admin');
$PAGE->set_title("Acessibilidade");
$PAGE->set_heading("Acessibilidade"); // colocar um titulo em cima
$PAGE->set_url($thispageurl, $thispageurl->params());
$PAGE->set_docs_path('');
$PAGE->set_pagelayout('standard');

echo $OUTPUT->header();
echo get_config('theme_govbrds', 'acessibilidade');
echo $OUTPUT->footer();
