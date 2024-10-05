<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reservation::create([
            'event_space_id' => 1,
            'user_id' => 1, // Asumiendo que hay un usuario con ID 1
            'event_name' => 'Reunión de equipo',
            'start_time' => '2024-10-01 09:00:00',
            'end_time' => '2024-10-01 11:00:00',
            'status' => 'confirmed'
        ]);

        Reservation::create([
            'event_space_id' => 2,
            'user_id' => 1,
            'event_name' => 'Presentación de proyecto',
            'start_time' => '2024-10-01 14:00:00',
            'end_time' => '2024-10-01 15:30:00',
            'status' => 'pending'
        ]);

        Reservation::create([
            'event_space_id' => 2,
            'user_id' => 2,
            'event_name' => 'Presentación de proyecto',
            'start_time' => '2024-10-01 14:00:00',
            'end_time' => '2024-10-01 15:30:00',
            'status' => 'pending'
        ]);
    }
}
