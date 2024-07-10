<?php
// database/factories/VenueFactory.php

namespace Database\Factories;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

class VenueFactory extends Factory
{
    protected $model = Venue::class;

    public function definition()
    {
        return [
            'name_venue' => $this->faker->company,
            'address_venue' => $this->faker->address,
            'contact_venue' => $this->faker->phoneNumber,
            'description_venue' => $this->faker->paragraph,
            'facility_venue' => $this->faker->sentence,
            'lowest_price_venue' => $this->faker->numberBetween(50, 500),
            'image_venue' => 'default_image.jpg', // Default image or use $this->faker->imageUrl() for random images
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
        ];
    }
}
