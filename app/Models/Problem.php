<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    protected $fillable = [
        'user_id','slug','title','statement',
        'time_limit','memory_limit','judge_type',
        'judge_lang','status'
    ];
    public function testcases() { return $this->hasMany(Testcase::class); }
    public function owner()     { return $this->belongsTo(User::class);  }
}
