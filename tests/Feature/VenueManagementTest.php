<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VenueManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_a_venue()
    {
        $user = User::factory()->create();
        Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $categories = Category::factory()->count(3)->create();

        $response = $this->actingAs($user)->post('/venues', [
            'name_venue' => 'Test Venue',
            'address_venue' => '123 Test St',
            'contact_venue' => '123-456-7890',
            'description_venue' => 'A test venue description',
            'facility_venue' => 'Facility 1, Facility 2',
            'lowest_price_venue' => '100',
            'image_venue' => $file,
            'user_id' => $user->id,
            'categories' => $categories->pluck('id')->toArray(),
        ]);

        Storage::disk('public/venues')->assertExists($file->hashName());

        $this->assertDatabaseHas('venues', [
            'name_venue' => 'Test Venue',
            'user_id' => $user->id,
        ]);

        foreach ($categories as $category) {
            $this->assertDatabaseHas('venue_categories', [
                'venue_id' => Venue::where('name_venue', 'Test Venue')->first()->id,
                'category_id' => $category->id,
            ]);
        }

        $response->assertRedirect('/owner-venue'); // Sesuaikan dengan rute yang sebenarnya
    }

    /** @test */
    public function user_can_view_a_venue()
    {
        $venue = Venue::factory()->create();

        $response = $this->get("/venues/{$venue->id}/show");

        $response->assertStatus(200);
        $response->assertSee($venue->name_venue);
    }

    /** @test */
        public function user_can_update_a_venue()
        {
            $user = User::factory()->create();
            $venue = Venue::factory()->create(['user_id' => $user->id]);
            Storage::fake('avatars');
            $file = UploadedFile::fake()->image('avatar.jpg');


            $response = $this->actingAs($user)->put("/venues/{$venue->id}", [
                'name_venue' => 'Updated Venue',
                'address_venue' => '456 Updated St',
                'contact_venue' => '987-654-3210',
                'description_venue' => 'An updated venue description',
                'facility_venue' => 'Updated Facility 1, Updated Facility 2',
                'lowest_price_venue' => '200',
                'image_venue' => $file,
                'user_id' => $user->id,
            ]);
            Storage::disk('avatars')->assertMissing('avatar.jpg');
            $response->assertRedirect('/venues');
            $this->assertDatabaseHas('venues', [
                'id' => $venue->id,
                'name_venue' => 'Updated Venue',
            ]);
        }

    /** @test */
    public function user_can_delete_a_venue()
    {
        $user = User::factory()->create();
        $venue = Venue::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/venues/{$venue->id}");

        $response->assertRedirect('/venues');
        $this->assertDatabaseMissing('venues', [
            'id' => $venue->id,
        ]);
    }

    /** @test */

}
