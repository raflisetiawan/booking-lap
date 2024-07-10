<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaysField extends Model
{
    use HasFactory;
    protected $table = 'days_fields';

    protected $fillable = ['date', 'venue_id', 'field_id'];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function schedules()
{
    return $this->hasMany(Schedule::class, 'days_field_id');
}
}
