@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Sistema de Gestão Aplicada</h2>

  <div class="row g-4 mt-3">
    @can('acesso_padaria')
    <div class="col-md-3">
      <a href="{{ route('padaria.entry') }}" class="text-decoration-none">
        <div class="card h-100">
          <img class="card-img-top" src="/img/padaria.png" alt="Padaria">
          <div class="card-body"><h5 class="card-title">Padaria</h5></div>
        </div>
      </a>
    </div>
    @endcan

    @can('acesso_oficina')
    <div class="col-md-3">
      <a href="{{ route('oficina.entry') }}" class="text-decoration-none">
        <div class="card h-100">
          <img class="card-img-top" src="/img/oficina.png" alt="Oficina">
          <div class="card-body"><h5 class="card-title">Oficina</h5></div>
        </div>
      </a>
    </div>
    @endcan

    @can('acesso_gas')
    <div class="col-md-3">
      <a href="{{ route('gas.entry') }}" class="text-decoration-none">
        <div class="card h-100">
          <img class="card-img-top" src="/img/gas.png" alt="Gás">
          <div class="card-body"><h5 class="card-title">Revenda de Gás</h5></div>
        </div>
      </a>
    </div>
    @endcan

    @can('acesso_gerencial')
    <div class="col-md-3">
      <a href="{{ route('gerencial.entry') }}" class="text-decoration-none">
        <div class="card h-100">
          <img class="card-img-top" src="/img/gerencial.png" alt="Gerencial">
          <div class="card-body"><h5 class="card-title">Gerencial</h5></div>
        </div>
      </a>
    </div>
    @endcan
  </div>
</div>
@endsection
