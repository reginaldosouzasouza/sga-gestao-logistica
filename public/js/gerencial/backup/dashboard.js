let chartReceitaDespesa = null;
let chartPagamentos = null;

async function carregarDashboard() {
    try {
        // =======================
        // DATA
        // =======================
        const elData = document.getElementById("filtroData");
        const data = elData ? elData.value : "";

        const url = `http://127.0.0.1:5000/gerencial/dashboard?data=${encodeURIComponent(data)}`;
        const res = await fetch(url);

        if (!res.ok) throw new Error("Erro ao buscar dashboard");

        const json = await res.json();

        // =======================
        // KPI - CAIXA (DINHEIRO)
        // =======================
        const valorCaixa = json.kpis.caixa;
        const elCaixa = document.getElementById("kpi-caixa");
        const cardCaixa = document.getElementById("cardCaixa");

        elCaixa.innerText = `R$ ${valorCaixa.toFixed(2).replace(".", ",")}`;

        cardCaixa.classList.remove("positivo", "negativo");
        cardCaixa.classList.add(valorCaixa < 0 ? "negativo" : "positivo");

        // =======================
        // KPI - CAIXA BANCO (PIX)
        // =======================
        document.getElementById("kpiBanco").innerText =
            `R$ ${json.kpis.banco.toFixed(2).replace(".", ",")}`;

        // =======================
        // KPI - RESULTADO DO DIA
        // =======================
        const valorDia = json.kpis.resultado_dia;
        const cardResultado = document.querySelector(".kpi-resultado");

        cardResultado.classList.remove("positivo", "negativo");
        cardResultado.classList.add(valorDia < 0 ? "negativo" : "positivo");

        document.getElementById("kpiResultadoDia").innerHTML =
            `R$ ${valorDia.toFixed(2).replace(".", ",")}
             <small id="kpiResultadoPct">${valorDia < 0 ? "▼" : "▲"}</small>`;

      
        // =======================
        // GRÁFICO RECEITA x DESPESA (DIÁRIO)
        // =======================
        const ctxRD = document.getElementById("chartReceitaDespesa");

        // ✅ CORREÇÃO: Somar todos os valores do objeto, não pegar só [0]
        const receitaDia = Object.values(json.serie_dias.receita || {})
            .reduce((acc, val) => acc + parseFloat(val || 0), 0);
        const despesaDia = Object.values(json.serie_dias.despesa || {})
            .reduce((acc, val) => acc + parseFloat(val || 0), 0);

        console.log("📊 Receita do Dia:", receitaDia); // Debug
        console.log("📊 Despesa do Dia:", despesaDia); // Debug

        if (!chartReceitaDespesa) {
            chartReceitaDespesa = new Chart(ctxRD, {
                type: "bar",
                data: {
                    labels: ["Receita", "Despesa"],
                    datasets: [{
                        label: "Valores do Dia",
                        data: [receitaDia, despesaDia],
                        backgroundColor: [
                            "#1e88e5", // AZUL → Receita
                            "#e53935"  // VERMELHO → Despesa
                        ],
                        borderRadius: 8,
                        barThickness: 80
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return `R$ ${context.raw.toFixed(2).replace(".", ",")}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: value => `R$ ${value}`
                            },
                            grid: { color: "#e0e0e0" }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        } else {
            chartReceitaDespesa.data.datasets[0].data = [receitaDia, despesaDia];
            chartReceitaDespesa.update();
        }


        // =======================
        // GRÁFICO FORMAS DE PAGAMENTO
        // =======================
        const fp = json.pagamentos;
        const ctxFP = document.getElementById("chartPagamento");

        const valores = [
            fp["Dinheiro"] || 0,
            fp["PIX"] || 0,
            fp["Cartão"] || 0,
            fp["Boleto"] || 0
        ];

        if (!chartPagamentos) {
            chartPagamentos = new Chart(ctxFP, {
                type: "bar",
                data: {
                    labels: ["Dinheiro", "PIX", "Cartão", "Boleto"],
                    datasets: [{
                        data: valores,
                        backgroundColor: [
                            "#43a047",
                            "#1e88e5",
                            "#fbc02d",
                            "#e53935"
                        ],
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: ctx =>
                                    ` R$ ${ctx.raw.toFixed(2).replace(".", ",")}`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: "#e0e0e0" }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        } else {
            chartPagamentos.data.datasets[0].data = valores;
            chartPagamentos.update();
        }

    } catch (e) {
        console.error("Erro no dashboard:", e);
    }
} // ⬅ FECHA carregarDashboard()

// =======================
// EVENTOS
// =======================
document.addEventListener("DOMContentLoaded", () => {
    carregarDashboard();

    const elData = document.getElementById("filtroData");
    if (elData) {
        elData.addEventListener("change", carregarDashboard);
    }
});