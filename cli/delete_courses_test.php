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
 * CLI script to delete trial courses in Moodle.
 * This script deletes courses created by the create_test_courses.php script.
 *
 * Use:
 * php delete_courses_test.php --prefix="Course Test"
 *
 * @package    theme_govbrds
 * @copyright  2025
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('CLI_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/clilib.php');
require_once($CFG->dirroot . '/course/lib.php');

// Get command-line parameters.
[$options, $unrecognized] = cli_get_params([
    'help' => false,
    'prefix' => 'Curso Teste',
    'category' => null,
    'confirm' => false,
], [
    'h' => 'help',
    'p' => 'prefix',
    'c' => 'category',
]);

if ($options['help']) {
    echo "Script to delete trial courses in Moodle.

Use:
    php delete_courses_test.php [options]

Options:
    -h, --help              Display this help message.
    -p, --prefix=TEXT       Prefix for courses to be deleted (default: 'Test Course')
    -c, --category=ID       Category ID (optional, search all categories if not specified)
    --confirm               Skip confirmation (use with caution!)

Examples:
    php delete_test_courses.php --prefix='Test Course'
    php delete_test_courses.php --prefix='Demo' --category=2
    php delete_test_courses.php --prefix='Test Course' --confirm

WARNING: This script permanently deletes courses!

";
    exit(0);
}

$prefix = $options['prefix'];
$categoryid = $options['category'];
$skipconfirm = $options['confirm'];

echo "========================================\n";
echo "Delete Test Courses - Moodle\n";
echo "========================================\n";
echo "Prefix to search for: {$prefix}\n";

// Build a query to search for courses.
$sql = "SELECT id, fullname, shortname, category
        FROM {course}
        WHERE fullname LIKE :prefix
        AND id != :siteid";

$params = [
    'prefix' => $prefix . '%',
    'siteid' => SITEID,
];

if ($categoryid !== null) {
    $sql .= " AND category = :category";
    $params['category'] = (int)$categoryid;
    echo "Category: {$categoryid}\n";
} else {
    echo "Category: All\n";
}

$sql .= " ORDER BY id ASC";

echo "========================================\n\n";

// Search courses.
$courses = $DB->get_records_sql($sql, $params);

if (empty($courses)) {
    echo "No courses found with the prefix '{$prefix}'.\n";
    exit(0);
}

$count = count($courses);
echo "Courses found: {$count}\n\n";

// Show list of courses.
echo "List of courses that will be deleted:\n";
echo "-----------------------------------\n";
$i = 1;
foreach ($courses as $course) {
    echo "{$i}. [{$course->id}] {$course->fullname} ({$course->shortname})\n";
    $i++;
    if ($i > 20 && $count > 20) {
        echo "... and more " . ($count - 20) . " courses\n";
        break;
    }
}
echo "\n";

if (!$skipconfirm) {
    echo "========================================\n";
    echo "⚠️  WARNING: This operation cannot be undone!\n";
    echo "========================================\n";
    echo "Do you really want to delete {$count} course(s)? (y/n): ";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    if (trim($line) != 'y' && trim($line) != 'Y') {
        echo "Operation canceled.\n";
        exit(0);
    }
    fclose($handle);
}

echo "\nStarting course deletion...\n\n";

$deleted = 0;
$errors = 0;

foreach ($courses as $course) {
    try {
        // Delete course.
        delete_course($course->id, false); // If false = do not show feedback on the web.
        $deleted++;
        // Show progress.
        if ($deleted % 10 == 0) {
            echo "Progress: {$deleted}/{$count} deleted courses\n";
        }
    } catch (Exception $e) {
        $errors++;
        echo "ERROR deleting course {$course->id} ({$course->fullname}): " . $e->getMessage() . "\n";
    }
}
echo "\n========================================\n";
echo "Process finished!\n";
echo "========================================\n";
echo "Courses successfully deleted: {$deleted}\n";
echo "Errors: {$errors}\n";
echo "========================================\n";

// Clear cache.
echo "\nClearing cache...\n";
rebuild_course_cache(0, true);
echo "Clear cache!\n";
exit(0);
