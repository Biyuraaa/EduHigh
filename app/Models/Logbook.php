<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    //

    protected $table = "logbooks";

    protected $fillable = [
        "appointment_id",
        "notes",
        "comment",
        "status",
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
