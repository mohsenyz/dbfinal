<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'amount',
        'reported_at'
    ];


    protected $casts = [
        'reported_at' => 'datetime',
    ];

    public function employee() {
        return $this->belongsTo(Employee::class, 'reported_to');
    }

    public function reportedBy() {
        return $this->belongsTo(Employee::class, 'reported_by');
    }
}
