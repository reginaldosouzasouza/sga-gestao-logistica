<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Gerencial</title>

<style>

body{
    font-family:Arial, sans-serif;
    margin:20px;
    background:#f4f6f9;
}

.section-title{
    margin:35px 0 15px;
    font-weight:800;
    font-size:22px;
}

.grid-cards{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-bottom:20px;
}

.card-box{
    padding:20px;
    border-radius:12px;
    color:white;
    font-weight:600;
}

.bg-blue { background:#1976d2; }
.bg-orange { background:#f57c00; }
.bg-green { background:#388e3c; }
.bg-red { background:#d32f2f; }
.bg-dark { background:#37474f; }

.valor{
    font-size:32px;
    font-weight:800;
    margin-top:8px;
}

.sub{
    font-size:12px;
    opacity:0.9;
}

</style>

</head>

<body>

<h1>Dashboard Gerencial</h1>


<div class="section-title">📅 Previsão Financeira</div>

<form id="filtroPeriodo" style="margin-bottom:25px; display:flex; gap:15px; align-items:end; flex-wrap:wrap;">

<div>
<label>Data Início</label><br>
<input type="date" id="dataInicio">
</div>

<div>
<label>Data Fim</label><br>
<input type="date" id="dataFim">
</div>

<div>
<button type="submit">
Atualizar
</button>
</div>

</form>


<div class="grid-cards">

<div class="card-box bg-green">
💰 Caixa Atual
<div class="valor" id="caixaAtual">R$ 0,00</div>
<div class="sub">Caixa + Banco</div>
</div>

<div class="card-box bg-blue">
Contas a Receber
<div class="valor" id="contasReceber">R$ 0,00</div>
</div>

<div class="card-box bg-green">
Venda Potencial Estoque
<div class="valor" id="vendaPotencialEstoque">R$ 0,00</div>
</div>

</div>


<div class="grid-cards">

<div class="card-box bg-orange">
Resultado a Receber
<div class="valor" id="resultadoReceber">R$ 0,00</div>
</div>

<div class="card-box bg-dark">
Contas a Pagar
<div class="valor" id="contasPagar">R$ 0,00</div>
</div>

<div class="card-box bg-green" id="saldoCard">
Saldo Futuro Previsto
<div class="valor" id="saldoFuturoPrevisto">R$ 0,00</div>
</div>


</div>

<div class="section-title">📈 Vendas por Dia</div>

<div style="background:white; padding:20px; border-radius:12px; box-shadow:0 3px 10px rgba(0,0,0,0.1); margin-bottom:20px;">
    <canvas id="graficoVendasDia" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="section-title">📦 Produtos Mais Vendidos</div>

<div style="
background:white;
padding:20px;
border-radius:12px;
box-shadow:0 3px 10px rgba(0,0,0,0.1);
margin-bottom:30px;
">

<canvas id="graficoProdutos" height="120"></canvas>

</div>


<div class="section-title">📍 Vendas por Bairro</div>

<div style="
background:white;
padding:20px;
border-radius:12px;
box-shadow:0 3px 10px rgba(0,0,0,0.1);
margin-bottom:30px;
">

<canvas id="graficoBairros" height="120"></canvas>

</div>

<div class="section-title">👤 Clientes que Mais Compram</div>

<div style="
background:white;
padding:20px;
border-radius:12px;
box-shadow:0 3px 10px rgba(0,0,0,0.1);
margin-bottom:30px;
">

<canvas id="graficoClientes" height="120"></canvas>

</div>

<div class="section-title">💰 Ticket Médio por Cliente</div>

<div style="
background:white;
padding:20px;
border-radius:12px;
box-shadow:0 3px 10px rgba(0,0,0,0.1);
margin-bottom:30px;
">

<canvas id="graficoTicketClientes" height="120"></canvas>

</div>

<div class="section-title">⚠️ Previsão de Ruptura de Estoque</div>

<div style="
display:flex;
gap:20px;
background:white;
padding:20px;
border-radius:12px;
box-shadow:0 3px 10px rgba(0,0,0,0.1);
margin-bottom:30px;
">

<div style="flex:2;">
<canvas id="graficoRuptura" height="120"></canvas>
</div>

<div id="painelRuptura" style="
flex:1;
background:#696969;
color:white;
padding:20px;
border-radius:10px;
font-size:16px;
line-height:1.6;
">

<b>Informações de estoque</b>

<div id="infoRuptura"></div>

</div>

</div>


<!--  ****************      AQUI COMEÇA O JAVA SCRIPT   *************************************   -->


<script>

let graficoVendasDia = null;
let graficoProdutos = null;

document.addEventListener("DOMContentLoaded", function () {

    const campoInicio = document.getElementById("dataInicio");
    const campoFim = document.getElementById("dataFim");

    const hoje = new Date();

    const ano = hoje.getFullYear();
    const mes = String(hoje.getMonth() + 1).padStart(2, '0');
    const dia = String(hoje.getDate()).padStart(2, '0');

    campoInicio.value = `${ano}-${mes}-01`;
    campoFim.value = `${ano}-${mes}-${dia}`;

    carregarFinanceiro();

});



document.getElementById("filtroPeriodo").addEventListener("submit", function (e) {

    e.preventDefault();
    carregarFinanceiro();

});



function carregarFinanceiro() {

    const inicio = document.getElementById("dataInicio").value;
    const fim = document.getElementById("dataFim").value;

    fetch(`/dashboard/previsao-financeira?data_inicio=${inicio}&data_fim=${fim}`)
        .then(res => res.json())
        .then(data => {

            document.getElementById("caixaAtual").innerText = formatMoney(data.caixaAtual);
            document.getElementById("contasReceber").innerText = formatMoney(data.receberPrevisto);
            document.getElementById("vendaPotencialEstoque").innerText = formatMoney(data.vendaPotencialEstoque);
            document.getElementById("resultadoReceber").innerText = formatMoney(data.resultadoReceber);
            document.getElementById("contasPagar").innerText = formatMoney(data.contasPagar);
            document.getElementById("saldoFuturoPrevisto").innerText = formatMoney(data.saldoFuturo);

            const card = document.getElementById("saldoCard");

            if (data.saldoFuturo < 0) {
                card.classList.remove("bg-green");
                card.classList.add("bg-red");
            } else {
                card.classList.remove("bg-red");
                card.classList.add("bg-green");
            }

            carregarGraficoVendasPorDia();
            carregarGraficoProdutos();
            carregarGraficoBairros();
            carregarGraficoClientes();
            carregarGraficoTicketClientes();
            carregarGraficoRuptura();

        });

}



function formatMoney(valor) {

    return Number(valor || 0).toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });

}



function carregarGraficoVendasPorDia() {

    const inicio = document.getElementById("dataInicio").value;
    const fim = document.getElementById("dataFim").value;

    fetch(`/dashboard/vendas-por-dia?data_inicio=${inicio}&data_fim=${fim}`)
        .then(res => res.json())
        .then(dados => {

            const labels = dados.map(item => item.dia);

            const gas = dados.map(item => Number(item.gas));
            const agua = dados.map(item => Number(item.agua));

            const ctx = document.getElementById("graficoVendasDia").getContext("2d");

            if (graficoVendasDia) {
                graficoVendasDia.destroy();
            }

            graficoVendasDia = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [

                        {
                            label: 'Gás',
                            data: gas,
                            borderColor: '#ff7a00',
                            backgroundColor: '#ff7a00',
                            borderWidth: 3,
                            tension: 0.3
                        },

                        {
                            label: 'Água',
                            data: agua,
                            borderColor: '#2196f3',
                            backgroundColor: '#2196f3',
                            borderWidth: 3,
                            tension: 0.3
                        }

                    ]
                },
                options: {
                    responsive: true
                }
            });

        });

}



function carregarGraficoProdutos() {

    const inicio = document.getElementById("dataInicio").value;
    const fim = document.getElementById("dataFim").value;

    fetch(`/dashboard/produtos-mais-vendidos?data_inicio=${inicio}&data_fim=${fim}`)
        .then(res => res.json())
        .then(dados => {

            console.log("Produtos:", dados);

            const labels = dados.map(item => item.produto);
            const valores = dados.map(item => Number(item.total));

            // cores diferentes por produto
            const cores = labels.map(produto => {

                if (produto.toUpperCase().includes("GAS"))
                    return "#ff7a00"; // laranja

                if (produto.toUpperCase().includes("AGUA"))
                    return "#2196f3"; // azul

                return "#999"; // padrão

            });

            const ctx = document.getElementById("graficoProdutos").getContext("2d");

            if (graficoProdutos) {
                graficoProdutos.destroy();
            }

            graficoProdutos = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Produtos Mais Vendidos',
                        data: valores,
                        backgroundColor: cores
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

        })
        .catch(err => console.error("Erro gráfico produtos:", err));

}

let graficoBairros = null;

function carregarGraficoBairros(){

    const inicio = document.getElementById("dataInicio").value;
    const fim = document.getElementById("dataFim").value;

    fetch(`/dashboard/vendas-por-bairro?data_inicio=${inicio}&data_fim=${fim}`)
    .then(res => res.json())
    .then(dados => {

        const labels = dados.map(item => item.bairro);
        const valores = dados.map(item => Number(item.total));

        // cores automáticas para cada bairro
        const cores = [
            "#4caf50",
            "#2196f3",
            "#ff9800",
            "#9c27b0",
            "#e91e63",
            "#00bcd4",
            "#ffc107",
            "#8bc34a",
            "#795548",
            "#607d8b"
        ];

        const ctx = document.getElementById("graficoBairros").getContext("2d");

        if(graficoBairros){
            graficoBairros.destroy();
        }

        graficoBairros = new Chart(ctx,{
            type:'bar',
            data:{
                labels:labels,
                datasets:[{
                    label:'Vendas por Bairro',
                    data:valores,
                    backgroundColor: cores.slice(0, labels.length)
                }]
            },
            options:{
                responsive:true,
                plugins:{
                    legend:{
                        display:false
                    }
                }
            }
        });

    });

    
}


let graficoClientes = null;

function carregarGraficoClientes(){

const inicio = document.getElementById("dataInicio").value;
const fim = document.getElementById("dataFim").value;

fetch(`/dashboard/vendas-por-cliente?data_inicio=${inicio}&data_fim=${fim}`)
.then(res => res.json())
.then(dados => {

const labels = dados.map(item => item.cliente);

const gas = dados.map(item => Number(item.gas));
const agua = dados.map(item => Number(item.agua));

const ctx = document.getElementById("graficoClientes").getContext("2d");

if(graficoClientes){
graficoClientes.destroy();
}

graficoClientes = new Chart(ctx,{
type:'bar',
data:{
labels:labels,
datasets:[

{
label:'Gás',
data:gas,
backgroundColor:'#ff7a00'
},

{
label:'Água',
data:agua,
backgroundColor:'#2196f3'
}

]
},
options:{
responsive:true,
plugins:{
legend:{
display:true
}
}
}
});

});

}


let graficoTicketClientes = null;

function carregarGraficoTicketClientes(){

    const inicio = document.getElementById("dataInicio").value;
    const fim = document.getElementById("dataFim").value;

    fetch(`/dashboard/ticket-medio-clientes?data_inicio=${inicio}&data_fim=${fim}`)
    .then(res => res.json())
    .then(dados => {

        console.log("Ticket médio clientes:", dados);

        const labels = dados.map(item => item.cliente);
        const gas = dados.map(item => Number(item.gas));
        const agua = dados.map(item => Number(item.agua));

        const canvas = document.getElementById("graficoTicketClientes");

        if(!canvas){
            console.error("Canvas graficoTicketClientes não encontrado");
            return;
        }

        const ctx = canvas.getContext("2d");

        if(graficoTicketClientes){
            graficoTicketClientes.destroy();
        }

        graficoTicketClientes = new Chart(ctx,{
            type:'bar',
            data:{
                labels:labels,
                datasets:[

                {
                    label:'Gás (R$)',
                    data:gas,
                    backgroundColor:'#ff7a00'
                },

                {
                    label:'Água (R$)',
                    data:agua,
                    backgroundColor:'#2196f3'
                }

                ]
            },
            options:{
                responsive:true,
                plugins:{
                    legend:{
                        display:true
                    }
                }
            }
        });

    })
    .catch(err => console.error("Erro Ticket Médio:", err));

}


let graficoRuptura = null;

function carregarGraficoRuptura() {

    const inicio = document.getElementById("dataInicio").value;
    const fim = document.getElementById("dataFim").value;

    fetch(`/dashboard/previsao-ruptura?data_inicio=${inicio}&data_fim=${fim}`)
    .then(res => res.json())
    .then(dados => {

        console.log("Ruptura:", dados);

        const labels = dados.map(item => item.produto);
        const valores = dados.map(item => Number(item.dias));

        const cores = dados.map(item => {

            if(item.dias <= 3) return "#e53935"; // vermelho
            if(item.dias <= 7) return "#fbc02d"; // amarelo
            return "#43a047"; // verde

        });

        const canvas = document.getElementById("graficoRuptura");
        if (!canvas) return;

        const ctx = canvas.getContext("2d");

        if (graficoRuptura) {
            graficoRuptura.destroy();
        }

        graficoRuptura = new Chart(ctx, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [{
                    label: "Dias restantes para acabar",
                    data: valores,
                    backgroundColor: cores
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Dias restantes: ${context.raw}`;
                            }
                        }
                    }
                }
            }
        });

    let html = "";

        dados.forEach(item => {

        let cor = "#43a047";
        let status = "Estoque seguro";

        if(item.dias <= 3){
        cor = "#e53935";
        status = "Risco crítico";
        }
        else if(item.dias <= 7){
        cor = "#fbc02d";
        status = "Atenção";
        }

        html += `
        <div style="
        background:white;
        border-radius:10px;
        padding:15px;
        margin-bottom:15px;
        box-shadow:0 2px 6px rgba(0,0,0,0.08);
        border-left:6px solid ${cor};
        color:#333;
        ">

        <h3 style="margin-bottom:10px;">${item.produto}</h3>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;font-size:14px;">

        <div>
        <span style="color:#666;">Estoque atual</span><br>
        <b style="font-size:18px;">${item.estoque}</b>
        </div>

        <div>
        <span style="color:#666;">Vendido no período</span><br>
        <b style="font-size:18px;">${item.vendido_periodo}</b>
        </div>

        <div>
        <span style="color:#666;">Média por dia(vendas)</span><br>
        <b style="font-size:18px;">${item.media}</b>
        </div>

        <div>
        <span style="color:#666;">Estoque no máximo (em dias)</span><br>
        <b style="font-size:18px;">${item.dias}</b>
        </div>

        </div>

        <div style="
        margin-top:12px;
        padding:6px 12px;
        border-radius:6px;
        background:${cor};
        color:white;
        font-weight:bold;
        font-size:13px;
        display:inline-block;
        ">
        ${status}
        </div>

        </div>
        `;

      

        });

        document.getElementById("infoRuptura").innerHTML = html;   

    })
    .catch(err => console.error("Erro ruptura:", err));
}

</script>

</body>
</html>