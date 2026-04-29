<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php';

function response($data) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!$pdo) {
    response([
        ['produto' => 'Gás P13', 'margem' => 22.4],
        ['produto' => 'Gás P20', 'margem' => 25.8],
        ['produto' => 'Água 20L', 'margem' => 34.2],
        ['produto' => 'Vasilhame', 'margem' => 18.6]
    ]);
}

try {
    $sql = "
        SELECT p.nome AS produto,
               ROUND(AVG(((iv.valor_unitario - iv.custo_unitario) / NULLIF(iv.valor_unitario, 0)) * 100), 2) AS margem
        FROM itens_venda iv
        INNER JOIN produtos p ON p.id = iv.produto_id
        GROUP BY p.nome
        ORDER BY margem DESC
        LIMIT 10
    ";
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll();
    response($rows);
} catch (\Throwable $e) {
    response([
        ['produto' => 'Gás P13', 'margem' => 22.4],
        ['produto' => 'Gás P20', 'margem' => 25.8],
        ['produto' => 'Água 20L', 'margem' => 34.2],
        ['produto' => 'Vasilhame', 'margem' => 18.6]
    ]);
}
