<?php
require_once __DIR__ . '/db.php';

function getCategories() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY id DESC");
    return $stmt->fetchAll();
}

function getCategory($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function createCategory($name) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
    return $stmt->execute([$name]);
}

function updateCategory($id, $name) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE categories SET name=? WHERE id=?");
    return $stmt->execute([$name, $id]);
}

function deleteCategory($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id=?");
    return $stmt->execute([$id]);
}