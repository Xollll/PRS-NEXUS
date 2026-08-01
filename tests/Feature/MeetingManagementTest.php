<?php

namespace Tests\Feature;

use App\Models\Meeting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeetingManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_admin_can_view_and_filter_meetings(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $upcoming = Meeting::factory()->create(['title' => 'Upcoming planning meeting', 'meeting_date' => today()->addWeek()]);
        Meeting::factory()->create(['title' => 'Past planning meeting', 'meeting_date' => today()->subWeek()]);

        $this->admin($admin)->get(route('admin.meetings.index', ['q' => 'Upcoming', 'period' => 'upcoming']))
            ->assertOk()
            ->assertSee($upcoming->title)
            ->assertDontSee('Past planning meeting');
    }

    public function test_an_admin_can_create_update_and_delete_a_meeting(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->admin($admin)->post(route('admin.meetings.store'), [
            'title' => 'Orientation meeting', 'meeting_date' => '2026-10-15', 'location' => 'Seminar Room', 'summary' => 'Prepare new members.',
        ])->assertRedirect(route('admin.meetings.index'));
        $meeting = Meeting::where('title', 'Orientation meeting')->firstOrFail();

        $this->admin($admin)->get(route('admin.meetings.edit', $meeting))->assertOk();
        $this->admin($admin)->put(route('admin.meetings.update', $meeting), [
            'title' => 'Orientation briefing', 'meeting_date' => '2026-10-16', 'location' => 'Main Hall', 'summary' => 'Updated briefing.',
        ])->assertRedirect(route('admin.meetings.index'));
        $this->assertDatabaseHas('meetings', ['id' => $meeting->id, 'title' => 'Orientation briefing']);

        $this->admin($admin)->delete(route('admin.meetings.destroy', $meeting))
            ->assertRedirect(route('admin.meetings.index'));
        $this->assertDatabaseMissing('meetings', ['id' => $meeting->id]);
    }

    public function test_invalid_meeting_data_is_rejected(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->admin($admin)->from(route('admin.meetings.create'))
            ->post(route('admin.meetings.store'), ['title' => '', 'meeting_date' => 'not-a-date'])
            ->assertRedirect(route('admin.meetings.create'))
            ->assertSessionHasErrors(['title', 'meeting_date']);
    }

    private function admin(User $admin): static
    {
        return $this->withSession(['admin_user_id' => $admin->id]);
    }
}
