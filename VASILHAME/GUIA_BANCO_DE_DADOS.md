# 📦 Guia — Criação das Tabelas no Banco de Dados
## Controle de Vasilhame GÁS

---

## 1. RODAR AS MIGRATIONS (recomendado)

Se você usa Laravel, copie os arquivos de migration para
`database/migrations/` e rode:

```bash
php artisan migrate
```

Isso cria as duas tabelas automaticamente. Pronto!

---

## 2. CRIAR AS TABELAS MANUALMENTE (SQL puro)

Caso prefira criar direto no banco (phpMyAdmin, DBeaver, TablePlus, etc.),
rode os comandos abaixo.

---

### TABELA 1 — vasilhame_movimentacoes

```sql
CREATE TABLE vasilhame_movimentacoes (
    id                BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    produto           VARCHAR(20)     NOT NULL COMMENT 'Ex: P13, P45, P20',
    data_movimentacao DATE            NOT NULL,
    total_vasilhame   INT             NOT NULL DEFAULT 0,
    cheio             INT             NOT NULL DEFAULT 0,
    vazio             INT             NOT NULL DEFAULT 0,
    emprestado        INT             NOT NULL DEFAULT 0,
    vendido           INT             NOT NULL DEFAULT 0,
    soma_ok           TINYINT(1)      NOT NULL DEFAULT 0,
    user_id           BIGINT UNSIGNED NOT NULL,
    created_at        TIMESTAMP       NULL,
    updated_at        TIMESTAMP       NULL,

    PRIMARY KEY (id),
    INDEX idx_produto (produto),
    INDEX idx_data    (data_movimentacao),
    INDEX idx_user    (user_id),

    CONSTRAINT fk_mov_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### TABELA 2 — vasilhame_emprestimos

```sql
CREATE TABLE vasilhame_emprestimos (
    id                       BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    cliente                  VARCHAR(255)    NOT NULL,
    produto                  VARCHAR(20)     NOT NULL,
    quantidade               INT             NOT NULL DEFAULT 1,
    data_saida               DATE            NOT NULL,
    data_previsao_devolucao  DATE            NULL,
    data_devolucao           DATE            NULL,
    status                   ENUM('pendente','devolvido') NOT NULL DEFAULT 'pendente',
    user_id                  BIGINT UNSIGNED NOT NULL,
    created_at               TIMESTAMP       NULL,
    updated_at               TIMESTAMP       NULL,

    PRIMARY KEY (id),
    INDEX idx_cliente (cliente),
    INDEX idx_produto (produto),
    INDEX idx_status  (status),
    INDEX idx_user    (user_id),

    CONSTRAINT fk_emp_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 3. VERIFICAR AS TABELAS

```sql
DESCRIBE vasilhame_movimentacoes;
DESCRIBE vasilhame_emprestimos;
```

---

## 4. CAMPOS — EXPLICAÇÃO

### vasilhame_movimentacoes
| Campo              | Tipo        | Descrição                                |
|--------------------|-------------|------------------------------------------|
| id                 | BIGINT      | Chave primária, auto incremento          |
| produto            | VARCHAR(20) | P13, P45, P20                            |
| data_movimentacao  | DATE        | Data do registro                         |
| total_vasilhame    | INT         | Total digitado pelo operador             |
| cheio              | INT         | Vasilhames cheios (digitado)             |
| vazio              | INT         | Vasilhames vazios                        |
| emprestado         | INT         | Vasilhames emprestados                   |
| vendido            | INT         | Vasilhames vendidos                      |
| soma_ok            | TINYINT(1)  | 1 se a soma bater com o total            |
| user_id            | BIGINT      | FK para users (quem registrou)           |

### vasilhame_emprestimos
| Campo                   | Tipo        | Descrição                            |
|-------------------------|-------------|--------------------------------------|
| id                      | BIGINT      | Chave primária, auto incremento      |
| cliente                 | VARCHAR(255)| Nome do cliente                      |
| produto                 | VARCHAR(20) | P13, P45, P20                        |
| quantidade              | INT         | Qtd de vasilhames emprestados        |
| data_saida              | DATE        | Data que saiu                        |
| data_previsao_devolucao | DATE        | Previsão de retorno (pode ser nulo)  |
| data_devolucao          | DATE        | Data real da devolução (null = pend) |
| status                  | ENUM        | 'pendente' ou 'devolvido'            |
| user_id                 | BIGINT      | FK para users                        |

---

## 5. CONFIGURAR O HTML

No arquivo controle_vasilhame_gas.html, topo do script:

```js
const API_BASE  = 'https://seusite.com.br/api'; // sua URL real
const API_TOKEN = 'seu_token_sanctum';           // token do usuário logado
```

---

## 6. ENDPOINTS DA API

| Método | Rota                                     | Ação                   |
|--------|------------------------------------------|------------------------|
| GET    | /api/vasilhame/movimentacoes             | Listar movimentações   |
| POST   | /api/vasilhame/movimentacoes             | Salvar movimentação    |
| DELETE | /api/vasilhame/movimentacoes/{id}        | Excluir movimentação   |
| GET    | /api/vasilhame/emprestimos               | Listar empréstimos     |
| POST   | /api/vasilhame/emprestimos               | Registrar empréstimo   |
| PATCH  | /api/vasilhame/emprestimos/{id}/devolver | Marcar como devolvido  |
| DELETE | /api/vasilhame/emprestimos/{id}          | Excluir empréstimo     |

Todos os endpoints exigem: Authorization: Bearer {token}
