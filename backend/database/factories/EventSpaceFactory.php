<?php

namespace Database\Factories;

use App\Models\EventSpace;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventSpaceFactory extends Factory
{
    protected $model = EventSpace::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'capacity' => $this->faker->numberBetween(10, 100),
            'location' => $this->faker->address,
            'type' => $this->faker->word,
        ];
    }
}
