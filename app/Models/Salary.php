<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_allowance',
        'incentive',
        'base'
    ];

    public function contract() {
        return $this->belongsTo(Contract::class);
    }
}
