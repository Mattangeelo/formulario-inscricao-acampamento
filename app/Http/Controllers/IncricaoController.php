<?php

namespace App\Http\Controllers;

use App\Mail\InscricaoConfirmada;
use App\Models\Inscrito;
use Illuminate\Http\Request;
use App\Rules\CpfValido;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class IncricaoController extends Controller
{
    public function index(){
        $response = response()->view('inscricao');
        $response->headers->set('Cache-Control','no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma','no-cache');
        $response->headers->set('Expires','Sat, 01 Jan 2000 00:00:00 GMT');

        return $response;
    }

    public function inscricaoSubmit(Request $request){
        $request->validate(
            [
                'nome' => 'required|max:49',
                'nome_responsavel' => 'required|max:49',
                'cpf' => ['required', 'regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', new CpfValido],
                'email' => 'required|email',
                'senha' => 'required|min:6|max:16',
                'telefone' => 'required|max:19',
                'telefone_emergencia' => 'required|max:19',
                'data_nascimento' => 'required|date|before_or_equal:' . now()->subYears(14)->format('Y-m-d'),
                'cep'         => ['required', 'regex:/^\d{5}-\d{3}$/'],
                'logradouro'  => ['required', 'string', 'max:100'],
                'numero'      => ['nullable', 'string', 'max:10'],
                'complemento' => ['nullable', 'string', 'max:100'],
                'bairro'      => ['required', 'string', 'max:60'],
                'cidade'      => ['required', 'string', 'max:60'],
                'uf'          => ['required', 'regex:/^[A-Z]{2}$/'],
                'ministerio' => 'required',
                'camisa' => 'required',
                'forma_pagamento' => 'required',
                'restricoes_alimentar' => ['nullable','string','max:1000','regex:/^[\pL\s\d\.\,\-\(\)\!\?\/]+$/u'],
                'alergia' => ['nullable','string','max:1000','regex:/^[\pL\s\d\.\,\-\(\)\!\?\/]+$/u'],
                'remedio_controlado' => ['nullable','string','max:1000','regex:/^[\pL\s\d\.\,\-\(\)\!\?\/]+$/u'],
                'igreja' => 'required|max:49',
                'termos' => 'accepted'

            ],
            [
                'nome.required' => 'O campo nome é Obrigatório.',
                'nome.max' => 'O campo nome deve ter no máximo 49 caracteres.',
                'nome_responsavel.required' => 'O campo nome do responsavel é Obrigatório.',
                'nome_responsavel.max' => 'O campo nome do responsavel deve ter no máximo 49 caracteres.',
                'cpf.required' => 'O campo CPF é Obrigatório.',
                'cpf.regex' => 'O CPF deve estar no formato 000.000.000-00.',
                'cpf.CpfValido' => 'O CPF informado é inválido.',
                'email.required' => 'O campo email é Obrigatório.',
                'email.email' => 'O email inserido deve ser um email válido.',
                'senha.required' => 'O campo Senha é Obrigatório.',
                'senha.min' => 'O campo senha deve conter pelo menos 6 caracteres.',
                'senha.max' => 'O campo senha deve no máximo 16 caracteres.',
                'telefone.required' => 'O campo telefone é Obrigatório',
                'telefone.max' => 'O campo telefone deve ter no maximo 19 caracteres.',
                'telefone_emergencia.required' => 'O campo telefone é Obrigatório',
                'telefone_emergencia.max' => 'O campo telefone deve ter no maximo 19 caracteres.',
                'data_nascimento.required' => 'O campo Data de nascimento é Obrigatório.',
                'data_nascimento.date' => 'Este campo precisa ser preenchido com uma data válida.',
                'data_nascimento.before_or_equal' => 'Você precisa ter mais de 14 anos para se inscrever.',
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
                'ministerio.required' => 'Este campo é Obrigatório.',
                'camisa.required' => 'O campo Camisa é Obrigatório',
                'forma_pagamento.required' => 'Este campo é Obrigatório.',
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
                'termos.accepted' => 'Você precisa aceitar os termos para continuar'
            ]);


        $tamanhoCamisaPermitido = ['p','pp','m','g','gg'];
        $ministerioPermitido = ['sim','nao','louvor','teatro','dança','outro'];
        $formaPagamentoPermitido = ['pix','cartao','boleto'];

        $nome = trim(strip_tags($request->input('nome')));
        $nome_responsavel = $request->input('nome_responsavel');
        $cpf = $request->input('cpf');
        $email = strtolower(trim($request->input('email')));
        $senha = $request->input('senha');
        $telefone = $request->input('telefone');
        $telefone_emergencia = $request->input('telefone_emergencia');
        $cep = $request->input('cep');
        $logradouro = $request->input('logradouro');
        $numero = $request->input('numero');
        $complemento = $request->input('complemento');
        $bairro = $request->input('bairro');
        $cidade = $request->input('cidade');
        $uf = $request->input('uf');
        $restricoes_alimentar = strip_tags($request->input('restricoes_alimentar'));
        $alergia = $request->input('alergia');
        $remedio_controlado = $request->input('remedio_controlado');
        $data_nascimento = $request->input('data_nascimento');
        $igreja = $request->input('igreja');
        $camisa = $request->input('camisa');
        $tamanhoCamisa = $request->input('tamanho');
        $ministerio = $request->input('ministerio');
        $formaPagamento = $request->input('forma_pagamento');
        $aceitouTermos = $request->has('termos');

        $inscritoEmail = Inscrito::where('email',$email)
                                ->where('deleted_at',NULL)
                                ->first();
        
        if($inscritoEmail){
            return redirect()->back()->withInput()->with('emailError','Este email já esta cadastrado,Por favor tente outro email.');
        }
        
        $inscritoCpf = Inscrito::where('cpf',$cpf)
                                ->where('deleted_at',NULL)
                                ->first();
        
        if($inscritoCpf){
            return redirect()->route('login')->with('loginError','Esse cpf ja possui um cadastro');
        }
        if (Carbon::parse($data_nascimento)->isFuture()) {
            return redirect()->back()->withInput()->with('dataNascimentoError', 'A data de nascimento não pode estar no futuro.');
        }

        if (!in_array($camisa, ['sim', 'nao'])) {
            return redirect()->back()
                ->withInput()
                ->with('camisaError', 'O valor selecionado para "Já possui camisa?" é inválido.');
        }
        if ($camisa === 'sim') {
            $tamanhoCamisa = null;
        }
        
        if ($camisa === 'nao') {
            $tamanhoCamisaFormatado = strtolower($tamanhoCamisa);
            if (empty($tamanhoCamisaFormatado) || !in_array($tamanhoCamisaFormatado, $tamanhoCamisaPermitido)) {
                return redirect()->back()
                    ->withInput()
                    ->with('tamanhoError', 'Você deve informar um tamanho válido de camisa se não tiver uma.');
            }
        }
        $response = file_get_contents("https://viacep.com.br/ws/{$cep}/json/");
        $data = json_decode($response);

        if (isset($data->erro)) {
            return back()->withErrors(['cep' => 'CEP inválido']);
        }

        if(!in_array($ministerio,$ministerioPermitido)){
            return redirect()->back()->withInput()->with('ministerioError', 'O ministério escolhido não é permitido.');
        }
        if(!in_array($formaPagamento,$formaPagamentoPermitido)){
            return redirect()->back()->withInput()->with('pagamentoError', 'A forma de pagamento não é permitida.');
        }
        

        $data = [
            'nome' => $nome,
            'nome_responsavel' => $nome_responsavel,
            'senha' =>Hash::make($senha),
            'cpf' =>$cpf,
            'email' => $email,
            'telefone' => $telefone,
            'data_nascimento' => $data_nascimento,
            'camisa' => $camisa,
            'tamanho_camisa' => $tamanhoCamisa,
            'telefone_emergencia' => $telefone_emergencia,
            'cep' => $cep,
            'logradouro' => $logradouro,
            'numero' => $numero,
            'complemento' => $complemento,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'uf' => $uf,
            'restricoes_alimentar' => $restricoes_alimentar,
            'alergia' => $alergia,
            'remedio_controlado' => $remedio_controlado,
            'igreja' => $igreja,
            'ministerio' => $ministerio,
            'forma_pagamento' => $formaPagamento,
            'status_pagamento' => 'pendente',
            'aceitou_termo' => $aceitouTermos,
            'data_aceite_termo' => $request->has('termos') ? now() : null,
        ];

        $token = Str::random(6);

        cache()->put("pre_inscricao_{$token}", $data, now()->addMinutes(30));

        Mail::to($data['email'])->send(new InscricaoConfirmada($data['nome'], $token));

        return redirect()->route('emailConfirma')->with('success', 'Sua inscrição foi recebida! Por favor, verifique seu e-mail e insira o código de confirmação.');
    }
   
    
    public function conclusaoInscricao($nome){
        $nomeDescriptado = Crypt::decryptString($nome);
        return view('conclusaoInscricao',['nome' => $nomeDescriptado]);
    }

    public function confirmarLoginInscricao(){
        return view('inscritoConcluir');
    }

    
    public function concluirLogInscricao(Request $request){
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
                

            ],
            [
                'nome.required' => 'O campo nome é Obrigatório.',
                'nome.max' => 'O campo nome deve ter no máximo 49 caracteres.',
                'nome_responsavel.required' => 'O campo nome do responsavel é Obrigatório.',
                'nome_responsavel.max' => 'O campo nome do responsavel deve ter no máximo 49 caracteres.',
                'email.required' => 'O campo email é Obrigatório.',
                'email.email' => 'O email inserido deve ser um email valido.',
                'telefone.required' => 'O campo telefone é Obrigatório',
                'telefone.max' => 'O campo telefone deve ter no maximo 19 caracteres.',
                'telefone_emergencia.required' => 'O campo telefone é Obrigatório',
                'telefone_emergencia.max' => 'O campo telefone deve ter no maximo 19 caracteres.',
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
        $formaPagamentoPermitido = ['pix','cartao','boleto'];
        $ministerioPermitido = ['sim','nao','louvor','teatro','dança','outro'];

        $nome = trim(strip_tags($request->input('nome')));
        $nome_responsavel = $request->input('nome_responsavel');
        $email = strtolower(trim($request->input('email')));
        $telefone = $request->input('telefone');
        $telefone_emergencia = $request->input('telefone_emergencia');
        $cep = $request->input('cep');
        $logradouro = $request->input('logradouro');
        $numero = $request->input('numero');
        $complemento = $request->input('complemento');
        $bairro = $request->input('bairro');
        $cidade = $request->input('cidade');
        $uf = $request->input('uf');
        $restricoes_alimentar = strip_tags($request->input('restricoes_alimentar'));
        $alergia = $request->input('alergia');
        $remedio_controlado = $request->input('remedio_controlado');
        $igreja = $request->input('igreja');
        $ministerio = $request->input('ministerio');
        $forma_pagamento = $request->input('forma_pagamento');

        $inscrito = Inscrito::where('email',$email)
                            ->where('deleted_at',NULL)
                            ->first();

        if(!$inscrito){
            session()->flush();
            return redirect()->route('login')->with('loginError', 'Usuário não encontrado ou excluído. Faça login novamente.');
        }

        if(!in_array($forma_pagamento,$formaPagamentoPermitido)){
            return redirect()->back()->withInput()->with('pagamentoError', 'A forma de pagamento não é permitida.');
        }
        if(!in_array($ministerio,$ministerioPermitido)){
            return redirect()->back()->withInput()->with('ministerioError', 'O ministério escolhido não é permitido.');
        }
        $response = file_get_contents("https://viacep.com.br/ws/{$cep}/json/");
        $data = json_decode($response);

        if (isset($data->erro)) {
            return back()->withErrors(['cep' => 'CEP inválido']);
        }

        $inscrito->nome = $nome;
        $inscrito->nome_responsavel = $nome_responsavel;
        $inscrito->telefone = $telefone;
        $inscrito->telefone_emergencia = $telefone_emergencia;
        $inscrito->cep = $cep;
        $inscrito->logradouro = $logradouro;
        $inscrito->numero = $numero;
        $inscrito->complemento = $complemento;
        $inscrito->bairro = $bairro;
        $inscrito->cidade = $cidade;
        $inscrito->uf = $uf;
        $inscrito->restricoes_alimentar = $restricoes_alimentar;
        $inscrito->alergia = $alergia;
        $inscrito->remedio_controlado = $remedio_controlado;
        $inscrito->igreja = $igreja;
        $inscrito->ministerio = $ministerio;
        $inscrito->forma_pagamento = $forma_pagamento;
        $inscrito->status_pagamento = 'pendente';

        $inscrito->save();
        session()->flush();

        return redirect()->route('conclusaoInscricao', Crypt::encryptString($inscrito->nome));
    }
    public function emailConfirma(){
        return view('confirmaEmail');
    }
    public function confirmaEmail(Request $request)
    {
        $request->validate([
            'token' => 'required|string|size:6', 
        ]);
    
        $token = $request->input('token');
        $dadosPreInscricao = cache()->pull("pre_inscricao_{$token}");
    
        if ($dadosPreInscricao) {
            try {
                $inscrito = new Inscrito($dadosPreInscricao);
                $inscrito->save();
                return redirect()->route('conclusaoInscricao', Crypt::encryptString($inscrito->nome))->with('success', 'Seu e-mail foi confirmado com sucesso!');
    
            } catch (\Exception $e) {
                return redirect()->route('emailConfirma')->with('error', 'Código de confirmação inválido ou expirado.');
            }
        } else {
            return redirect()->route('emailConfirma')->with('error', 'Código de confirmação inválido ou expirado.'); // Redireciona para a página de confirmação de e-mail
        }
    }

    public function termos(){
        return view('termos');
    }
}
