<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperVision extends Model
{
    /** @use HasFactory<\Database\Factories\SuperVisionFactory> */
    use HasFactory;

    protected $table = 'super_visions';

    protected $fillable = [
        'dosen_id',
        'mahasiswa_id',
        'status',
    ];


    public function dosen(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Dosen::class);
    }
}
