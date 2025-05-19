<?php

namespace App\Http\Controllers;

use App\Models\Inscrito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Rules\CpfValido;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function index(){
        $inscritosPendentes = Inscrito::where('status_pagamento', 'pendente')
                                        ->where('deleted_at',NULL)
                                        ->select('id', 'nome')
                                        ->paginate(10);
        $inscritosPagos = Inscrito::where('status_pagamento', 'pago')
                                    ->where('deleted_at',NULL)
                                    ->select('id','nome')
                                    ->paginate(10);
        return view('admin',compact('inscritosPendentes','inscritosPagos'));
    }

    public function aprovar($idCriptografado)
    {
        try {
            $id = Crypt::decryptString($idCriptografado);
            $inscrito = Inscrito::findOrFail($id);
            $inscrito->status_pagamento = 'pago';
            $inscrito->save();

            return redirect()->back()->with('success', 'Inscrição aprovada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('errorAprovar', 'Erro ao aprovar inscrição.');
        }
    }
    public function deletar($idCriptografado){
        try{
            $id = Crypt::decryptString($idCriptografado);
            $inscrito = Inscrito::findOrFail($id);
            $inscrito->delete();

            return redirect()->back()->with('success', 'Inscrição excluida com sucesso!');
        } catch (\Exception $e){
            return redirect()->back()->with('errorExcluir', 'Erro ao excluir inscrição.');
        }
        
    }

    public function editar($idCriptografado){
        $id = Crypt::decryptString($idCriptografado);
        $inscrito = Inscrito::where('id', $id)
                            ->select('id','nome','nome_responsavel','telefone_emergencia','email','logradouro','numero','complemento','bairro','cidade','uf','telefone','cep','ministerio','camisa','forma_pagamento','restricoes_alimentar','alergia','remedio_controlado','igreja')
                            ->first(); 

        return view('editarInscrito', ['inscrito' => $inscrito]);

    }

    public function editarSubmit(Request $request,$idCriptografado){
        $request->validate(
            [
                'nome' => 'required|max:49',
                'nome_responsavel' => 'required|max:49',
                'email' => 'required|email',
                'telefone' => 'required|max:19',
                'telefone_emergencia' => 'required|max:19',
                'cep'         => ['required', 'regex:/^\d{5}-\d{3}$/'],
                'logradouro'  => ['required', 'string', 'max:100'],
                'numero'      => ['nullable', 'string', 'max:10'],
                'complemento' => ['nullable', 'string', 'max:100'],
                'bairro'      => ['required', 'string', 'max:60'],
                'cidade'      => ['required', 'string', 'max:60'],
                'uf'          => ['required', 'regex:/^[A-Z]{2}$/'],
                'ministerio' => 'required',
                'forma_pagamento' => 'required',
                'restricoes_alimentar' => ['nullable','string','max:1000','regex:/^[\pL\s\d\.\,\-\(\)\!\?\/]+$/u'],
                'alergia' => ['nullable','string','max:1000','regex:/^[\pL\s\d\.\,\-\(\)\!\?\/]+$/u'],
                'remedio_controlado' => ['nullable','string','max:1000','regex:/^[\pL\s\d\.\,\-\(\)\!\?\/]+$/u'],
                'igreja' => 'required|max:49',
                'camisa' => 'required',

            ],
            [
                'nome.required' => 'O campo nome é Obrigatório.',
                'nome.max' => 'O campo nome deve ter no máximo 49 caracteres.',
                'nome_responsavel.required' => 'O campo nome do responsavel é Obrigatório.',
                'nome_responsavel.max' => 'O campo nome do responsavel deve ter no máximo 49 caracteres.',
                'email.required' => 'O campo email é Obrigatório.',
                'email.email' => 'O email inserido deve ser um email valido.',
                'telefone.required' => 'O campo telefone é obrigatório',
                'telefone_emergencia.required' => 'O campo telefone é Obrigatório',
                'telefone_emergencia.max' => 'O campo telefone deve ter no maximo 19 caracteres.',
                'telefone.max' => 'O campo telefone deve ter no maximo 19 caracteres.',
                'cep.required'        => 'O campo CEP é Obrigatório.',
                'cep.regex'           => 'O CEP deve estar no formato 00000-000.',
                'logradouro.required' => 'O logradouro é Obrigatório.',
                'logradouro.max'      => 'O logradouro não pode ter mais de 100 caracteres.',
                'numero.max'          => 'O número não pode ter mais de 10 caracteres.',
                'complemento.max'     => 'O complemento não pode ter mais de 100 caracteres.',
                'bairro.required'     => 'O bairro é Obrigatório.',
                'bairro.max'          => 'O bairro não pode ter mais de 60 caracteres.',
                'cidade.required'     => 'A cidade é Obrigatória.',
                'cidade.max'          => 'A cidade não pode ter mais de 60 caracteres.',
                'uf.required'         => 'O estado (UF) é Obrigatório.',
                'uf.size'             => 'O UF deve conter exatamente 2 letras.',
                'ministerio.required' => 'Este campo é obrigatório.',
                'camisa.required' => 'Este campo é obrigatório',
                'forma_pagamento.required' => 'Este campo é obrigatório.',
                'restricoes_alimentar.string' => 'O campo restrições alimentares deve ser um texto.',
                'restricoes_alimentar.max' => 'O campo restrições alimentares deve ter no máximo 1000 caracteres.',
                'restricoes_alimentar.regex' => 'O campo restrições alimentares contém caracteres inválidos.',
                'alergia.string' => 'O campo alergias deve ser um texto.',
                'alergia.max' => 'O campo alergias deve ter no máximo 1000 caracteres.',
                'alergia.regex' => 'O campo alergias contém caracteres inválidos.',
                'remedio_controlado.string' => 'O campo remédio controlado deve ser um texto.',
                'remedio_controlado.max' => 'O campo remédio controlado deve ter no máximo 1000 caracteres.',
                'remedio_controlado.regex' => 'O campo remédio controlado contém caracteres inválidos.',
                'igreja.required' => 'O campo igreja é Obrigatório.',
                'igreja.max' => 'O campo igreja deve ter no máximo 49 caracteres.',
            ]
        );
        $id = Crypt::decryptString($idCriptografado);


        $inscritoId = Inscrito::where('id',$id)
                                ->where('deleted_at',NULL)
                                ->first();

        $tamanhoCamisaPermitido = ['p','pp','m','g','gg'];
        $ministerioPermitido = ['sim','nao','louvor','teatro','dança','outro'];
        $formaPagamentoPermitido = ['pix','cartao','boleto'];

        if($inscritoId->camisa != $request->input('camisa')){
            if($request->input('camisa') === 'sim'){
                $inscritoId->camisa = 'sim';
                $inscritoId->tamanho_camisa = NULL;
            }
            if($request->input('camisa') === 'nao'){
                $inscritoId->camisa = $request->input('camisa');
                if(!in_array($request->input('tamanho'),$tamanhoCamisaPermitido)){
                    return redirect()
                            ->back()
                            ->withInput()
                            ->withErrors(['camisa' => 'Este tamanho de camisa não é permitido.']);
                }
                $inscritoId->tamanho_camisa = $request->input('tamanho');
                $inscritoId->camisa = 'nao';
            }
        }
        if(!in_array($request->input('ministerio'),$ministerioPermitido)){
            return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['ministerio' => 'Este ministério não é permitido.']);
        }
        if(!in_array($request->input('forma_pagamento'),$formaPagamentoPermitido)){
            return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['pagamento' => 'Esta forma de pagamento não é permitida.']);
        }
        $cep = $request->input('cep');
        $response = file_get_contents("https://viacep.com.br/ws/{$cep}/json/");
        $data = json_decode($response);


        if (isset($data->erro)) {
            return back()->withErrors(['cep' => 'CEP inválido']);
        }

        $inscritoId->nome = $request->input('nome');
        $inscritoId->nome_responsavel = $request->input('nome_responsavel');
        $inscritoId->email = $request->input('email');
        $inscritoId->telefone = $request->input('telefone');
        $inscritoId->telefone_emergencia = $request->input('telefone_emergencia');
        $inscritoId->cep = $data->cep;
        $inscritoId->logradouro = $data->logradouro;
        $inscritoId->numero = $request->input('numero');
        $inscritoId->complemento = $request->input('complemento');
        $inscritoId->bairro = $data->bairro;
        $inscritoId->cidade = $data->localidade;
        $inscritoId->uf = $data->uf;
        $inscritoId->ministerio = $request->input('ministerio');
        $inscritoId->forma_pagamento = $request->input('forma_pagamento');
        $inscritoId->restricoes_alimentar = $request->input('restricoes_alimentar');
        $inscritoId->alergia = $request->input('alergia');
        $inscritoId->remedio_controlado = $request->input('remedio_controlado');
        $inscritoId->igreja = $request->input('igreja');

        $inscritoId->save();
        return redirect()->route('admin');

    }
        public function relatorio()
    {
        $inscritos = Inscrito::where('status_pagamento','pago')
                            ->whereNull('deleted_at')
                            ->get();

        $pdf = Pdf::loadView('relatorio', compact('inscritos'))
          ->setPaper('a4', 'landscape');
        
        return $pdf->download('relatorio_inscritos.pdf');
    }
}
