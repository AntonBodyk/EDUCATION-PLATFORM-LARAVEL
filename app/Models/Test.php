<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function questions(): object
    {
        return $this->hasMany(Question::class, 'test_id', 'id');
    }

    public function course(): object
    {
        return $this->belongsTo(Course::class);
    }
}
