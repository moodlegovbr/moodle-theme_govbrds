<?php

/**
 * Script CLI para criar cursos de teste no Moodle
 *
 * Este script cria múltiplos cursos para testar o recurso de scroll infinito
 *
 * Uso:
 * php create_test_courses.php --quantity=50
 *
 * @package    theme_govbrds
 * @copyright  2025
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('CLI_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/clilib.php');
require_once($CFG->dirroot . '/course/lib.php');

// Obter parâmetros da linha de comando
list($options, $unrecognized) = cli_get_params(
    array(
        'help' => false,
        'quantity' => 50,
        'category' => 1,
        'prefix' => 'Curso Teste'
    ),
    array(
        'h' => 'help',
        'q' => 'quantity',
        'c' => 'category',
        'p' => 'prefix'
    )
);

if ($options['help']) {
    echo "Script para criar cursos de teste no Moodle

Uso:
    php create_test_courses.php [opções]

Opções:
    -h, --help              Mostra esta mensagem de ajuda
    -q, --quantity=NUMBER   Quantidade de cursos a criar (padr�o: 50)
    -c, --category=ID       ID da categoria onde criar os cursos (padr�o: 1)
    -p, --prefix=TEXT       Prefixo do nome dos cursos (padr�o: 'Curso Teste')

Exemplos:
    php create_test_courses.php --quantity=100
    php create_test_courses.php --quantity=30 --category=2 --prefix='Curso Demo'

";
    exit(0);
}

// Validar quantidade
$quantity = (int)$options['quantity'];
if ($quantity < 1 || $quantity > 1000) {
    cli_error("Quantidade deve estar entre 1 e 1000");
}

// Validar categoria
$categoryid = (int)$options['category'];
try {
    $category = core_course_category::get($categoryid);
} catch (Exception $e) {
    cli_error("Categoria com ID {$categoryid} n�o encontrada");
}

$prefix = $options['prefix'];

echo "========================================\n";
echo "Criador de Cursos de Teste - Moodle\n";
echo "========================================\n";
echo "Quantidade: {$quantity} cursos\n";
echo "Categoria: {$category->name} (ID: {$categoryid})\n";
echo "Prefixo: {$prefix}\n";
echo "========================================\n\n";

// Confirmar execução
echo "Deseja continuar? (s/n): ";
$handle = fopen("php://stdin", "r");
$line = fgets($handle);
if (trim($line) != 's' && trim($line) != 'S') {
    echo "Operação cancelada.\n";
    exit(0);
}
fclose($handle);

echo "\nIniciando criação de cursos...\n\n";

// Arrays para variar os nomes e descrições
$subjects = array(
    'Matemática', 'Física', 'Química', 'Biologia', 'História',
    'Geografia', 'Português', 'Inglês', 'Programação', 'Design',
    'Marketing', 'Administração', 'Economia', 'Direito', 'Medicina',
    'Engenharia', 'Arquitetura', 'Psicologia', 'Sociologia', 'Filosofia'
);

$levels = array(
    'Básico', 'Intermediário', 'Avançado', 'Especialização', 'Introdução'
);

$themes = array(
    'Aplicada', 'Teórica', 'Prática', 'Moderna', 'Clássica',
    'Digital', 'Contemporânea', 'Experimental', 'Avançada', 'Fundamental'
);

$created = 0;
$errors = 0;

for ($i = 1; $i <= $quantity; $i++) {
    try {
        // Gerar nome único para o curso
        $subject = $subjects[array_rand($subjects)];
        $level = $levels[array_rand($levels)];
        $theme = $themes[array_rand($themes)];

        $coursename = "{$prefix} {$i}: {$subject} {$level}";
        $shortname = "test_" . strtolower(str_replace(' ', '_', $subject)) . "_{$i}_" . time();

        // Preparar dados do curso
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

        // Criar o curso
        $course = create_course($coursedata);

        $created++;

        // Mostrar progresso
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
