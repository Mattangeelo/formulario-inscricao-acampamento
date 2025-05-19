<?php

namespace App\Http\Controllers;

use App\Mail\EsqueciSenha;
use App\Models\Inscrito;
use App\Models\Usuario;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Login extends Controller
{
    public function login(){
        return response()
        ->view('Login')
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }
    public function loginSubmit(Request $request){
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:6|max:16',
            ],
            [
                'email.required' => 'O campo email é Obrigatório.',
                'email.email' => 'O email inserido deve ser um email válido.',
                'password.required' => 'O campo Senha é Obrigatório.',
                'password.min' => 'O campo senha deve conter pelo menos 6 caracteres.',
                'password.max' => 'O campo senha deve ter no máximo 16 caracteres.',
            ]
        );
    
        $email = $request->input('email');
        $password = $request->input('password');


    
        // Primeiramente verifica se o e-mail é de um usuário
        $emailUser = Usuario::where('email', $email)
                            ->where('deleted_at', NULL)
                            ->first();
    
        if ($emailUser) {
            // Se o email existir na tabela de usuários, verifica se é admin
            if (isset($emailUser->is_admin) && $emailUser->is_admin && hash::check($password,$emailUser->senha)) {
                    session([
                        'user' => [
                            'id' => $emailUser->id,
                            'email' => $emailUser->email,
                            'is_admin' => $emailUser->is_admin,
                        ]
                    ]);
                return redirect()->to('/admin'); // Rota para o painel admin
            } else {
                // Se não for admin, retornar erro
                return redirect()->back()->withInput()->with('loginError', 'Email ou senha incorretos. Por favor, tente novamente!');
            }
        }
    
        // Se não encontrou na tabela de usuários, tenta verificar na tabela de Inscritos
        $inscrito = Inscrito::where('email', $email)->first();
    
        if ($inscrito && Hash::check($password, $inscrito->senha)) {
            session([
                'user' => [
                    'nome' => $inscrito->nome,
                    'nome_responsavel' => $inscrito->nome_responsavel,
                    'email' => $inscrito->email,
                    'telefone' => $inscrito->telefone,
                    'telefone_emergencia' => $inscrito->telefone_emergencia,
                    'cep' => $inscrito->cep,
                    'logradouro' => $inscrito->logradouro,
                    'numero' => $inscrito->numero,
                    'complemento' => $inscrito->complemento,
                    'bairro' => $inscrito->bairro,
                    'cidade' => $inscrito->cidade,
                    'uf' => $inscrito->uf,
                    'restricoes_alimentar' => $inscrito->restricoes_alimentar,
                    'alergia' => $inscrito->alergia,
                    'remedio_controlado' => $inscrito->remedio_controlado,
                    'igreja' => $inscrito->igreja,
                    'ministerio' => $inscrito->ministerio,
                    'forma_pagamento' => $inscrito->forma_pagamento,
                ]
            ]);
            return redirect()->to('/confirmarLoginInscricao'); // Rota para o inscrito
        } else {
            return redirect()->back()->withInput()->with('loginError', 'Email ou senha incorretos. Por favor, tente novamente!');
        }
    }
    public function logout (){
        session()->forget('user');
        return response()
            ->redirectTo('/login')  
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }

    public function esqueciMinhaSenha(){
        return view('emailInserir');
    }

    public function esqueciMinhaSenhaSubmit(Request $request){
        $request->validate(
            [
                'email' => 'required|email',
            ],
            [
                'email.required' => 'O campo email é Obrigatório.',
                'email.email' => 'O email inserido deve ser um email válido.',
            ]
        );
        $email = $request->input('email');
        $emailId = Inscrito::where('email',$email)
                            ->where('deleted_at',NULL)
                            ->first();
        
        if(!$emailId){
            return redirect()->route('login')->with('loginError','Esse email não possui cadastro!');
        }
        $data= [
            'nome' => $emailId->nome,
            'email' => $emailId->email,
        ];
        $token = Str::random(6);
        cache()->put("esqueci_senha_{$token}",$data,now()->addMinutes(30));
        Mail::to($emailId->email)->send(new EsqueciSenha($data['nome'],$token));
        return redirect()->route('esqueciSenha')->with('success', 'Para recuperar sua senha. Por favor, verifique seu e-mail e insira o código de confirmação.');
    }
    public function esqueciSenha(){
        return view('esqueciSenha');
    }

    public function esqueciConfirma(Request $request){
        $request->validate(
            [
                'token' => 'required|string|size:6',
                'nova_senha' => 'required|min:6|max:16',
                'confirmar_senha' =>'required|min:6|max:16|same:nova_senha',
            ],
            [
                'nova_senha.required' => 'O campo Senha é Obrigatório.',
                'nova_senha.min' => 'O campo senha deve conter pelo menos 6 caracteres.',
                'nova_senha.max' => 'O campo senha deve ter no máximo 16 caracteres.',
                'confirmar_senha.required' => 'O campo Confirmar Senha é Obrigatório.',
                'confirmar_senha.min' => 'O campo Confirmar Senha deve conter pelo menos 6 caracteres.',
                'confirmar_senha.max' => 'O campo Confirmar Senha deve ter no máximo 16 caracteres.',
                'confirmar_senha.same' => 'As senhas não coincidem.',
            ]
        );
        
        $token = $request->input('token');
        $data = cache()->pull("esqueci_senha_{$token}");
        if ($data) {
            try {
                $inscrito = Inscrito::where('email',$data['email'])
                                    ->where('deleted_at',NULL)
                                    ->first();
                $inscrito->senha = Hash::make($request->input('nova_senha'));
                $inscrito->save();
                return redirect()->route('login',);
    
            } catch (\Exception $e) {
                return redirect()->route('esqueciMinhaSenha')->with('error', 'Código de confirmação inválido ou expirado.');
            }
        } else {
            return redirect()->route('esqueciMinhaSenha')->with('error', 'Código de confirmação inválido ou expirado.'); // Redireciona para a página de confirmação de e-mail
        }
    }
}
