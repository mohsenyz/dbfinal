<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimesheetDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'started_at',
        'ended_at',
        'description'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime'
    ];

    public function timesheet() {
        return $this->belongsTo(Timesheet::class);
    }
}
