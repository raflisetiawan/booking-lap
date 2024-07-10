<?php

namespace Database\Factories;

use App\Models\Field;
use Illuminate\Database\Eloquent\Factories\Factory;

class FieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Field::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'image_field' => $this->faker->imageUrl(),
            'name_field' => $this->faker->word,
            'category' => $this->faker->word,
            'type_field' => $this->faker->word,
            'venue_id' => function () {
                return \App\Models\Venue::factory()->create()->id;
            },
        ];
    }
}
