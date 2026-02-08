<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Employee;

class Section extends Model
{
    protected $fillable = [
        'name', 'description', 'manager_id', 'manager_email',
        'manager_phone', 'status', 'created_by'
    ];

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
