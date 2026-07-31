<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    protected $fillable = [
        'committee_id', 'title', 'meeting_date', 'location', 'summary',
    ];

    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }

    protected $casts = [
        'meeting_date' => 'datetime',
    ];
}