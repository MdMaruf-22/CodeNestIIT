<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'teacher_id', 'start_time', 'end_time'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function problems()
    {
        return $this->belongsToMany(Problem::class, 'contest_problems');
    }
    public function submissions()
    {
        return $this->hasMany(ContestSubmission::class);
    }
}
