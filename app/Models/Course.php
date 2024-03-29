<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function lessons(): object
    {
        return $this->hasMany(Lesson::class, 'course_id', 'id');
    }

    public function tests():object
    {
        return $this->hasMany(Test::class, 'course_id', 'id');
    }
    public function category(): object
    {
        return $this->belongsTo(Category::class);
    }
    public function author(): object
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function students(): object
    {
        return $this->belongsToMany(User::class);
    }
}
