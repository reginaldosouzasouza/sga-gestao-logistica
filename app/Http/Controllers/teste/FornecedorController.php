<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor;
use SimpleXMLElement;

class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fornecedores = Fornecedor::all();
        return view('fornecedores.index', compact('fornecedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fornecedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $validatedData = $request->validate([
            'cnpj' => 'required|unique:fornecedores|max:18',
            'nome' => 'required|max:255',
            'endereco' => 'required|max:255',
            'telefone' => 'required|max:255',
            'cidade' => 'nullable|max:255',
            'email' => 'nullable|email|max:255',
            'observacao' => 'nullable|max:255',
        ]);

        // Criar novo fornecedor
        Fornecedor::create($validatedData);

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor cadastrado com sucesso!');
    }

    /**
     * Método para importar dados do XML da NF-e.*/
     
     public function importarXML(Request $request)
     {
         // Validação do arquivo XML
         $request->validate([
             'xml_file' => 'required|file|mimes:xml',
         ]);
     
         // Carregar o arquivo XML enviado
         $xml = simplexml_load_file($request->file('xml_file'));
     
         // Navegar para dentro do elemento NFe
         $nfe = $xml->NFe;
     
         // Verificar se o elemento NFe existe
         if (!$nfe) {
             return redirect()->back()->withErrors(['error' => 'O XML não contém o elemento <NFe>.']);
         }
     
         // Extrair dados do fornecedor do XML ajustado
         $cnpj = isset($nfe->infNFe->emit->CNPJ) ? $this->formatarCNPJ((string) $nfe->infNFe->emit->CNPJ) : null;
         $nome = isset($nfe->infNFe->emit->xNome) ? (string) $nfe->infNFe->emit->xNome : null;
     
         // Definir variáveis de endereço, número e bairro
         $endereco = isset($nfe->infNFe->emit->enderEmit->xLgr) ? (string) $nfe->infNFe->emit->enderEmit->xLgr : null;
         $numero = isset($nfe->infNFe->emit->enderEmit->nro) ? (string) $nfe->infNFe->emit->enderEmit->nro : '';
         $bairro = isset($nfe->infNFe->emit->enderEmit->xBairro) ? (string) $nfe->infNFe->emit->enderEmit->xBairro : '';
     
         // Concatenar endereço, número e bairro
         $enderecoCompleto = trim("$endereco, $numero, $bairro");
     
         $telefone = isset($nfe->infNFe->emit->enderEmit->fone) ? (string) $nfe->infNFe->emit->enderEmit->fone : null;
         $cidade = isset($nfe->infNFe->emit->enderEmit->xMun) ? (string) $nfe->infNFe->emit->enderEmit->xMun : null;
     
         // Verificar se os dados estão completos
         if (empty($cnpj) || empty($nome) || empty($endereco) || empty($cidade)) {
             return redirect()->back()->withErrors(['error' => 'O XML não contém todas as informações necessárias do fornecedor.']);
         }
     
         // Redirecionar para o formulário de criação com dados preenchidos
         return view('fornecedores.create', compact('cnpj', 'nome', 'enderecoCompleto', 'telefone', 'cidade'));
     }
     
   

        private function formatarCNPJ($cnpj)
        {
            // Verificar se o CNPJ contém apenas números e possui 14 dígitos
            if (preg_match('/^\d{14}$/', $cnpj)) {
                return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $cnpj);
            }
            return $cnpj; // Retornar o CNPJ sem formatação se não estiver no formato esperado
        }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        return view('fornecedores.show', compact('fornecedor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        return view('fornecedores.edit', compact('fornecedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $fornecedor = Fornecedor::findOrFail($id);

        $fornecedor->update($request->all());

        return redirect()->route('fornecedores.index')
            ->with('success', 'Fornecedor atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->delete();

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor deletado com sucesso!');
    }
}

