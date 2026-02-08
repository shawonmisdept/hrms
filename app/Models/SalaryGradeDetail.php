<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryGradeDetail extends Model
{
    protected $fillable = [
        'grade_id',
        'head_id',
        'fixed',
        'type',
        'formula',
        'parent_head_id',
        'parent_head_value',
        'is_higher',
    ];

    public $timestamps = true;

    public function head()
    {
        return $this->belongsTo(SalaryHead::class, 'head_id');
    }

    public function parentHead()
    {
        return $this->belongsTo(SalaryHead::class, 'parent_head_id');
    }

    public function grade()
    {
        return $this->belongsTo(SalaryGrade::class, 'grade_id');
    }
}
