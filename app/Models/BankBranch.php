<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankBranch extends Model
{
    protected $fillable = ['name', 'bank_id', 'status'];

    // Bank Branch belongs to a Bank
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}