<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    public $resetLink;

    public function __construct($token, $email)
    {
        // Construimos la URL de restablecimiento
        $this->resetLink = url(route('password.reset', [
            'token' => $token,
            'email' => $email,
        ]));
    }

    public function build()
    {
        return $this->view('emails.resetpassword')
            ->with(['resetLink' => $this->resetLink])
            ->subject('Restablecimiento de Contraseña');
    }
}