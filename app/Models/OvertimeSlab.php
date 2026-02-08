<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OvertimeSlab extends Model
{
    protected $fillable = ['name', 'rate', 'description', 'status'];

    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }
}