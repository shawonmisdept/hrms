<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ShiftPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'description',
        'status',
    ];

    // Accessor for total_hours
    public function getTotalHoursAttribute()
    {
        $start = Carbon::createFromFormat('H:i:s', $this->start_time);
        $end = Carbon::createFromFormat('H:i:s', $this->end_time);

        // Handle overnight shifts
        if ($end->lessThan($start)) {
            $end->addDay();
        }

        return $start->diffInHours($end);
    }
}
