<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Meeting;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_public_home_page_loads(): void
    {
        $this->get(route('home'))->assertOk()->assertSee('PRS NEXUS');
    }

    public function test_the_public_directory_searches_and_filters_current_data(): void
    {
        Member::factory()->create(['full_name' => 'Public Directory Member', 'programme' => 'Counselling']);
        Meeting::factory()->create(['title' => 'Upcoming public meeting', 'meeting_date' => today()->addDay()]);
        Meeting::factory()->create(['title' => 'Past public meeting', 'meeting_date' => today()->subDay()]);
        Activity::factory()->create(['title' => 'Planned public activity', 'status' => 'planned']);
        Activity::factory()->create(['title' => 'Completed public activity', 'status' => 'completed']);

        $this->get(route('directory', ['q' => 'Public', 'meeting_filter' => 'upcoming', 'activity_status' => 'planned']))
            ->assertOk()
            ->assertSee('Public Directory Member')
            ->assertSee('Upcoming public meeting')
            ->assertDontSee('Past public meeting')
            ->assertSee('Planned public activity')
            ->assertDontSee('Completed public activity');
    }
}
