<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduleFactory> */
    use HasFactory;

    protected $table = 'schedules';

    protected $fillable = [
        'dosen_id',
        'schedule_date',
        'start_time',
        'end_time',
        'location',
        'quota',
    ];


    public function dosen(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Dosen::class);
    }
}
