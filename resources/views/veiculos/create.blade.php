@extends('layouts.app')

@section('title', 'Novo Veículo')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/veiculos.css') }}">
@endsection

@section('content')

<div class="veiculos-page">

    <h2>Cadastrar Veículo</h2>

    @if($errors->any())
        <div class="veiculos-alert-danger">
            <strong>Verifique os campos abaixo:</strong>
            <ul>
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('veiculos.store') }}" method="POST">
        @csrf

        <div class="veiculos-form-card">

            <div class="veiculos-form-header">
                Dados do Veículo
            </div>

            <div class="veiculos-form-body">

                <div class="veiculos-row">
                    <div class="veiculos-field field-35">
                        <label>Descrição *</label>
                        <input 
                            type="text" 
                            name="descricao" 
                            value="{{ old('descricao') }}" 
                            placeholder="Ex: Moto Entrega 01"
                            required
                        >
                    </div>

                    <div class="veiculos-field field-20">
                        <label>Placa</label>
                        <input 
                            type="text" 
                            name="placa" 
                            value="{{ old('placa') }}"
                            placeholder="Ex: ABC-1234"
                        >
                    </div>

                    <div class="veiculos-field field-35">
                        <label>Motorista Vinculado</label>
                        <select name="motorista_id">
                            <option value="">Sem motorista vinculado</option>

                            @foreach($motoristas as $motorista)
                                <option 
                                    value="{{ $motorista->id }}"
                                    {{ old('motorista_id') == $motorista->id ? 'selected' : '' }}
                                >
                                    {{ $motorista->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="veiculos-row">
                    <div class="veiculos-field field-25">
                        <label>Marca</label>
                        <input 
                            type="text" 
                            name="marca" 
                            value="{{ old('marca') }}"
                            placeholder="Ex: Honda"
                        >
                    </div>

                    <div class="veiculos-field field-25">
                        <label>Modelo</label>
                        <input 
                            type="text" 
                            name="modelo" 
                            value="{{ old('modelo') }}"
                            placeholder="Ex: CG 160"
                        >
                    </div>

                    <div class="veiculos-field field-15">
                        <label>Ano</label>
                        <input 
                            type="number" 
                            name="ano" 
                            value="{{ old('ano') }}"
                            placeholder="2024"
                        >
                    </div>

                    <div class="veiculos-field field-25">
                        <label>Tipo</label>
                        <select name="tipo">
                            <option value="">Selecione</option>
                            <option value="Moto" {{ old('tipo') == 'Moto' ? 'selected' : '' }}>Moto</option>
                            <option value="Carro" {{ old('tipo') == 'Carro' ? 'selected' : '' }}>Carro</option>
                            <option value="Caminhonete" {{ old('tipo') == 'Caminhonete' ? 'selected' : '' }}>Caminhonete</option>
                            <option value="Caminhão" {{ old('tipo') == 'Caminhão' ? 'selected' : '' }}>Caminhão</option>
                            <option value="Outro" {{ old('tipo') == 'Outro' ? 'selected' : '' }}>Outro</option>
                        </select>
                    </div>
                </div>

                <div class="veiculos-row">
                    <div class="veiculos-field field-25">
                        <label>Combustível</label>
                        <select name="combustivel">
                            <option value="">Selecione</option>
                            <option value="Gasolina" {{ old('combustivel') == 'Gasolina' ? 'selected' : '' }}>Gasolina</option>
                            <option value="Etanol" {{ old('combustivel') == 'Etanol' ? 'selected' : '' }}>Etanol</option>
                            <option value="Flex" {{ old('combustivel') == 'Flex' ? 'selected' : '' }}>Flex</option>
                            <option value="Diesel" {{ old('combustivel') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="GNV" {{ old('combustivel') == 'GNV' ? 'selected' : '' }}>GNV</option>
                            <option value="Outro" {{ old('combustivel') == 'Outro' ? 'selected' : '' }}>Outro</option>
                        </select>
                    </div>

                    <div class="veiculos-field field-25">
                        <label>Tipo de Comissão</label>
                        <select name="comissao_tipo">
                            <option value="">Sem comissão</option>
                            <option value="percentual" {{ old('comissao_tipo') == 'percentual' ? 'selected' : '' }}>
                                Percentual %
                            </option>
                            <option value="fixa" {{ old('comissao_tipo') == 'fixa' ? 'selected' : '' }}>
                                Valor Fixo R$
                            </option>
                        </select>
                    </div>

                    <div class="veiculos-field field-25">
                        <label>Valor da Comissão</label>
                        <input 
                            type="number" 
                            step="0.01" 
                            min="0"
                            name="comissao_valor" 
                            value="{{ old('comissao_valor', '0.00') }}"
                            placeholder="0,00"
                        >
                    </div>
                </div>

                <div class="veiculos-row">
                    <div class="veiculos-field field-100">
                        <label>Observação</label>
                        <textarea 
                            name="observacao" 
                            rows="4"
                        >{{ old('observacao') }}</textarea>
                    </div>
                </div>

                <div class="veiculos-checkbox">
                    <input 
                        type="checkbox" 
                        name="ativo" 
                        id="ativo" 
                        value="1" 
                        checked
                    >

                    <label for="ativo">Veículo ativo</label>
                </div>

            </div>
        </div>

        <div class="veiculos-actions">
            <button type="submit" class="btn-salvar">
                Salvar Veículo
            </button>

            <a href="{{ route('veiculos.index') }}" class="btn-cancelar">
                Cancelar
            </a>
        </div>

    </form>

</div>

@endsection