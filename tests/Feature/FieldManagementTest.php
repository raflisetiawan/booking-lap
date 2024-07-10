<?php

namespace Tests\Feature;

use App\Models\Field;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FieldManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_a_field()
    {
        Storage::fake('public');

        // Buat user sebagai pemilik venue
        $user = User::factory()->create();
        $venue = Venue::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        // Persiapan file gambar palsu
        $file = UploadedFile::fake()->image('field.jpg');

        // Data field yang akan disimpan
        $data = [
            'image_field' => $file,
            'name_field' => 'Test Field',
            'category' => 'Outdoor',
            'type_field' => 'Football',
            'venue_id' => $venue->id,
        ];

        // Kirim permintaan untuk menyimpan field
        $response = $this->post(route('post-field'), $data);

        // Assert pengalihan ke halaman yang benar
        $response->assertRedirect(route('index-field'));

        // Assert field tersimpan dengan benar dalam basis data
        $this->assertDatabaseHas('fields', [
            'name_field' => 'Test Field',
            'category' => 'Outdoor',
            'type_field' => 'Football',
            'venue_id' => $venue->id,
        ]);

        // Assert file gambar tersimpan dengan benar
        Storage::disk('public')->assertMissing('fields/' . $file->hashName());
    }
        /** @test */
        public function user_can_update_a_field()
        {
            Storage::fake('public');

            // Buat user sebagai pemilik venue
            $user = User::factory()->create();
            $venue = Venue::factory()->create(['user_id' => $user->id]);
            $field = Field::factory()->create(['venue_id' => $venue->id]);

            $this->actingAs($user);

            // Persiapan file gambar palsu
            $file = UploadedFile::fake()->image('updated_field.jpg');

            // Data field yang akan diupdate
            $data = [
                'image_field' => $file,
                'name_field' => 'Updated Field Name',
                'category' => 'Indoor',
                'type_field' => 'Basketball',
            ];

            // Kirim permintaan untuk mengupdate field
            $response = $this->patch(route('update-field', ['id' => $field->id]), $data);

            // Assert pengalihan ke halaman yang benar
            $response->assertRedirect(route('index-field'));

            // Assert field telah diupdate dengan benar dalam basis data
            $this->assertDatabaseHas('fields', [
                'id' => $field->id,
                'name_field' => 'Updated Field Name',
                'category' => 'Indoor',
                'type_field' => 'Basketball',
                'venue_id' => $venue->id,
            ]);

            // Assert file gambar baru tersimpan dengan benar
            Storage::disk('public')->assertMissing('fields/' . $file->hashName());

            // Assert file gambar lama telah dihapus
            Storage::disk('public')->assertMissing('fields/' . $field->image_field);
        }

            /** @test */
    public function user_can_delete_a_field()
    {
        Storage::fake('public');

        // Buat user sebagai pemilik venue
        $user = User::factory()->create();
        $venue = Venue::factory()->create(['user_id' => $user->id]);
        $field = Field::factory()->create(['venue_id' => $venue->id]);

        $this->actingAs($user);

        // Kirim permintaan untuk menghapus field
        $response = $this->delete(route('delete-field', ['id' => $field->id]));

        // Assert pengalihan ke halaman yang benar
        $response->assertRedirect(route('index-field'));

        // Assert field telah dihapus dari basis data
        $this->assertDatabaseMissing('fields', ['id' => $field->id]);

        // Assert file gambar telah dihapus dari penyimpanan
        Storage::disk('public')->assertMissing('fields/' . $field->image_field);
    }
}

