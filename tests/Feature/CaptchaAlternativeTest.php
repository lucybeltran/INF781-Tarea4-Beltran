<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class CaptchaAlternativeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Login exitoso con hCaptcha válido
     */
    public function test_login_con_captcha_valido()
    {
        // Simular respuesta exitosa de hCaptcha
        Http::fake([
            'hcaptcha.com/siteverify' => Http::response([
                'success' => true
            ], 200),
        ]);

        $user = User::factory()->create([
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
            'h-captcha-response' => 'fake-token',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    /**
     * Test: Login rechazado por hCaptcha inválido
     */
    public function test_login_con_captcha_invalido()
    {
        Http::fake([
            'hcaptcha.com/siteverify' => Http::response([
                'success' => false
            ], 200),
        ]);

        $user = User::factory()->create([
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
            'h-captcha-response' => 'fake-token',
        ]);

        $response->assertSessionHasErrors('h-captcha-response');
        $this->assertGuest();
    }
}