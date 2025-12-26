🚀 SGA - Sistema de Gestão Aplicada
O SGA é um ecossistema ERP completo desenvolvido para a gestão eficiente de revendas de gás e água, focado em Logística de Precisão e Inteligência de Dados.

🛠️ Diferenciais Técnicos
. Framework: Laravel (PHP) com arquitetura escalável.

. Banco de Dados: Modelagem relacional avançada em MySQL com foco em integridade e rastreabilidade.

. Infraestrutura Moderna: Configurado com Docker para padronização de ambiente e SSL para conexões seguras.

. IA e Big Data: Estrutura preparada para análise de dados e previsões de demanda, refletindo a especialização técnica em Inteligência Artificial.

📋 Módulos Principais
1. Gestão Financeira: Controle de fluxo de caixa, faturamento e relatórios gerenciais com gráficos.

2. Controle de Estoque: Gestão de movimentação de produtos e vasilhames em tempo real.

3. Logística e Expedição: Sistema de pedidos de coleta e rastreio integrado.

4. Automação: Notificações via WhatsApp e integração com APIs externas.


## 📸 Demonstração do Sistema

### Dashboard Financeiro e BI
![Dashboard SGA](image_009200.png)

### Gestão de Módulos (Revenda, Oficina e Padaria)
![Módulos SGA](image_0091bc.png)

### Interface de Operação e Menus
![Menu Principal](image_00925b.png)

## 🏗️ Arquitetura de Dados e Engenharia

O SGA foi projetado com foco em **integridade referencial** e **escalabilidade**, utilizando as melhores práticas do Laravel 11.

### 💰 Gestão Financeira (Contas a Receber)
A estrutura de dados foi desenhada para garantir precisão absoluta:
- **Precisão Decimal:** Uso de `decimal(10,2)` para evitar erros de arredondamento em cálculos de faturamento.
- **Integridade Referencial:** Relacionamentos com `onDelete('cascade')` para garantir que a exclusão de registros de clientes ou formas de pagamento não gere dados órfãos.
- **Controle de Estados:** Implementação de `enums` para monitoramento ágil de status (Pendente, Recebido, Atrasado), facilitando a geração de Dashboards de BI.

### 📦 Controle de Estoque (Audit Trail)
O módulo de estoque não apenas armazena saldos, mas funciona como um log de auditoria:
- **Rastreabilidade:** Registro detalhado da `origem` da movimentação (Compra, Venda ou Ajuste), permitindo auditoria total do fluxo de mercadorias.
- **Performance:** Estrutura otimizada para suportar grandes volumes de registros de entrada e saída, essencial para operações de logística.

### 🐳 Infraestrutura Robusta
- **Dockerizado:** Ambiente isolado via Docker para garantir que o sistema rode com as mesmas configurações em qualquer servidor.
- **Segurança:** Comunicação entre aplicação e banco de dados MySQL protegida por túneis **SSL**.
