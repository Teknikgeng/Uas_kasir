<?php
require_once __DIR__ . '/db.php';

function getProducts() {
    global $pdo;
    $stmt = $pdo->query("
        SELECT p.*, c.name AS category_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        ORDER BY p.id DESC
    ");
    return $stmt->fetchAll();
}

function getProduct($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function createProduct($category_id, $name, $sku, $price, $stock, $image = null) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO products (category_id, name, sku, price, stock, image) VALUES (?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$category_id, $name, $sku, $price, $stock, $image]);
}

function updateProduct($id, $category_id, $name, $sku, $price, $stock, $image = null) {
    global $pdo;
    if ($image) {
        $stmt = $pdo->prepare("UPDATE products SET category_id=?, name=?, sku=?, price=?, stock=?, image=? WHERE id=?");
        return $stmt->execute([$category_id, $name, $sku, $price, $stock, $image, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE products SET category_id=?, name=?, sku=?, price=?, stock=? WHERE id=?");
        return $stmt->execute([$category_id, $name, $sku, $price, $stock, $id]);
    }
}

function deleteProduct($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM products WHERE id=?");
    return $stmt->execute([$id]);
}