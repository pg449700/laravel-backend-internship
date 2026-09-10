<?php

namespace Tests\Feature;

use App\Models\GymClass;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GymTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_page_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Apex Strength Club');
    }

    public function test_members_crud(): void
    {
        $response = $this->post(route('members.store'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@test.com',
            'join_date' => '2026-01-01',
        ]);

        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseHas('members', ['email' => 'john.doe@test.com']);

        $member = Member::where('email', 'john.doe@test.com')->first();

        $editResponse = $this->put(route('members.update', $member), [
            'first_name' => 'Johnny',
            'last_name' => 'Doe',
            'email' => 'john.doe@test.com',
            'join_date' => '2026-01-01',
        ]);

        $editResponse->assertRedirect(route('members.index'));
        $this->assertDatabaseHas('members', ['first_name' => 'Johnny']);
    }

    public function test_booking_duplicate_prevention(): void
    {
        $member = Member::create([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane@test.com',
            'join_date' => '2026-01-01',
        ]);

        $class = GymClass::create([
            'class_name' => 'CrossFit',
            'instructor_name' => 'Coach Dan',
            'schedule_time' => now()->addDays(2),
            'capacity' => 10,
        ]);

        $this->from(route('bookings.create'))->post(route('bookings.store'), [
            'member_id' => $member->id,
            'class_id' => $class->id,
        ]);

        $this->assertDatabaseHas('bookings', [
            'member_id' => $member->id,
            'class_id' => $class->id,
        ]);

        $duplicateResponse = $this->from(route('bookings.create'))->post(route('bookings.store'), [
            'member_id' => $member->id,
            'class_id' => $class->id,
        ]);

        $duplicateResponse->assertSessionHasErrors('member_id');
        $duplicateResponse->assertRedirect(route('bookings.create'));
    }

    public function test_api_stats(): void
    {
        $response = $this->getJson('/api/dashboard/stats');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                'metrics' => [
                    'total_members',
                    'active_memberships',
                    'scheduled_classes',
                    'active_bookings',
                ],
                'recent_bookings',
                'upcoming_classes',
            ],
        ]);
    }

    public function test_api_members_crud(): void
    {
        $create = $this->postJson('/api/members', [
            'first_name' => 'Alice',
            'last_name' => 'Wonderland',
            'email' => 'alice@test.com',
            'join_date' => '2026-02-01',
        ]);

        $create->assertStatus(201);
        $this->assertDatabaseHas('members', ['email' => 'alice@test.com']);

        $list = $this->getJson('/api/members');
        $list->assertStatus(200);
    }

    public function test_middlewares_attached_to_web_and_api_routes(): void
    {
        $webResponse = $this->get('/');
        $webResponse->assertStatus(200);
        $webResponse->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $webResponse->assertHeader('X-Content-Type-Options', 'nosniff');
        $webResponse->assertHeader('X-XSS-Protection', '1; mode=block');
        $webResponse->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $webResponse->assertHeader('X-Response-Time');

        $apiResponse = $this->get('/api/dashboard/stats');
        $apiResponse->assertStatus(200);
        $apiResponse->assertHeader('Content-Type', 'application/json');
        $apiResponse->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $apiResponse->assertHeader('X-Response-Time');
    }
}
