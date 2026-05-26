<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class HCaptchaRule implements ValidationRule
{
    /**
     * Ejecutar validación hCaptcha
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value) {
            $fail('Debe completar el CAPTCHA.');
            return;
        }

        $response = Http::asForm()->post('https://hcaptcha.com/siteverify', [
            'secret' => env('HCAPTCHA_SECRET_KEY'),
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        $body = $response->json();

        if (!isset($body['success']) || $body['success'] !== true) {
            $fail('Verificación CAPTCHA fallida.');
        }
    }
}