<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeExperience extends Model
{
    protected $fillable = [
        'employee_id', 'company_name', 'designation', 'country', 'city',
        'address', 'start_date', 'end_date', 'start_salary', 'end_salary',
        'currency', 'responsibilities'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
