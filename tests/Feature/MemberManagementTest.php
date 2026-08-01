<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_admin_can_create_update_activate_deactivate_and_delete_members(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->admin($admin)->get(route('admin.members.index'))->assertOk();
        $this->admin($admin)->post(route('admin.members.store'), [
            'full_name' => 'Nur Aina', 'matric_no' => 'M100001', 'email' => 'aina@example.test', 'phone' => '0123456789',
            'programme' => 'Counselling', 'role_title' => 'Peer Mentor', 'status' => 'active',
            'password' => 'password123', 'password_confirmation' => 'password123',
        ])->assertRedirect(route('admin.members.index'));

        $member = Member::where('matric_no', 'M100001')->firstOrFail();
        $this->assertDatabaseHas('users', ['member_id' => $member->id, 'email' => 'aina@example.test', 'role' => 'member']);

        $payload = [
            'full_name' => 'Nur Aina', 'matric_no' => 'M100001', 'email' => 'aina.updated@example.test', 'phone' => '0199999999',
            'programme' => 'Counselling', 'role_title' => 'Peer Mentor', 'status' => 'inactive',
        ];
        $this->admin($admin)->put(route('admin.members.update', $member), $payload)
            ->assertRedirect(route('admin.members.index'));
        $this->assertDatabaseHas('members', ['id' => $member->id, 'status' => 'inactive']);

        $payload['status'] = 'active';
        $this->admin($admin)->put(route('admin.members.update', $member), $payload)
            ->assertRedirect(route('admin.members.index'));
        $this->assertDatabaseHas('members', ['id' => $member->id, 'status' => 'active']);

        $this->admin($admin)->delete(route('admin.members.destroy', $member))
            ->assertRedirect(route('admin.members.index'));
        $this->assertDatabaseMissing('members', ['id' => $member->id]);
        $this->assertDatabaseMissing('users', ['member_id' => $member->id]);
    }

    public function test_member_search_query_is_retained_in_pagination_links(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Member::factory()->count(21)->create(['full_name' => 'Pagination Check Member']);

        $this->admin($admin)->get(route('admin.members.index', ['q' => 'Pagination Check', 'page' => 2]))
            ->assertOk()
            ->assertSee('q=Pagination%20Check', false);
    }

    private function admin(User $admin): static
    {
        return $this->withSession(['admin_user_id' => $admin->id]);
    }
}
