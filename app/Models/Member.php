<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name', 'matric_no', 'email', 'phone', 'programme', 'role_title', 'committee_position_id', 'avatar_path', 'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function committeePosition(): BelongsTo
    {
        return $this->belongsTo(CommitteePosition::class);
    }

    public function getDisplayRoleAttribute(): string
    {
        return $this->committeePosition?->title ?? $this->role_title ?? 'Member';
    }
}
