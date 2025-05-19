<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InscricaoConfirmada extends Mailable
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
                    ->view('email.emailConfirma') 
                    ->with(['nome' => $this->nome, 'token' => $this->token]);
    }
}