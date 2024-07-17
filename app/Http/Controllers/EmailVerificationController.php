<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class EmailVerificationController extends Controller
{
    public function resend(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'El correo electrónico ya ha sido verificado'], 200);
        }

        // Enviar el correo de verificación
        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Correo de verificación enviado']);
    }
}
