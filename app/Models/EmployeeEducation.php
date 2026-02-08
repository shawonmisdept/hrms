<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeEducation extends Model
{
    protected $fillable = [
        'employee_id', 'institute_name', 'exam_name', 'authority_name',
        'exam_level', 'course_duration', 'exam_year', 'major',
        'certificate_number', 'cgpa', 'mark_avail', 'total_mark',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
