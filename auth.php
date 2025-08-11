<?php
session_start();
require_once _DIR_ . '/db.php';

function login($username, $password) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'name' => $user['name']
        ];
        return true;
    }
    return false;
}

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit;
    }
}

function requireRole($role) {
    if (!isLoggedIn() || $_SESSION['user']['role'] !== $role) {
        header("HTTP/1.1 403 Forbidden");
        echo "Akses ditolak!";
        exit;
    }
}

function logout() {
    session_destroy();
    header("Location: login.php");
    exit;
}