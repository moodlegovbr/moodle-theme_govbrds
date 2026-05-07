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
 * CLI script to create test courses in Moodle.
 *
 * Cria categorias na raiz (parent=0) para cada disciplina e
 * distribui os cursos nelas.
 *
 * Use:
 * php create_courses_test.php --quantity=50
 *
 * @package    theme_govbrds
 * @copyright  2025
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('CLI_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/clilib.php');
require_once($CFG->dirroot . '/course/lib.php');

[$options, $unrecognized] = cli_get_params(
    [
        'help'     => false,
        'quantity' => 50,
        'prefix'   => 'Curso Teste ',
    ],
    [
        'h' => 'help',
        'q' => 'quantity',
        'p' => 'prefix',
    ]
);

if ($options['help']) {
    echo "Script para criação de cursos de teste no Moodle.

Cria categorias na raiz (parent=0) por disciplina e distribui os cursos nelas.
Categorias já existentes são reutilizadas.

Uso:
    php create_courses_test.php [options]

Opções:
    -h, --help              Exibe esta mensagem de ajuda.
    -q, --quantity=NUMBER   Número de cursos a criar (padrão: 50)
    -p, --prefix=TEXT       Prefixo do nome do curso (padrão: 'Curso Teste')

Exemplos:
    php create_courses_test.php --quantity=100
    php create_courses_test.php --quantity=30 --prefix='Demo'

";
    exit(0);
}

$subjects = [
    'Matemática', 'Física', 'Química', 'Biologia', 'História',
    'Geografia', 'Português', 'Inglês', 'Programação', 'Design',
    'Marketing', 'Administração', 'Economia', 'Direito', 'Medicina',
    'Engenharia', 'Arquitetura', 'Psicologia', 'Sociologia', 'Filosofia',
];

$levels = [
    'Básico', 'Intermediário', 'Avançado', 'Especialização', 'Introdução',
];

$themes = [
    'Aplicada', 'Teórica', 'Prática', 'Moderna', 'Clássica',
    'Digital', 'Contemporânea', 'Experimental', 'Avançada', 'Fundamental',
];

$quantity = (int)$options['quantity'];
if ($quantity < 1 || $quantity > 1000) {
    cli_error("A quantidade deve estar entre 1 e 1000.");
}

$prefix = $options['prefix'];

echo "========================================\n";
echo "Criador de Cursos de Teste - Moodle\n";
echo "========================================\n";
echo "Quantidade : {$quantity} cursos\n";
echo "Prefixo    : {$prefix}\n";
echo "Categorias : criadas/reutilizadas na raiz (parent=0)\n";
echo "========================================\n\n";

echo "Deseja continuar? (s/n): ";
$handle = fopen("php://stdin", "r");
$line   = fgets($handle);
fclose($handle);
if (strtolower(trim($line)) !== 's') {
    echo "Operação cancelada.\n";
    exit(0);
}

echo "\nVerificando/criando categorias na raiz...\n";

// Create or reuse one root-level category per subject.
$categorymap = []; // subject => category id
foreach ($subjects as $subject) {
    $existing = $DB->get_record('course_categories', ['name' => $subject, 'parent' => 0]);
    if ($existing) {
        $categorymap[$subject] = (int)$existing->id;
        echo "  Existente: {$subject} (ID: {$existing->id})\n";
    } else {
        $catdata           = new stdClass();
        $catdata->name     = $subject;
        $catdata->parent   = 0;
        $catdata->idnumber = 'testcat_' . strtolower(preg_replace('/[^a-z0-9]/i', '_', $subject));
        $newcat = core_course_category::create($catdata);
        $categorymap[$subject] = (int)$newcat->id;
        echo "  Criada   : {$subject} (ID: {$newcat->id})\n";
    }
}

echo "\nIniciando criação de cursos...\n\n";

$created  = 0;
$errors   = 0;
$catcount = [];

for ($i = 1; $i <= $quantity; $i++) {
    try {
        $subject = $subjects[array_rand($subjects)];
        $level   = $levels[array_rand($levels)];
        $theme   = $themes[array_rand($themes)];

        $categoryid = $categorymap[$subject];
        $coursename = "{$prefix}{$i}: {$subject} {$level}";
        $shortname  = 'test_' . strtolower(preg_replace('/[^a-z0-9]/i', '_', $subject)) . "_{$i}_" . time();

        $coursedata                = new stdClass();
        $coursedata->fullname      = $coursename;
        $coursedata->shortname     = $shortname;
        $coursedata->category      = $categoryid;
        $coursedata->summary       = "Curso de teste criado automaticamente. "
                                   . "Disciplina: {$subject} {$theme}, nível {$level}. "
                                   . "Aborda conceitos e práticas relacionados a {$subject} com foco em aplicações {$theme}.";
        $coursedata->summaryformat = FORMAT_HTML;
        $coursedata->format        = 'topics';
        $coursedata->numsections   = 5;
        $coursedata->startdate     = time();
        $coursedata->enddate       = time() + (90 * 24 * 60 * 60);
        $coursedata->visible       = 1;
        $coursedata->showgrades    = 1;
        $coursedata->newsitems     = 5;
        $coursedata->lang          = 'pt_br';

        create_course($coursedata);
        $created++;
        $catcount[$categoryid] = ($catcount[$categoryid] ?? 0) + 1;

        if ($i % 10 === 0) {
            echo "Progresso: {$i}/{$quantity} cursos criados\n";
        }
    } catch (Exception $e) {
        $errors++;
        echo "ERRO ao criar curso {$i}: " . $e->getMessage() . "\n";
    }
}

echo "\n========================================\n";
echo "Processo finalizado!\n";
echo "========================================\n";
echo "Cursos criados: {$created}\n";
echo "Erros         : {$errors}\n";
echo "========================================\n";

if ($created > 0) {
    echo "\nDistribuição por categoria:\n";
    foreach ($catcount as $catid => $count) {
        $cat = core_course_category::get($catid);
        echo "  {$cat->name} (ID:{$catid}): {$count} curso(s)\n";
    }
}

exit(0);
