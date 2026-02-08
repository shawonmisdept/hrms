<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'email', 'phone', 'status'];

    // যদি employees টেবিলে unit_id থাকে এবং Unit মডেলের সাথে সম্পর্ক থাকে
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}