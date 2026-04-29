<?php
$logFile = 'recuperacao_valores.sql'; // Nome do arquivo que você gerou
$outputFile = 'script_correcao.sql';
$handle = fopen($logFile, "r");
$output = fopen($outputFile, "w");

$currentId = null;
$valorAntigo = null;

echo "Processando registros...\n";

while (($line = fgets($handle)) !== false) {
    // Identifica o ID (campo @1)
    if (preg_match('/@1=(\d+)/', $line, $matches)) {
        $currentId = $matches[1];
    }
    // Identifica o Valor Antigo (campo @4 no seu caso)
    // ATENÇÃO: Verifique se o valor antigo está sempre no @4 no log
    if (preg_match('/@4=([\d\.]+)/', $line, $matches)) {
        $valorAntigo = $matches[1];
        
        // Quando encontra o valor, escreve o comando de UPDATE no novo arquivo
        if ($currentId && $valorAntigo) {
            $sql = "UPDATE contas_a_receber SET valor = {$valorAntigo} WHERE id = {$currentId};\n";
            fwrite($output, $sql);
            // Limpa as variáveis para o próximo bloco
            $currentId = null;
            $valorAntigo = null;
        }
    }
}

fclose($handle);
fclose($output);
echo "Pronto! O arquivo 'script_correcao.sql' foi gerado com sucesso.\n";