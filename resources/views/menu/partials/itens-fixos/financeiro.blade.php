{{-- Contas a Pagar --}}
@if(auth()->user()->temPermissao('conta_pagar_visualizar'))
<a href="/contas-a-pagar" target="_blank">
    Contas a Pagar
    <img src="{{ asset('images/imagem/contas_a_pagar.png') }}" class="imagem">
</a>
@endif


{{-- Contas a Receber --}}
@if(auth()->user()->temPermissao('conta_receber_visualizar'))
<a href="/contas_a_receber" target="_blank">
    Contas a Receber
    <img src="{{ asset('images/imagem/contas_a_receber.png') }}" class="imagem">
</a>
@endif

{{-- Formas de Pagamento --}}
@if(auth()->user()->temPermissao('formas_de_pagamento_visualizar'))
<a href="/formas_de_pagamento" target="_blank">
    Formas de Pagamento <img src="{{ asset('images/imagem/formasdepagamento.png') }}" class="imagem">
</a>
@endif


{{-- Caixa --}}
@if(auth()->user()->temPermissao('caixa_visualizar'))
<a href="/caixa" target="_blank">
    Caixa
    <img src="{{ asset('images/imagem/caixaregistradora.png') }}" class="imagem">
</a>
@endif


{{-- Abrir Caixa --}}
@if(auth()->user()->temPermissao('caixa_abrir'))
<a href="/caixa/abrir" target="_blank">
    Abrir Caixa
    <img src="{{ asset('images/imagem/caixaregistradora.png') }}" class="imagem">
</a>
@endif