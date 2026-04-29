<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php';

function response($data) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!$pdo) {
    response([
        ['mes' => 'Jan', 'receita_real' => 120000, 'receita_prevista' => 125000, 'custo_previsto' => 90000, 'lucro_previsto' => 35000, 'margem_prevista' => 28.00],
        ['mes' => 'Fev', 'receita_real' => 135000, 'receita_prevista' => 138000, 'custo_previsto' => 98000, 'lucro_previsto' => 40000, 'margem_prevista' => 28.98],
        ['mes' => 'Mar', 'receita_real' => 150000, 'receita_prevista' => 152000, 'custo_previsto' => 108000, 'lucro_previsto' => 44000, 'margem_prevista' => 28.95],
        ['mes' => 'Abr', 'receita_real' => 165000, 'receita_prevista' => 168000, 'custo_previsto' => 118000, 'lucro_previsto' => 50000, 'margem_prevista' => 29.76],
        ['mes' => 'Mai', 'receita_real' => 180000, 'receita_prevista' => 185000, 'custo_previsto' => 132000, 'lucro_previsto' => 53000, 'margem_prevista' => 28.65],
        ['mes' => 'Jun', 'receita_real' => null,   'receita_prevista' => 195000, 'custo_previsto' => 139000, 'lucro_previsto' => 56000, 'margem_prevista' => 28.72]
    ]);
}

try {
    $sql = "
        SELECT 
            DATE_FORMAT(mes_referencia, '%b') AS mes,
            receita_real,
            receita_prevista,
            custo_previsto,
            lucro_previsto,
            margem_prevista
        FROM previsoes_financeiras
        ORDER BY mes_referencia ASC
        LIMIT 12
    ";
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll();
    response($rows);
} catch (\Throwable $e) {
    response([
        ['mes' => 'Jan', 'receita_real' => 120000, 'receita_prevista' => 125000, 'custo_previsto' => 90000, 'lucro_previsto' => 35000, 'margem_prevista' => 28.00],
        ['mes' => 'Fev', 'receita_real' => 135000, 'receita_prevista' => 138000, 'custo_previsto' => 98000, 'lucro_previsto' => 40000, 'margem_prevista' => 28.98],
        ['mes' => 'Mar', 'receita_real' => 150000, 'receita_prevista' => 152000, 'custo_previsto' => 108000, 'lucro_previsto' => 44000, 'margem_prevista' => 28.95],
        ['mes' => 'Abr', 'receita_real' => 165000, 'receita_prevista' => 168000, 'custo_previsto' => 118000, 'lucro_previsto' => 50000, 'margem_prevista' => 29.76],
        ['mes' => 'Mai', 'receita_real' => 180000, 'receita_prevista' => 185000, 'custo_previsto' => 132000, 'lucro_previsto' => 53000, 'margem_prevista' => 28.65],
        ['mes' => 'Jun', 'receita_real' => null,   'receita_prevista' => 195000, 'custo_previsto' => 139000, 'lucro_previsto' => 56000, 'margem_prevista' => 28.72]
    ]);
}
