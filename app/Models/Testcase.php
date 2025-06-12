<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testcase extends Model
{
    protected $fillable = [
        'problem_id','name','in_path','out_path',
        'is_sample','size_in','size_out','md5_in','md5_out'
    ];
    public function problem() { return $this->belongsTo(Problem::class); }
}
