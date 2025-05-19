<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EsqueciSenha extends Mailable
{
    use Queueable, SerializesModels;

    public $nome;
    public $token;

    public function __construct($nome, $token)
    {
        $this->nome = $nome;
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('Confirme sua Inscrição')
                    ->view('email.esqueciSenha') 
                    ->with(['nome' => $this->nome, 'token' => $this->token]);
    }
}