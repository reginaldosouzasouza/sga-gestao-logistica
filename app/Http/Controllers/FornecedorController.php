<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class FornecedorController extends Controller
{
    /**
     * Lista fornecedores somente da empresa logada.
     */
    public function index()
    {
        $empresaId = auth()->user()->empresa_id;

        $fornecedores = Fornecedor::where('empresa_id', $empresaId)
            ->orderBy('nome', 'asc')
            ->get();

        $totalFornecedores = $fornecedores->count();

        return view('fornecedores.index', compact('fornecedores', 'totalFornecedores'));
    }

    /**
     * Tela de cadastro.
     */
    public function create()
    {
        $naturezas = DB::table('naturezas_financeiras')
            ->where('ativo', 1)
            ->orderBy('nome')
            ->get();

        return view('fornecedores.create', compact('naturezas'));
    }

    /**
     * Grava novo fornecedor.
     */
    public function store(Request $request)
    {
        $empresaId = auth()->user()->empresa_id;

        $validatedData = $request->validate([
            'cnpj' => [
                'required',
                'max:18',
                Rule::unique('fornecedores', 'cnpj')
                    ->where(function ($query) use ($empresaId) {
                        return $query->where('empresa_id', $empresaId);
                    }),
            ],
            'nome' => 'required|max:255',
            'endereco' => 'required|max:255',
            'telefone' => 'required|max:255',
            'cidade' => 'nullable|max:255',
            'email' => 'nullable|email|max:255',
            'observacao' => 'nullable|max:255',
            'natureza_financeira_id' => 'nullable|exists:naturezas_financeiras,id',
        ]);

        $validatedData['empresa_id'] = $empresaId;

        Fornecedor::create($validatedData);

        return redirect()
            ->route('fornecedores.index')
            ->with('success', 'Fornecedor cadastrado com sucesso!');
    }

    /**
     * Importa fornecedor por XML de NF-e.
     */
    public function importarXML(Request $request)
    {
        $empresaId = auth()->user()->empresa_id;

        $request->validate([
            'xml' => 'nullable|file|mimes:xml,txt',
            'arquivo_xml' => 'nullable|file|mimes:xml,txt',
            'xml_file' => 'nullable|file|mimes:xml,txt',
        ]);

        $arquivo = $request->file('xml')
            ?? $request->file('arquivo_xml')
            ?? $request->file('xml_file');

        if (!$arquivo) {
            return redirect()
                ->back()
                ->with('error', 'Nenhum arquivo XML foi enviado.');
        }

        try {
            $conteudoXml = file_get_contents($arquivo->getRealPath());
            $xml = simplexml_load_string($conteudoXml);

            if (!$xml) {
                return redirect()
                    ->back()
                    ->with('error', 'Não foi possível ler o XML informado.');
            }

            $emitente = null;

            if (isset($xml->NFe->infNFe->emit)) {
                $emitente = $xml->NFe->infNFe->emit;
            } elseif (isset($xml->infNFe->emit)) {
                $emitente = $xml->infNFe->emit;
            } elseif (isset($xml->protNFe) && isset($xml->NFe->infNFe->emit)) {
                $emitente = $xml->NFe->infNFe->emit;
            }

            if (!$emitente) {
                return redirect()
                    ->back()
                    ->with('error', 'Não foi possível localizar os dados do emitente no XML.');
            }

            $cnpjOriginal = (string) ($emitente->CNPJ ?? '');
            $cnpj = $this->formatarCnpj($cnpjOriginal);

            $nome = trim((string) ($emitente->xNome ?? ''));
            $telefone = trim((string) ($emitente->enderEmit->fone ?? ''));
            $cidade = trim((string) ($emitente->enderEmit->xMun ?? ''));
            $logradouro = trim((string) ($emitente->enderEmit->xLgr ?? ''));
            $numero = trim((string) ($emitente->enderEmit->nro ?? ''));

            $endereco = trim($logradouro . ($numero ? ', ' . $numero : ''));

            if (!$cnpj || !$nome) {
                return redirect()
                    ->back()
                    ->with('error', 'O XML não possui CNPJ ou nome do fornecedor.');
            }

            $fornecedor = Fornecedor::where('empresa_id', $empresaId)
                ->where('cnpj', $cnpj)
                ->first();

            if ($fornecedor) {
                $fornecedor->update([
                    'nome' => $nome ?: $fornecedor->nome,
                    'endereco' => $endereco ?: $fornecedor->endereco,
                    'telefone' => $telefone ?: $fornecedor->telefone,
                    'cidade' => $cidade ?: $fornecedor->cidade,
                    'observacao' => $fornecedor->observacao ?: 'Atualizado via importação XML.',
                ]);

                return redirect()
                    ->route('fornecedores.index')
                    ->with('success', 'Fornecedor já existia nesta empresa e foi atualizado pelo XML.');
            }

            Fornecedor::create([
                'empresa_id' => $empresaId,
                'cnpj' => $cnpj,
                'nome' => $nome,
                'endereco' => $endereco ?: 'Não informado',
                'telefone' => $telefone ?: 'Não informado',
                'cidade' => $cidade ?: null,
                'email' => null,
                'observacao' => 'Fornecedor importado via XML.',
                'natureza_financeira_id' => null,
            ]);

            return redirect()
                ->route('fornecedores.index')
                ->with('success', 'Fornecedor importado com sucesso pelo XML.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erro ao importar XML: ' . $e->getMessage());
        }
    }

    /**
     * Exibe fornecedor somente se pertencer à empresa logada.
     */
    public function show($id)
    {
        $empresaId = auth()->user()->empresa_id;

        $fornecedor = Fornecedor::where('empresa_id', $empresaId)
            ->findOrFail($id);

        return view('fornecedores.show', compact('fornecedor'));
    }

    /**
     * Tela de edição somente se pertencer à empresa logada.
     */
    public function edit($id)
    {
        $empresaId = auth()->user()->empresa_id;

        $fornecedor = Fornecedor::where('empresa_id', $empresaId)
            ->findOrFail($id);

        $naturezas = DB::table('naturezas_financeiras')
            ->where('ativo', 1)
            ->orderBy('nome')
            ->get();

        return view('fornecedores.edit', compact('fornecedor', 'naturezas'));
    }

    /**
     * Atualiza fornecedor.
     */
    public function update(Request $request, $id)
    {
        $empresaId = auth()->user()->empresa_id;

        $fornecedor = Fornecedor::where('empresa_id', $empresaId)
            ->findOrFail($id);

        $validatedData = $request->validate([
            'cnpj' => [
                'required',
                'max:18',
                Rule::unique('fornecedores', 'cnpj')
                    ->where(function ($query) use ($empresaId) {
                        return $query->where('empresa_id', $empresaId);
                    })
                    ->ignore($fornecedor->id),
            ],
            'nome' => 'required|max:255',
            'endereco' => 'required|max:255',
            'telefone' => 'required|max:255',
            'cidade' => 'nullable|max:255',
            'email' => 'nullable|email|max:255',
            'observacao' => 'nullable|max:255',
            'natureza_financeira_id' => 'nullable|exists:naturezas_financeiras,id',
        ]);

        $fornecedor->update($validatedData);

        return redirect()
            ->route('fornecedores.index')
            ->with('success', 'Fornecedor atualizado com sucesso!');
    }

    /**
     * Exclui fornecedor somente se pertencer à empresa logada.
     */
    public function destroy($id)
    {
        $empresaId = auth()->user()->empresa_id;

        $fornecedor = Fornecedor::where('empresa_id', $empresaId)
            ->findOrFail($id);

        $fornecedor->delete();

        return redirect()
            ->route('fornecedores.index')
            ->with('success', 'Fornecedor deletado com sucesso!');
    }

    /**
     * Formata CNPJ vindo do XML.
     */
    private function formatarCnpj(?string $cnpj): ?string
    {
        if (!$cnpj) {
            return null;
        }

        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) !== 14) {
            return $cnpj;
        }

        return substr($cnpj, 0, 2) . '.' .
            substr($cnpj, 2, 3) . '.' .
            substr($cnpj, 5, 3) . '/' .
            substr($cnpj, 8, 4) . '-' .
            substr($cnpj, 12, 2);
    }
}