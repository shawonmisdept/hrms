<?php

// app/Models/Division.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

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

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id', 'employee_code');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
