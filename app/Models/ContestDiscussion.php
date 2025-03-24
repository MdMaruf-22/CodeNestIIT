<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContestDiscussion extends Model
{
    use HasFactory;
    protected $fillable = ['contest_id', 'user_id', 'content', 'parent_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(ContestDiscussion::class, 'parent_id')->orderBy('created_at');
    }
}
