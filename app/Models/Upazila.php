<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Upazila extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'district_id', 'status'];

    /**
     * Get the district that owns the upazila.
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function employees()
{
    return $this->hasMany(Employee::class, 'present_upazila_id');
}
}
