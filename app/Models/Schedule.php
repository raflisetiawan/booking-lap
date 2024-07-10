<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'days_field_id',
        'start_time',
        'end_time',
        'price',
        'is_booking'
    ];

    public function daysField()
    {
        return $this->belongsTo(DaysField::class);
    }
}
