<?php
require_once _DIR_ . '/db.php';

function saveTransaction($user_id, $items, $total, $paid, $change) {
    global $pdo;
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO transactions (user_id, total, paid, change, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$user_id, $total, $paid, $change]);
    $transaction_id = $pdo->lastInsertId();

    $stmtItem = $pdo->prepare("INSERT INTO transaction_items (transaction_id, product_id, qty, price, subtotal) VALUES (?, ?, ?, ?, ?)");
    foreach ($items as $item) {
        $stmtItem->execute([
            $transaction_id,
            $item['id'],
            $item['qty'],
            $item['price'],
            $item['qty'] * $item['price']
        ]);

        // update stok produk
        $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?")
            ->execute([$item['qty'], $item['id']]);
    }

    $pdo->commit();
    return $transaction_id;
}