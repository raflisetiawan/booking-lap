<?php

namespace App\Helpers;

use App\Models\Booking;
use App\Models\Field;

class BookingHelper
{
    public static function getTotalBookingsForField($fieldId)
    {
        return Booking::whereHas('schedule.daysField.field', function ($query) use ($fieldId) {
            $query->where('id', $fieldId);
        })->count();
    }
}
