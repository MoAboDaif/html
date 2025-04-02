<?php
// src/models/Visitor.php

class Visitor {
    protected $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function save($data) {
        $name  = trim($data['name'] ?? '');
        $email = trim($data['email'] ?? '');
        
        // Basic validation: Ensure both fields are provided
        if (empty($name) || empty($email)) {
            return false;
        }
        
        // Use prepared statements to protect against SQL injection
        $stmt = $this->pdo->prepare("INSERT INTO visitors (name, email) VALUES (:name, :email)");
        return $stmt->execute(['name' => $name, 'email' => $email]);
    }
    
    public function search($query) {
        $search = "%$query%";
        $stmt = $this->pdo->prepare("SELECT * FROM visitors WHERE name LIKE :name OR email LIKE :email");
        $stmt->execute(['name' => $search, 'email' => $search]);
        return $stmt->fetchAll();
    }
}