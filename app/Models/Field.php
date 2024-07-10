<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;
    protected $fillable = [
        'image_field',
        'name_field',
        'venue_id',
        'type_field',
        'price_field',
        'category',

    ];


    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
    public function dayfields()
    {
        return $this->hasMany(DaysField::class);
    }

  // app/Models/Field.php

public function getTotalBookings()
{
    return Booking::whereHas('schedule.daysField', function ($query) {
        $query->where('field_id', $this->id);
    })->count();
}

}
