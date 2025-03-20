<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContestSubmission extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'contest_id',
        'problem_id',
        'code',
        'output',
        'status',
        'submission_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    public function problem()
    {
        return $this->belongsTo(Problem::class);
    }
}
