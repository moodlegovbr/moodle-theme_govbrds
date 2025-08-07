<?php
// This file is part of Moodle - http://moodle.org/

namespace theme_govbrds\output\core;

defined('MOODLE_INTERNAL') || die();

/**
 * Custom course renderer for the theme.
 *
 * @package   theme_seutema
 * @copyright Year Your Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_renderer extends \core_course_renderer {

    /**
     * Returns HTML to print tree of course categories (with number of courses) for the frontpage
     *
     * @return string
     */
    public function frontpage_categories_list() {
        global $DB;
        
        try {
            // Buscar categorias visíveis de nível superior
            $categories = $DB->get_records_sql("
                SELECT cc.id, cc.name, cc.coursecount, cc.visible, cc.sortorder
                FROM {course_categories} cc 
                WHERE cc.parent = 0 
                AND cc.visible = 1 
                ORDER BY cc.sortorder ASC
                LIMIT 20
            ");
            
            if (empty($categories)) {
                return '';
            }
            
            $output = '';
            $output .= \html_writer::start_div('frontpage-category-buttons-container');
            
            // Título
            $output .= \html_writer::tag('h2', "As habilidades essenciais para você, reunidas aqui!", 
                array('class' => 'frontpage-categories-title'));

            // Container flex para os botões
            $output .= \html_writer::start_div('category-buttons-flex p-3');
            
            foreach ($categories as $category) {
                // URL para a categoria
                $categoryurl = new \moodle_url('/course/index.php', array('categoryid' => $category->id));
                $categoryname = format_string($category->name);
                $coursecount = intval($category->coursecount);
                
                // Criar botão
                $buttonattributes = array(
                    'class' => 'br-button primary mr-3 mb-3',
                    'data-categoryid' => $category->id,
                    'title' => $categoryname . ($coursecount > 0 ? " ({$coursecount} cursos)" : ''),
                    'role' => 'button'
                );
                
                $buttoncontent = \html_writer::div($categoryname, 'category-name');
                if ($coursecount > 0) {
                    $coursestext = $coursecount == 1 ? 'curso' : 'cursos';
                    $buttoncontent .= \html_writer::div($coursecount . ' ' . $coursestext, 'category-count');
                } else {
                    $buttoncontent .= \html_writer::div('Sem cursos', 'category-count category-empty');
                }
                
                $output .= \html_writer::link($categoryurl, $buttoncontent, $buttonattributes);
            }
            
            $output .= \html_writer::end_div(); // category-buttons-flex
            $output .= \html_writer::end_div(); // frontpage-category-buttons-container
            
            return $output;
            
        } catch (Exception $e) {
            debugging('Erro ao carregar categorias: ' . $e->getMessage(), DEBUG_DEVELOPER);
            
            // Fallback: retornar mensagem amigável
            $output = \html_writer::div(
                'Não foi possível carregar as categorias no momento.',
                'alert alert-info'
            );
            return $output;
        }
    }

}