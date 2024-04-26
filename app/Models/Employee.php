<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'track_tik_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'job_title',
    ];
}
