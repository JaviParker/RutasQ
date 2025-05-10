<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_puede_iniciar_sesion_con_credenciales_validas()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }

    public function test_login_falla_con_credenciales_invalidas()
    {
        $response = $this->post('/api/login', [
            'email' => 'noexiste@correo.com',
            'password' => 'incorrecta',
        ]);

        $response->assertStatus(401);
    }
}
