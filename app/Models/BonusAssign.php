<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BonusAssign extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'policy_master_id', 'employee_code']; 

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function policyMaster()
    {
        return $this->belongsTo(PolicyMaster::class);
    }
}
