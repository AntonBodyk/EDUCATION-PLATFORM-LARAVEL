<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public function courseComments(): object
    {
        return $this->hasMany(CourseComment::class, 'user_id', 'id');
    }

    public function lessonComments(): object
    {
        return $this->hasMany(LessonComment::class, 'user_id', 'id');
    }

    public function courses(): object
    {
        return $this->hasMany(Course::class, 'teacher_id', 'id');
    }


    /**
     * Получаю роль пользователя.
     */
    public function role(): object
    {
        return $this->belongsTo(Role::class, 'id');
    }

    /**
     * Проверить, является ли пользователь учителем.
     */
    public function isTeacher(): Boolean
    {
        // Предположим, что есть роль "Учитель" с id 2 (вам нужно подставить соответствующий id вашей роли "Учитель").
        return $this->role->id === 2;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'avatar',
        'name',
        'email',
        'role_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
