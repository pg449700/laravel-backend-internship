<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'join_date',
    ];

    protected $casts = [
        'join_date' => 'date',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class, 'member_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'member_id');
    }
}
