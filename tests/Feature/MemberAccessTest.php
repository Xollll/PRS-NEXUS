<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_member_dashboard_or_profile(): void
    {
        $this->get(route('member.dashboard'))->assertRedirect(route('member.login'));
        $this->get(route('member.profile.edit'))->assertRedirect(route('member.login'));
    }

    public function test_an_active_member_can_access_their_portal_and_profile(): void
    {
        $member = Member::factory()->create(['status' => 'active']);
        $user = User::factory()->create(['role' => 'member', 'member_id' => $member->id]);

        $this->withSession(['member_user_id' => $user->id])
            ->get(route('member.dashboard'))
            ->assertOk()
            ->assertSee($member->full_name);

        $this->withSession(['member_user_id' => $user->id])
            ->get(route('member.profile.edit'))
            ->assertOk()
            ->assertSee('Personal and academic information');
    }

    public function test_an_admin_session_cannot_access_member_only_pages(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->withSession(['admin_user_id' => $admin->id])
            ->get(route('member.dashboard'))
            ->assertRedirect(route('member.login'));
    }
}
