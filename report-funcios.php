<?php
require_once _DIR_ . '/db.php';

function getSalesReport($startDate = null, $endDate = null) {
    global $pdo;
    $sql = "
        SELECT t.*, u.name AS cashier_name
        FROM transactions t
        JOIN users u ON t.user_id = u.id
        WHERE 1=1
    ";

    $params = [];

    if ($startDate) {
        $sql .= " AND DATE(t.created_at) >= ?";
        $params[] = $startDate;
    }
    if ($endDate) {
        $sql .= " AND DATE(t.created_at) <= ?";
        $params[] = $endDate;
    }

    $sql .= " ORDER BY t.created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll();
}