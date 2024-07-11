<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\Usuario;


class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'correo' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        $user = Usuario::where('correo', $this->input('correo'))->first();

        if (!$user || hash('sha256', $this->input('password')) !== $user->contrasena) {
            $this->incrementLoginAttempts();

            throw ValidationException::withMessages([
                'correo' => __('auth.failed'),
            ]);
        }

        Auth::login($user);

        $this->clearLoginAttempts();
    }

    protected function ensureIsNotRateLimited()
    {
        if (! $this->hasTooManyLoginAttempts()) {
            return;
        }

        throw ValidationException::withMessages([
            'correo' => __('auth.throttle', [
                'seconds' => $this->secondsRemaining(),
                'minutes' => ceil($this->secondsRemaining() / 60),
            ]),
        ]);
    }

    protected function hasTooManyLoginAttempts()
    {
        return RateLimiter::tooManyAttempts($this->throttleKey(), 5);
    }

    protected function incrementLoginAttempts()
    {
        RateLimiter::hit($this->throttleKey());
    }

    protected function clearLoginAttempts()
    {
        RateLimiter::clear($this->throttleKey());
    }

    protected function secondsRemaining()
    {
        return RateLimiter::availableIn($this->throttleKey());
    }

    public function throttleKey()
    {
        return strtolower($this->input('correo')).'|'.$this->ip();
    }
}
