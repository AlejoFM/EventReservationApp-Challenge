<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\EventSpace;
use Tymon\JWTAuth\Facades\JWTAuth;

class EventSpaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_spaces()
    {
        $user = \App\Models\User::factory()->create();
        $token = JWTAuth::fromUser($user);

        EventSpace::factory()->count(3)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('/api/event_spaces');

        $response->assertStatus(200);
    }

    public function test_can_create_space()
    {
        $user = \App\Models\User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $data = [
            'name' => 'Sala de Conferencias',
            'capacity' => 50,
            'type' => 'Conferencia',
            'location' => 'Luján'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('/api/event_spaces', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('event_spaces', $data);
    }

    public function test_can_show_space()
    {
        $user = \App\Models\User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $space = EventSpace::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('/api/event_spaces/' . $space->id);

        $response->assertStatus(200);

    }

    public function test_can_update_space()
    {
        $user = \App\Models\User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $space = EventSpace::factory()->create();

        $updatedData = [
            'name' => 'Auditorio Actualizado',
            'capacity' => 200,
            'type' => 'Auditorio'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->putJson('/api/event_spaces/' . $space->id, $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('event_spaces', $updatedData);
    }

    public function test_can_delete_space()
    {
        $user = \App\Models\User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $space = EventSpace::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->deleteJson('/api/event_spaces/' . $space->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('event_spaces', ['id' => $space->id]);
    }
}
