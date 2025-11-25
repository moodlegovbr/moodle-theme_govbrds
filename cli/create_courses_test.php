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

namespace theme_govbrds;

/**
 * CLI script to create test courses in Moodle.
 *
 * This script creates multiple courses to test the infinite scroll feature.
 *
 * Use:
 * php create_courses_test.php --quantity=50
 *
 * @package    theme_govbrds
 * @copyright  2025
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/clilib.php');
require_once($CFG->dirroot . '/course/lib.php');

use PHPUnit\Framework\TestCase;

class theme_govbrds_testcase extends \advanced_testcase {
    public function test_something() {
        $this->resetAfterTest(true);
        $this->assertTrue(true);
        // Get command-line parameters.
        [$options, $unrecognized] = cli_get_params([
            'help' => false,
            'quantity' => 50,
            'category' => 1,
            'prefix' => 'Test Course ',
        ], [
            'h' => 'help',
            'q' => 'quantity',
            'c' => 'category',
            'p' => 'prefix',
        ]);

        if ($options['help']) {
        echo "Script for creating test courses in Moodle.
   
        Use:
            php create_courses_test.php [options]
    
        Options:
            -h, --help              Display this help message.
            -q, --quantity=NUMBER   Number of courses to create (default: 50)
            -c, --category=ID       Category ID where courses are to be created (default: 1)
            -p, --prefix=TEXT       Course name prefix (default: 'Test Course')
    
        Examples:
            php create_test_courses.php --quantity=100
            php create_test_courses.php --quantity=30 --category=2 --prefix='Course Demo'
    
        ";
        exit(0);
        }

        // Validate quantity.
        $quantity = (int)$options['quantity'];
        if ($quantity < 1 || $quantity > 1000) {
            cli_error("The quantity must be between 1 and 1000.");
        }

        // Validate category.
        $categoryid = (int)$options['category'];
        try {
            $category = core_course_category::get($categoryid);
        } catch (Exception $e) {
            cli_error("Category with ID {$categoryid} not found");
        }

        $prefix = $options['prefix'];

        echo "========================================\n";
        echo "Criador de Cursos de Teste - Moodle\n";
        echo "========================================\n";
        echo "Quantidade: {$quantity} cursos\n";
        echo "Categoria: {$category->name} (ID: {$categoryid})\n";
        echo "Prefixo: {$prefix}\n";
        echo "========================================\n\n";

        // Confirm execution.
        echo "Deseja continuar? (s/n): ";
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        if (trim($line) != 's' && trim($line) != 'S') {
            echo "Operação cancelada.\n";
            exit(0);
        }
        fclose($handle);

        echo "\nIniciando criação de cursos...\n\n";

        // Arrays for varying names and descriptions.
        $subjects = array(
            'Matemática', 'Física', 'Química', 'Biologia', 'História',
            'Geografia', 'Português', 'Inglês', 'Programação', 'Design',
            'Marketing', 'Administração', 'Economia', 'Direito', 'Medicina',
            'Engenharia', 'Arquitetura', 'Psicologia', 'Sociologia', 'Filosofia',
        );

        $levels = array(
            'Básico', 'Intermediário', 'Avançado', 'Especialização', 'Introdução',
        );

        $themes = array(
            'Aplicada', 'Teórica', 'Prática', 'Moderna', 'Clássica',
            'Digital', 'Contemporânea', 'Experimental', 'Avançada', 'Fundamental',
        );

        $created = 0;
        $errors = 0;

        for ($i = 1; $i <= $quantity; $i++) {
            try {
                // Generate a unique name for the course.
                $subject = $subjects[array_rand($subjects)];
                $level = $levels[array_rand($levels)];
                $theme = $themes[array_rand($themes)];

                $coursename = "{$prefix} {$i}: {$subject} {$level}";
                $shortname = "test_" . strtolower(str_replace(' ', '_', $subject)) . "_{$i}_" . time();

                // Prepare course data
                $coursedata = new stdClass();
                $coursedata->fullname = $coursename;
                $coursedata->shortname = $shortname;
                $coursedata->category = $categoryid;
                $coursedata->summary = "Este é um curso de teste criado automaticamente para testar o scroll infinito. "
                    . "Curso de {$subject} {$theme} nível {$level}. "
                    . "Conteúdo: Este curso aborda os principais conceitos e práticas relacionados a {$subject}, "
                    . "com foco em aplicações práticas e teoria {$theme}.";
                $coursedata->summaryformat = FORMAT_HTML;
                $coursedata->format = 'topics';
                $coursedata->numsections = 5;
                $coursedata->startdate = time();
                $coursedata->enddate = time() + (90 * 24 * 60 * 60); // 90 dias
                $coursedata->visible = 1;
                $coursedata->showgrades = 1;
                $coursedata->newsitems = 5;
                $coursedata->lang = 'pt_br';

                // Create the course.
                $course = create_course($coursedata);

                $created++;

                // Show progress
                if ($i % 10 == 0) {
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
        echo "Cursos criados com sucesso: {$created}\n";
        echo "Erros: {$errors}\n";
        echo "========================================\n";

        if ($created > 0) {
            echo "\nOs cursos foram criados na categoria: {$category->name}\n";
            echo "Você pode visualizá-los em: {$CFG->wwwroot}/course/index.php?categoryid={$categoryid}\n";
        }
        exit(0);
    }
}

