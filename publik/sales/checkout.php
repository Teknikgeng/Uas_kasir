<?php
session_start();
require_once _DIR_ . '/../../app/auth.php';
requireLogin();
require_once _DIR_ . '/../../app/transaction-functions.php';

$cart = $_SESSION['cart'];
$total = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
$paid = (int) $_POST['paid'];
$change = $paid - $total;

$transaction_id = saveTransaction($_SESSION['user']['id'], $cart, $total, $paid, $change);

// kosongkan keranjang
unset($_SESSION['cart']);

// redirect ke struk
header("Location: receipt.php?id=" . $transaction_id);