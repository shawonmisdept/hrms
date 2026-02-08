<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'country_id', 'status'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function upazilas()
    {
        return $this->hasMany(Upazila::class);
    }
    public function employees()
{
    return $this->hasMany(Employee::class, 'present_district_id');
}
}
