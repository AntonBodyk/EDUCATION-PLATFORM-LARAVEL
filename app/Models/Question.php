<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function test(): object
    {
        return $this->belongsTo(Test::class);
    }

    public function answers(): object
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }
}
