<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'manager_id',
        'manager_email',
        'manager_phone',
        'status',
        'created_by',
    ];

    // Manager (Employee)
    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id', 'id'); // ✅ id ফিল্ডেই সাধারণত relation হয়
    }

    // Created By (User)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

