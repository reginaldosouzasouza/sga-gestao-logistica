import mysql.connector
import pandas as pd
from sklearn.linear_model import LinearRegression

DB_CONFIG = {
    "host": "127.0.0.1",
    "user": "root",
    "password": "",
    "database": "revenda"
}

def carregar_dados():
    con = mysql.connector.connect(**DB_CONFIG)

    query = """
        SELECT
            DATE_FORMAT(data_venda, '%Y-%m-01') AS mes_referencia,
            SUM(valor_total) AS receita_real,
            SUM(custo_total) AS custo_real
        FROM vendas
        GROUP BY DATE_FORMAT(data_venda, '%Y-%m-01')
        ORDER BY mes_referencia
    """
    df = pd.read_sql(query, con)
    con.close()
    return df

def gerar_previsao(df, meses_futuros=3):
    df["mes_referencia"] = pd.to_datetime(df["mes_referencia"])
    df["indice"] = range(len(df))
    df["lucro_real"] = df["receita_real"] - df["custo_real"]
    df["margem_real"] = (df["lucro_real"] / df["receita_real"]) * 100

    X = df[["indice"]]
    y_receita = df["receita_real"]
    y_custo = df["custo_real"]

    modelo_receita = LinearRegression().fit(X, y_receita)
    modelo_custo = LinearRegression().fit(X, y_custo)

    futuros = []
    ultimo_indice = df["indice"].max()
    ultima_data = df["mes_referencia"].max()

    for i in range(1, meses_futuros + 1):
        novo_indice = ultimo_indice + i
        mes = ultima_data + pd.DateOffset(months=i)

        receita_prevista = float(modelo_receita.predict([[novo_indice]])[0])
        custo_previsto = float(modelo_custo.predict([[novo_indice]])[0])
        lucro_previsto = receita_prevista - custo_previsto
        margem_prevista = (lucro_previsto / receita_prevista) * 100 if receita_prevista else 0

        futuros.append({
            "mes_referencia": mes.strftime("%Y-%m-01"),
            "receita_prevista": round(receita_prevista, 2),
            "custo_previsto": round(custo_previsto, 2),
            "lucro_previsto": round(lucro_previsto, 2),
            "margem_prevista": round(margem_prevista, 2)
        })

    return pd.DataFrame(futuros)

def salvar_previsao(df_prev):
    con = mysql.connector.connect(**DB_CONFIG)
    cur = con.cursor()

    cur.execute("""
        CREATE TABLE IF NOT EXISTS previsoes_financeiras (
            id INT AUTO_INCREMENT PRIMARY KEY,
            mes_referencia DATE NOT NULL,
            receita_real DECIMAL(15,2) NULL,
            receita_prevista DECIMAL(15,2) NOT NULL,
            custo_previsto DECIMAL(15,2) NOT NULL,
            lucro_previsto DECIMAL(15,2) NOT NULL,
            margem_prevista DECIMAL(8,2) NOT NULL
        )
    """)

    for _, row in df_prev.iterrows():
        cur.execute("""
            INSERT INTO previsoes_financeiras
            (mes_referencia, receita_prevista, custo_previsto, lucro_previsto, margem_prevista)
            VALUES (%s, %s, %s, %s, %s)
            ON DUPLICATE KEY UPDATE
                receita_prevista = VALUES(receita_prevista),
                custo_previsto = VALUES(custo_previsto),
                lucro_previsto = VALUES(lucro_previsto),
                margem_prevista = VALUES(margem_prevista)
        """, (
            row["mes_referencia"],
            row["receita_prevista"],
            row["custo_previsto"],
            row["lucro_previsto"],
            row["margem_prevista"]
        ))

    con.commit()
    cur.close()
    con.close()

if __name__ == "__main__":
    df = carregar_dados()
    df_prev = gerar_previsao(df, meses_futuros=6)
    salvar_previsao(df_prev)
    print("Previsões financeiras geradas com sucesso.")
