<?php
/**
 * Script CLI para deletar cursos de teste no Moodle
 * 
 * Este script deleta cursos criados pelo script create_test_courses.php
 * 
 * Uso:
 * php delete_test_courses.php --prefix="Curso Teste"
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
        'prefix' => 'Curso Teste',
        'category' => null,
        'confirm' => false
    ),
    array(
        'h' => 'help',
        'p' => 'prefix',
        'c' => 'category'
    )
);

if ($options['help']) {
    echo "Script para deletar cursos de teste no Moodle

Uso:
    php delete_test_courses.php [opções]

Opções:
    -h, --help              Mostra esta mensagem de ajuda
    -p, --prefix=TEXT       Prefixo dos cursos a deletar (padrão: 'Curso Teste')
    -c, --category=ID       ID da categoria (opcional, busca em todas se não especificado)
    --confirm               Pula confirmação (use com cuidado!)

Exemplos:
    php delete_test_courses.php --prefix='Curso Teste'
    php delete_test_courses.php --prefix='Demo' --category=2
    php delete_test_courses.php --prefix='Curso Teste' --confirm

ATENÇÃO: Este script deleta cursos permanentemente!

";
    exit(0);
}

$prefix = $options['prefix'];
$categoryid = $options['category'];
$skipconfirm = $options['confirm'];

echo "========================================\n";
echo "Deletar Cursos de Teste - Moodle\n";
echo "========================================\n";
echo "Prefixo a buscar: {$prefix}\n";

// Construir query para buscar cursos
$sql = "SELECT id, fullname, shortname, category 
        FROM {course} 
        WHERE fullname LIKE :prefix 
        AND id != :siteid";
        
$params = array(
    'prefix' => $prefix . '%',
    'siteid' => SITEID
);

if ($categoryid !== null) {
    $sql .= " AND category = :category";
    $params['category'] = (int)$categoryid;
    echo "Categoria: {$categoryid}\n";
} else {
    echo "Categoria: Todas\n";
}

$sql .= " ORDER BY id ASC";

echo "========================================\n\n";

// Buscar cursos
$courses = $DB->get_records_sql($sql, $params);

if (empty($courses)) {
    echo "Nenhum curso encontrado com o prefixo '{$prefix}'.\n";
    exit(0);
}

$count = count($courses);
echo "Cursos encontrados: {$count}\n\n";

// Mostrar lista de cursos
echo "Lista de cursos que serão deletados:\n";
echo "-----------------------------------\n";
$i = 1;
foreach ($courses as $course) {
    echo "{$i}. [{$course->id}] {$course->fullname} ({$course->shortname})\n";
    $i++;
    if ($i > 20 && $count > 20) {
        echo "... e mais " . ($count - 20) . " cursos\n";
        break;
    }
}
echo "\n";

if (!$skipconfirm) {
    echo "========================================\n";
    echo "⚠️  ATENÇÃO: Esta operação não pode ser desfeita!\n";
    echo "========================================\n";
    echo "Deseja realmente deletar {$count} curso(s)? (s/n): ";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    if (trim($line) != 's' && trim($line) != 'S') {
        echo "Operação cancelada.\n";
        exit(0);
    }
    fclose($handle);
}

echo "\nIniciando deleção de cursos...\n\n";

$deleted = 0;
$errors = 0;

foreach ($courses as $course) {
    try {
        // Deletar curso
        delete_course($course->id, false); // false = não mostrar feedback na web
        
        $deleted++;
        
        // Mostrar progresso
        if ($deleted % 10 == 0) {
            echo "Progresso: {$deleted}/{$count} cursos deletados\n";
        }
        
    } catch (Exception $e) {
        $errors++;
        echo "ERRO ao deletar curso {$course->id} ({$course->fullname}): " . $e->getMessage() . "\n";
    }
}

echo "\n========================================\n";
echo "Processo finalizado!\n";
echo "========================================\n";
echo "Cursos deletados com sucesso: {$deleted}\n";
echo "Erros: {$errors}\n";
echo "========================================\n";

// Limpar cache
echo "\nLimpando cache...\n";
rebuild_course_cache(0, true);
echo "Cache limpo!\n";

exit(0);