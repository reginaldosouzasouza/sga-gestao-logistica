<h2>Permissões do Perfil: {{ $perfil->nome }}</h2>

<form method="POST">
@csrf

@php
$modulos = [];
foreach($permissoes as $p){
    $modulos[$p->modulo][] = $p;
}
@endphp

@foreach($modulos as $modulo => $lista)

<h3 style="margin-top:25px;background:#eee;padding:8px">
{{ strtoupper($modulo) }}
</h3>

<table border="1" cellpadding="6" width="600">
<tr>
<th>Permissão</th>
<th>Liberado</th>
</tr>

@foreach($lista as $perm)

<tr>
<td>{{ $perm->descricao }}</td>

<td align="center">

<input
type="checkbox"
name="permissoes[]"
value="{{ $perm->id }}"

@if(in_array($perm->id,$permissoesPerfil))
checked
@endif

>

</td>
</tr>

@endforeach

</table>

@endforeach


<br>
<button type="submit">Salvar Permissões</button>

</form>