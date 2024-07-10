<?php
// database/factories/DaysFieldFactory.php

namespace Database\Factories;

use App\Models\DaysField;
use Illuminate\Database\Eloquent\Factories\Factory;

class DaysFieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DaysField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date(),
            'venue_id' => \App\Models\Venue::factory(),
            'field_id' => \App\Models\Field::factory(),
        ];
    }
}
