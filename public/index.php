<?php
// public/index.php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/controllers/VisitorController.php';

session_start();

$action = $_GET['action'] ?? '';

$controller = new VisitorController($pdo);

switch ($action) {
    case 'save':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $success = $controller->saveVisitor($_POST);
            $_SESSION['msg'] = $success 
                ? "Visitor saved successfully!" 
                : "Error saving visitor.";
            header('Location: /index.php');
            exit;
        }
        break;
    case 'search':
        $query = $_GET['query'] ?? '';
        $results = $controller->searchVisitors($query);
        include __DIR__ . '/../src/views/search_results.php';
        break;
    default:
        // Default action: show the visitor form
        include __DIR__ . '/../src/views/visitor_form.php';
        break;
}
