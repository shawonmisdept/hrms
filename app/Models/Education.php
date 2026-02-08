<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = ['unit_id', 'name', 'native_name', 'status'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // ✅ Add this line to fix the table name
    protected $table = 'educations';
}
