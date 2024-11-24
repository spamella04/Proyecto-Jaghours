<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    // Método para enviar el correo de restablecimiento personalizado
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Buscar al usuario por correo electrónico
        $user = User::where('email', $request->email)->first();

        // Validar si el usuario existe
        if (!$user) {
            return back()->withErrors(['email' => 'No encontramos un usuario con esa dirección de correo.']);
        }

        // Generar el token de restablecimiento
        $token = Password::getRepository()->create($user);

        // Enviar el correo utilizando el mailable personalizado
        Mail::to($request->email)->send(new ResetPasswordMail($token, $request->email));

        return back()->with('status', 'Te hemos enviado un correo con el enlace para restablecer tu contraseña.');
    }
}