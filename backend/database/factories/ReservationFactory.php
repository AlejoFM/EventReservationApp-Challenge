<?php

namespace Database\Factories;

use App\Models\EventSpace;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), 
            'event_space_id' => EventSpace::factory(), 
            'event_name' => $this->faker->sentence(),
            'start_time' => $this->faker->dateTimeBetween('+1 days', '+2 days'),
            'end_time' => $this->faker->dateTimeBetween('+2 days', '+3 days'),
            'status' => $this->faker->word()
        ];
    }
}
