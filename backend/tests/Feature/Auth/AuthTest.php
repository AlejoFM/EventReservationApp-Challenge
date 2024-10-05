<?php
namespace Tests\Feature\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_login()
    {
        // Crear un usuario
        $user = \App\Models\User::factory()->create([
            'email' => 'alejito@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin'
        ]);

        // Intentar iniciar sesión
        $response = $this->postJson('/api/login', [
            'email' => 'alejito@example.com',
            'password' => 'password123',
            'role' => 'admin'
        ]);

        $response->assertStatus(200);

    }
     /** @test */
     public function a_user_can_register()
     {
         $response = $this->postJson('/api/register', [
             'name' => 'John Doe',
             'email' => 'john@example.com',
             'password' => 'password123',
         ]);
 
         $response->assertStatus(201);
                  
     }
}
