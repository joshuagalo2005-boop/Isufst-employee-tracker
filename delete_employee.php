<?php
/**
 * =============================================================================
 * Delete Employee Record (DELETE)
 * =============================================================================
 */

require_once 'db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Delete record from employees table
    $stmt = $pdo->prepare("DELETE FROM employees WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

// Redirect back to main directory with feedback message
header('Location: index.php?msg=deleted');
exit;
