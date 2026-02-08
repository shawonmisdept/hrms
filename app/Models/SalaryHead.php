<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryHead extends Model
{
    protected $fillable = [
        'name',
        'description',
        'head_type',
        'sequence',
        'sort_code',
        'perquisite',
        'disburse',
        'status',
    ];
    public function details()
    {
        return $this->hasMany(PolicyDetail::class);
    }
    public function gradeDetails()
    {
        return $this->hasMany(SalaryGradeDetail::class, 'head_id');
    }
}
