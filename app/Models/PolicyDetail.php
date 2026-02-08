<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolicyDetail extends Model
{
    protected $fillable = [
        'policy_master_id',
        'salary_head_id',
        'type',
        'amount',
        'min_service_length',
        'max_service_length',
        'status',
    ];

    public function policyMaster()
    {
        return $this->belongsTo(PolicyMaster::class);
    }

    public function salaryHead()
    {
        return $this->belongsTo(SalaryHead::class);
    }
}
