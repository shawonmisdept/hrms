<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyMaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'avail_from',
        'effective_date',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(PolicyDetail::class);
    }
    public function bonusAssigns()
    {
        return $this->hasMany(BonusAssign::class);
    }
}

