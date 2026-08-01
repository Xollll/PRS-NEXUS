<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_admin_can_view_and_filter_activities(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $activity = Activity::factory()->create(['title' => 'Ongoing leadership camp', 'status' => 'ongoing']);
        Activity::factory()->create(['title' => 'Completed leadership camp', 'status' => 'completed']);

        $this->admin($admin)->get(route('admin.activities.index', ['q' => 'leadership', 'status' => 'ongoing']))
            ->assertOk()
            ->assertSee($activity->title)
            ->assertDontSee('Completed leadership camp');
    }

    public function test_an_admin_can_create_update_and_delete_an_activity(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->admin($admin)->post(route('admin.activities.store'), [
            'title' => 'Peer support workshop', 'activity_date' => '2026-10-18', 'location' => 'Resource Centre', 'description' => 'Peer support practice.', 'status' => 'planned',
        ])->assertRedirect(route('admin.activities.index'));
        $activity = Activity::where('title', 'Peer support workshop')->firstOrFail();

        $this->admin($admin)->get(route('admin.activities.edit', $activity))->assertOk();
        $this->admin($admin)->put(route('admin.activities.update', $activity), [
            'title' => 'Peer support workshop', 'activity_date' => '2026-10-19', 'location' => 'Resource Centre', 'description' => 'Workshop underway.', 'status' => 'ongoing',
        ])->assertRedirect(route('admin.activities.index'));
        $this->assertDatabaseHas('activities', ['id' => $activity->id, 'status' => 'ongoing']);

        $this->admin($admin)->delete(route('admin.activities.destroy', $activity))
            ->assertRedirect(route('admin.activities.index'));
        $this->assertDatabaseMissing('activities', ['id' => $activity->id]);
    }

    public function test_invalid_activity_data_is_rejected(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->admin($admin)->from(route('admin.activities.create'))
            ->post(route('admin.activities.store'), ['title' => '', 'activity_date' => 'not-a-date', 'status' => 'invalid'])
            ->assertRedirect(route('admin.activities.create'))
            ->assertSessionHasErrors(['title', 'activity_date', 'status']);
    }

    private function admin(User $admin): static
    {
        return $this->withSession(['admin_user_id' => $admin->id]);
    }
}
