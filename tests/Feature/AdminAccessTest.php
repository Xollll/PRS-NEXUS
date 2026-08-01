<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_admin_pages(): void
    {
        foreach ([
            route('admin.dashboard'),
            route('admin.members.index'),
            route('admin.committee-positions.index'),
            route('admin.meetings.index'),
            route('admin.activities.index'),
        ] as $url) {
            $this->get($url)->assertRedirect(route('admin.login'));
        }
    }

    public function test_an_admin_can_access_the_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->withSession(['admin_user_id' => $admin->id])
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Admin dashboard');
    }

    public function test_a_member_session_cannot_access_admin_pages(): void
    {
        $member = Member::factory()->create();
        $user = User::factory()->create(['role' => 'member', 'member_id' => $member->id]);

        $this->withSession(['member_user_id' => $user->id])
            ->get(route('admin.meetings.index'))
            ->assertRedirect(route('admin.login'));
    }
}
