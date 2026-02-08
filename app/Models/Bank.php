<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = ['name', 'short_name', 'status'];
}