<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'input_format',
        'output_format',
        'sample_input',
        'sample_output',
        'difficulty',
        'tags',
        'editorial',
        'hint',
    ];
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function testCases()
    {
        return $this->hasMany(TestCase::class);
    }
    public function getTagsArrayAttribute()
    {
        return $this->tags ? explode(',', $this->tags) : [];
    }
}
