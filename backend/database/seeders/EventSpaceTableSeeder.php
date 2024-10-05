<?php

namespace Database\Seeders;

use App\Models\EventSpace;
use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSpaceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        EventSpace::create([
            'name' => 'Sala de Reuniones 1',
            'description' => 'Una sala de reuniones moderna.',
            'capacity' => 10,
            'location' => 'Primer piso',
            'type' => 'Auditorio',
        ]);

        EventSpace::create([
            'name' => 'Auditorio Principal',
            'description' => 'Auditorio para grandes eventos.',
            'capacity' => 100,
            'location' => 'Segundo piso',
            'type' => 'Salón',
        ]);

        EventSpace::create([
            'name' => 'Sala de Conferencias',
            'description' => 'Sala equipada para conferencias.',
            'capacity' => 50,
            'location' => 'Tercer piso',
            'type' => 'Sala de Reuniones',
        ]);

    }
}
