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
    ];
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
