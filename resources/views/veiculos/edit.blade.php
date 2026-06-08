@extends('layouts.app')

@section('title', 'Editar Veículo')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/veiculos.css') }}">
@endsection

@section('content')

<div class="veiculos-page">

    <h2>Editar Veículo</h2>

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

    <form action="{{ route('veiculos.update', $veiculo->id) }}" method="POST">
        @csrf
        @method('PUT')

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
                            value="{{ old('descricao', $veiculo->descricao) }}" 
                            required
                        >
                    </div>

                    <div class="veiculos-field field-20">
                        <label>Placa</label>
                        <input 
                            type="text" 
                            name="placa" 
                            value="{{ old('placa', $veiculo->placa) }}"
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
                                    {{ old('motorista_id', $veiculo->motorista_id) == $motorista->id ? 'selected' : '' }}
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
                            value="{{ old('marca', $veiculo->marca) }}"
                        >
                    </div>

                    <div class="veiculos-field field-25">
                        <label>Modelo</label>
                        <input 
                            type="text" 
                            name="modelo" 
                            value="{{ old('modelo', $veiculo->modelo) }}"
                        >
                    </div>

                    <div class="veiculos-field field-15">
                        <label>Ano</label>
                        <input 
                            type="number" 
                            name="ano" 
                            value="{{ old('ano', $veiculo->ano) }}"
                        >
                    </div>

                    <div class="veiculos-field field-25">
                        <label>Tipo</label>
                        <select name="tipo">
                            <option value="">Selecione</option>
                            <option value="Moto" {{ old('tipo', $veiculo->tipo) == 'Moto' ? 'selected' : '' }}>Moto</option>
                            <option value="Carro" {{ old('tipo', $veiculo->tipo) == 'Carro' ? 'selected' : '' }}>Carro</option>
                            <option value="Caminhonete" {{ old('tipo', $veiculo->tipo) == 'Caminhonete' ? 'selected' : '' }}>Caminhonete</option>
                            <option value="Caminhão" {{ old('tipo', $veiculo->tipo) == 'Caminhão' ? 'selected' : '' }}>Caminhão</option>
                            <option value="Outro" {{ old('tipo', $veiculo->tipo) == 'Outro' ? 'selected' : '' }}>Outro</option>
                        </select>
                    </div>
                </div>

                <div class="veiculos-row">
                    <div class="veiculos-field field-25">
                        <label>Combustível</label>
                        <select name="combustivel">
                            <option value="">Selecione</option>
                            <option value="Gasolina" {{ old('combustivel', $veiculo->combustivel) == 'Gasolina' ? 'selected' : '' }}>Gasolina</option>
                            <option value="Etanol" {{ old('combustivel', $veiculo->combustivel) == 'Etanol' ? 'selected' : '' }}>Etanol</option>
                            <option value="Flex" {{ old('combustivel', $veiculo->combustivel) == 'Flex' ? 'selected' : '' }}>Flex</option>
                            <option value="Diesel" {{ old('combustivel', $veiculo->combustivel) == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="GNV" {{ old('combustivel', $veiculo->combustivel) == 'GNV' ? 'selected' : '' }}>GNV</option>
                            <option value="Outro" {{ old('combustivel', $veiculo->combustivel) == 'Outro' ? 'selected' : '' }}>Outro</option>
                        </select>
                    </div>

                    <div class="veiculos-field field-25">
                        <label>Tipo de Comissão</label>
                        <select name="comissao_tipo">
                            <option value="">Sem comissão</option>
                            <option value="percentual" {{ old('comissao_tipo', $veiculo->comissao_tipo) == 'percentual' ? 'selected' : '' }}>
                                Percentual %
                            </option>
                            <option value="fixa" {{ old('comissao_tipo', $veiculo->comissao_tipo) == 'fixa' ? 'selected' : '' }}>
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
                            value="{{ old('comissao_valor', $veiculo->comissao_valor) }}"
                        >
                    </div>
                </div>

                <div class="veiculos-row">
                    <div class="veiculos-field field-100">
                        <label>Observação</label>
                        <textarea 
                            name="observacao" 
                            rows="4"
                        >{{ old('observacao', $veiculo->observacao) }}</textarea>
                    </div>
                </div>

                <div class="veiculos-checkbox">
                    <input 
                        type="checkbox" 
                        name="ativo" 
                        id="ativo" 
                        value="1" 
                        {{ old('ativo', $veiculo->ativo) ? 'checked' : '' }}
                    >

                    <label for="ativo">Veículo ativo</label>
                </div>

            </div>
        </div>

        <div class="veiculos-actions">
            <button type="submit" class="btn-salvar">
                Atualizar Veículo
            </button>

            <a href="{{ route('veiculos.index') }}" class="btn-cancelar">
                Cancelar
            </a>
        </div>

    </form>

</div>

@endsection