<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\CommitteePosition;
use App\Models\Meeting;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@siswasphere.test'],
            [
                'role' => 'admin',
                'name' => 'SiswaSphere Admin',
                'password' => Hash::make('password'),
            ]
        );

        $members = [
            [
                'full_name' => 'Muhammad Naif Bin Mazuki',
                'matric_no' => 'D20221101801',
                'email' => 'naif@example.test',
                'phone' => '012-3456789',
                'programme' => 'Educational Technology',
                'role_title' => 'Project Lead',
                'status' => 'active',
            ],
            [
                'full_name' => 'Muhammad Zal Hasmi',
                'matric_no' => 'D20221101807',
                'email' => 'zal@example.test',
                'phone' => '012-3334444',
                'programme' => 'Software Engineering',
                'role_title' => 'Frontend Developer',
                'status' => 'active',
            ],
            [
                'full_name' => 'Mohammad Ariq Haikal Bin Mohd Ros Haidi',
                'matric_no' => 'D20221101872',
                'email' => 'ariq@example.test',
                'phone' => '012-7778888',
                'programme' => 'Computer Science',
                'role_title' => 'Backend Developer',
                'status' => 'active',
            ],
        ];

        foreach ($members as $m) {
            Member::updateOrCreate(['matric_no' => $m['matric_no']], $m);
        }

        $positions = [
            ['title' => 'President', 'category' => 'executive', 'sort_order' => 1, 'description' => 'Leads the student organization and approves major decisions.'],
            ['title' => 'Secretary', 'category' => 'executive', 'sort_order' => 2, 'description' => 'Handles records, correspondence, and meeting minutes.'],
            ['title' => 'Treasurer', 'category' => 'executive', 'sort_order' => 3, 'description' => 'Manages financial records and club expenditures.'],
        ];

        foreach ($positions as $p) {
            CommitteePosition::updateOrCreate(['title' => $p['title']], $p);
        }

        $meetings = [
            ['title' => 'Semester Planning Meeting', 'meeting_date' => now()->subDays(10), 'location' => 'Dewan Seminar UPSI', 'summary' => 'Reviewed semester goals, task assignments, and event timelines.'],
            ['title' => 'Committee Coordination Session', 'meeting_date' => now()->subDays(5), 'location' => 'Online Meeting', 'summary' => 'Aligned communication flow and checked activity readiness.'],
        ];

        foreach ($meetings as $m) {
            Meeting::updateOrCreate(['title' => $m['title'], 'meeting_date' => $m['meeting_date']], $m);
        }

        $activities = [
            ['title' => 'Leadership Workshop', 'activity_date' => now()->addDays(4), 'location' => 'Main Hall UPSI', 'description' => 'A training session for new committee members.', 'status' => 'planned'],
            ['title' => 'Community Outreach', 'activity_date' => now()->addDays(12), 'location' => 'Local Community Center', 'description' => 'Student-led volunteering and networking activity.', 'status' => 'planned'],
        ];

        foreach ($activities as $a) {
            Activity::updateOrCreate(['title' => $a['title'], 'activity_date' => $a['activity_date']], $a);
        }
    }
}
