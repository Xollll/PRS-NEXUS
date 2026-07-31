<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'activity_date', 'location', 'description', 'status',
    ];

    protected $casts = [
        'activity_date' => 'datetime',
    ];
}