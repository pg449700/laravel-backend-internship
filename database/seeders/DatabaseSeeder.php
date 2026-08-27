<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\GymClass;
use App\Models\Member;
use App\Models\Membership;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $member1 = Member::create([
            'first_name' => 'ahmad',
            'last_name' => 'hany',
            'email' => 'mangopotato@gmail.com',
            'join_date' => '2026-01-15',
        ]);

        $member2 = Member::create([
            'first_name' => 'jawad',
            'last_name' => 'abbas',
            'email' => 'mangopotato1@gmail.com',
            'join_date' => '2026-02-10',
        ]);

        $member3 = Member::create([
            'first_name' => 'ali',
            'last_name' => 'mango',
            'email' => 'mangopotato2@gmail.com',
            'join_date' => '2026-03-01',
        ]);

        Membership::create([
            'member_id' => $member1->id,
            'membership_type' => 'Premium',
            'monthly_fee' => 59.99,
            'status' => 'Active',
        ]);

        Membership::create([
            'member_id' => $member2->id,
            'membership_type' => 'Basic',
            'monthly_fee' => 29.99,
            'status' => 'Inactive',
        ]);

        $class1 = GymClass::create([
            'class_name' => 'Spin Class',
            'instructor_name' => 'ahmad hany',
            'schedule_time' => '2026-08-10 09:00:00',
            'capacity' => 20,
        ]);

        $class2 = GymClass::create([
            'class_name' => 'Yoga',
            'instructor_name' => 'jawad abbas',
            'schedule_time' => '2026-08-11 18:00:00',
            'capacity' => 15,
        ]);

        Booking::create([
            'member_id' => $member1->id,
            'class_id' => $class1->id,
            'booking_date' => now(),
        ]);

        Booking::create([
            'member_id' => $member2->id,
            'class_id' => $class1->id,
            'booking_date' => now(),
        ]);
    }
}
