<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\PasswordResetMail;

class PasswordResetController extends Controller
{
    public function sendResetLinkEmail(Request $request)
{
    $request->validate(['correo' => 'required|email|exists:usuarios,correo']);

    $token = Str::random(60);
    $correo = $request->correo;

    DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $correo],
        [
            'token' => $token,
            'created_at' => Carbon::now()
        ]
    );

    Mail::to($correo)->send(new PasswordResetMail($token));

    return response()->json(['status' => 'success', 'message' => 'Se ha enviado el enlace de restablecimiento de contraseña a su correo electrónico.']);
}

    public function showResetForm($token)
    {
        $tokenData = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (!$tokenData) {
            return view('auth.reset-password-form', ['token' => null, 'error' => 'Token inválido o expirado']);
        }

        return view('auth.reset-password-form', ['token' => $token]);
    }

    public function reset(Request $request)
{
    $request->validate([
        'token' => 'required',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $tokenData = DB::table('password_reset_tokens')->where('token', $request->token)->first();

    if (!$tokenData) {
        return response()->json(['status' => 'error', 'message' => 'Token inválido o expirado'], 400);
    }

    $user = DB::table('usuarios')->where('correo', $tokenData->email)->first();

    DB::table('usuarios')->where('correo', $tokenData->email)->update([
        'contrasena' =>  hash('sha256', $request->password),
    ]);

    DB::table('password_reset_tokens')->where('email', $tokenData->email)->delete();

    return response()->json(['status' => 'success', 'message' => 'Su contraseña ha sido restablecida con éxito.']);
}
}
