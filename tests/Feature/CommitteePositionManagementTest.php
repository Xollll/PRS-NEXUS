<?php

namespace Tests\Feature;

use App\Models\CommitteePosition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommitteePositionManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_admin_can_manage_committee_positions(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $position = CommitteePosition::factory()->create(['title' => 'Treasurer']);

        $this->admin($admin)->get(route('admin.committee-positions.index'))
            ->assertOk()->assertSee('Treasurer');

        $this->admin($admin)->post(route('admin.committee-positions.store'), [
            'title' => 'Secretary', 'category' => 'executive', 'sort_order' => 2, 'description' => 'Keeps records.',
        ])->assertRedirect(route('admin.committee-positions.index'));
        $this->assertDatabaseHas('committee_positions', ['title' => 'Secretary']);

        $this->admin($admin)->put(route('admin.committee-positions.update', $position), [
            'title' => 'Finance Secretary', 'category' => 'executive', 'sort_order' => 1, 'description' => 'Manages finance records.',
        ])->assertRedirect(route('admin.committee-positions.index'));
        $this->assertDatabaseHas('committee_positions', ['id' => $position->id, 'title' => 'Finance Secretary']);

        $this->admin($admin)->delete(route('admin.committee-positions.destroy', $position))
            ->assertRedirect(route('admin.committee-positions.index'));
        $this->assertDatabaseMissing('committee_positions', ['id' => $position->id]);
    }

    public function test_committee_position_validation_rejects_invalid_input(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->admin($admin)->from(route('admin.committee-positions.create'))
            ->post(route('admin.committee-positions.store'), [])
            ->assertRedirect(route('admin.committee-positions.create'))
            ->assertSessionHasErrors(['title', 'category', 'sort_order']);
    }

    private function admin(User $admin): static
    {
        return $this->withSession(['admin_user_id' => $admin->id]);
    }
}
