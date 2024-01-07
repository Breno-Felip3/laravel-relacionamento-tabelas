<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function course()
    {
        //Retorna o curso do modulo
        return $this->belongsTo(Course::class);
    }

    public function lessons()
    {
        //retorna as aulas do múdulo 
        return $this->hasMany(Lesson::class);
    }
}
