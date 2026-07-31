<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name', 'matric_no', 'email', 'phone', 'programme', 'role_title', 'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];
}