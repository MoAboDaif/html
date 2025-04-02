<?php
// src/controllers/VisitorController.php

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../models/Visitor.php';

class VisitorController {
    protected $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function saveVisitor($data) {
        $visitor = new Visitor($this->pdo);
        return $visitor->save($data);
    }
    
    public function searchVisitors($query) {
        $visitor = new Visitor($this->pdo);
        return $visitor->search($query);
    }
}
