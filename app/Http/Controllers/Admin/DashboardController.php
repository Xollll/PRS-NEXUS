<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\CommitteePosition;
use App\Models\Meeting;
use App\Models\Member;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('pages.dashboard', [
            'stats' => [
                'members' => Member::count(),
                'committees' => CommitteePosition::count(),
                'meetings' => Meeting::count(),
                'activities' => Activity::count(),
            ],
            'members' => Member::with('committeePosition')->latest()->limit(6)->get(),
            'upcomingMeetings' => Meeting::query()
                ->whereDate('meeting_date', '>=', today())
                ->orderBy('meeting_date')
                ->limit(5)
                ->get(),
            'recentActivities' => Activity::query()
                ->orderByDesc('activity_date')
                ->limit(5)
                ->get(),
            'admin' => User::find(session('admin_user_id')),
        ]);
    }
}
