<?php
session_start();
require_once _DIR_ . '/../../app/product-functions.php';

$product_id = $_POST['product_id'];
$qty = (int) $_POST['qty'];
$product = getProduct($product_id);

if ($product && $qty > 0) {
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'qty' => $qty
        ];
    } else {
        $_SESSION['cart'][$product_id]['qty'] += $qty;
    }
}
header("Location: index.php");