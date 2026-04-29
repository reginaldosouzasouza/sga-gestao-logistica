# Dashboard Gerencial Financeiro

## Estrutura
- /dashboard
- /dashboard/api
- /dashboard/python
- /dashboard/js
- /dashboard/css

## Como usar
1. Copie a pasta `dashboard` para dentro do seu projeto PHP.
2. Ajuste as credenciais do banco em `api/db.php`.
3. Acesse `http://127.0.0.1:8010/dashboard/index.php`.
4. Para gerar previsões reais, execute o script Python:
   `python dashboard/python/previsao_financeira.py`

## Tabelas esperadas
- vendas(data_venda, valor_total, custo_total)
- itens_venda(produto_id, valor_unitario, custo_unitario)
- produtos(id, nome)

## Observação
Se o banco ainda não estiver pronto, os endpoints usam dados de exemplo para você visualizar o dashboard.
