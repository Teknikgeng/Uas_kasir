<?php
require_once __DIR__ . '/db.php';

function getUsers() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
    return $stmt->fetchAll();
}

function getUser($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function createUser($name, $username, $password, $role) {
    global $pdo;
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$name, $username, $hashed, $role]);
}

function updateUser($id, $name, $username, $role, $password = null) {
    global $pdo;
    if ($password) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET name=?, username=?, password=?, role=? WHERE id=?");
        return $stmt->execute([$name, $username, $hashed, $role, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET name=?, username=?, role=? WHERE id=?");
        return $stmt->execute([$name, $username, $role, $id]);
    }
}

function deleteUser($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    return $stmt->execute([$id]);
}