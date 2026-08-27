<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GymClass extends Model
{
    use HasFactory;

    protected $table = 'gym_classes';

    protected $fillable = [
        'class_name',
        'instructor_name',
        'schedule_time',
        'capacity',
    ];

    protected $casts = [
        'schedule_time' => 'datetime',
        'capacity' => 'integer',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'class_id');
    }

    public function getBookedCountAttribute(): int
    {
        return $this->bookings()->count();
    }

    public function getRemainingSpotsAttribute(): int
    {
        return max(0, $this->capacity - $this->booked_count);
    }

    public function isFull(): bool
    {
        return $this->remaining_spots <= 0;
    }
}
