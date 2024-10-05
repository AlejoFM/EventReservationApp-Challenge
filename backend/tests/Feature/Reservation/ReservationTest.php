<?php
namespace Tests\Feature\Reservation;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ReservationTest extends TestCase
{
    use RefreshDatabase;
    
        /** @test */
        public function a_user_can_create_a_reservation()
        {
            $user = \App\Models\User::factory()->create();
            $token = JWTAuth::fromUser($user);
            
            $eventSpace = \App\Models\EventSpace::factory()->create();

            $response = $this->postJson('/api/reservations', [
                'user_id' => $user->id,
                'event_space_id' => $eventSpace->id,
                'event_name' => 'Team Meeting',
                'start_time' => '2024-10-01 10:00:00',
                'end_time' => '2024-10-01 12:00:00',
                'status' => 'CONFIRMED'
            ], [
                'Authorization' => 'Bearer ' . $token, 
            ]);
        
            $response->assertStatus(201);
        }
    
    /** @test */
    public function it_prevents_overlapping_reservations()
    {
        // Crear un usuario y autenticarlo
        $user = \App\Models\User::factory()->create();
        $token = JWTAuth::fromUser($user);


        // Crear un espacio en la base de datos
        $eventSpace = \App\Models\EventSpace::factory()->create();

        // Crear una reserva existente
        \App\Models\Reservation::factory()->create([
            'event_space_id' => $eventSpace->id,
            'event_name' => 'Team Meeting',
            'start_time' => '2024-10-01 10:00:00',
            'end_time' => '2024-10-01 12:00:00',
            'status' => 'CONFIRMED'
        ]);

        // Intentar crear una reserva en el mismo horario
        $response = $this->postJson('/api/reservations', [
            'user_id' => $user->id,
            'event_space_id' => $eventSpace->id,
            'event_name' => 'Team Meeting',
            'start_time' => '2024-10-01 10:00:00',
            'end_time' => '2024-10-01 12:00:00',
            'status' => 'CONFIRMED'
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(409)
                 ->assertJson([
                     'status' => 'error',
                     'message' => 'This time slot is already booked.',
                 ]);
    }

    /** @test */
    public function a_user_can_list_their_reservations()
    {
        // Crear un usuario y autenticarlo
        $user = \App\Models\User::factory()->create();
        $token = JWTAuth::fromUser($user);


        // Crear algunas reservas para el usuario
        \App\Models\Reservation::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        // Hacer una solicitud GET para obtener las reservas
        $response = $this->getJson('/api/reservations', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
    }
}
