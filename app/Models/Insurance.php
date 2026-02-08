<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected $fillable = [
        'name', 'description', 'coverage_amount', 'premium',
        'provider_name', 'start_date', 'end_date', 'status', 'created_by'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'status' => 'boolean',
    ];
}
