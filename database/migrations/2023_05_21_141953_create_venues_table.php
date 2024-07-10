<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Tambahkan kolom user_id
            $table->string('name_venue');
            $table->string('address_venue');
            $table->string('contact_venue');
            $table->text('description_venue');
            $table->text('facility_venue');
            $table->string('lowest_price_venue');
            $table->string('image_venue');
            $table->foreign('user_id')->references('id')->on('users'); // Tambahkan kunci asing ke users
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
