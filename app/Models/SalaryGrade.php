<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class SalaryGrade extends Model
{
    protected $table = 'salary_grades';

    protected $fillable = [
        'grade_name',
        'description',
        'status',
    ];

    public $timestamps = true;

    public function details()
    {
        return $this->hasMany(SalaryGradeDetail::class, 'grade_id');
    }
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
