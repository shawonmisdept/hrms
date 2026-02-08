<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'native_name', 'code', 'phone_code', 'currency_code', 'status'];

    public function districts()
    {
        return $this->hasMany(District::class);
    }
    public function employees()
{
    return $this->hasMany(Employee::class, 'present_district_id');
}
}