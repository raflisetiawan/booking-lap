<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueCategory extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'venue_id',
        'category_id',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
