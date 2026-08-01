<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'meeting_date', 'location', 'summary',
    ];

    protected $casts = [
        'meeting_date' => 'datetime',
    ];
}
