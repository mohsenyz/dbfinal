<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'amount',
        'reported_at',
        'description',
    ];


    protected $casts = [
        'reported_at' => 'datetime',
    ];

    public function reportedBy() {
        return $this->belongsTo(Employee::class, 'reported_by');
    }

    public function reportedTo() {
        return $this->belongsTo(Employee::class, 'reported_to');
    }
}
