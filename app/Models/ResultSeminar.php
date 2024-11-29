<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultSeminar extends Model
{
    //
    protected $table = "result_seminars";

    protected $fillable = [
        "mahasiswa_id",
        "result",
        "material_score",
        "presentation_score",
        "final_score",
        "letter_grade",
        "date",
        "time",
        "location",
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function resultAssessments()
    {
        return $this->hasMany(ResultAssessment::class);
    }
}
