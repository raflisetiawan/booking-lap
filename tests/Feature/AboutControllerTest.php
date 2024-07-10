<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AboutControllerTest extends TestCase
{
    use RefreshDatabase; // Optional if you need to interact with the database

    /**
     * Test accessing the index page.
     *
     * @return void
     */
    public function test_about_index()
    {
        // Define the route name or URI for the about index page
        Route::get('/about', [\App\Http\Controllers\AboutController::class, 'index'])->name('about.index');

        // Perform a GET request to the defined route
        $response = $this->get(route('about.index'));

        // Assert that the response is successful (status 200) and returns the about.index view
        $response->assertStatus(200);
        $response->assertViewIs('about.index');
    }


}
