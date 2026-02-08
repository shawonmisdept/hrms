<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'shift_plan_id',
        'start_date',
        'end_date',
        'remarks',
        'assigned_by', // Foreign key to the User model (if applicable)
        // 'assignment_date', // If you have a specific column for when it was assigned
        'status', // e.g., 'assigned', 'active', 'completed', 'cancelled'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function shiftPlan()
    {
        return $this->belongsTo(ShiftPlan::class, 'shift_plan_id');
    }

    // Assuming you have a User model for the person who assigns the shift
    public function assigner()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}