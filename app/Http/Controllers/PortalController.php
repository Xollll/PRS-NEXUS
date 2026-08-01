<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\CommitteePosition;
use App\Models\Meeting;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class PortalController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'stats' => [
                'members' => $this->safeCount(Member::class),
                'committees' => $this->safeCount(CommitteePosition::class),
                'meetings' => $this->safeCount(Meeting::class),
                'activities' => $this->safeCount(Activity::class),
            ],
            'featuredMembers' => $this->safeCollection(fn () => Member::with('committeePosition')->latest()->limit(3)->get()),
            'latestMeetings' => $this->safeCollection(fn () => Meeting::latest('meeting_date')->limit(3)->get()),
            'latestActivities' => $this->safeCollection(fn () => Activity::latest('activity_date')->limit(3)->get()),
        ]);
    }

    public function directory(Request $request): View
    {
        $query = trim($request->string('q')->toString());
        $meetingFilter = $request->string('meeting_filter')->toString();
        $activityStatus = $request->string('activity_status')->toString();

        if (! in_array($meetingFilter, ['upcoming', 'past'], true)) {
            $meetingFilter = '';
        }

        if (! in_array($activityStatus, ['planned', 'ongoing', 'completed'], true)) {
            $activityStatus = '';
        }

        $members = Member::query()->with('committeePosition')
            ->when($query !== '', function ($builder) use ($query): void {
                $builder->where(function ($search) use ($query): void {
                    $search->where('full_name', 'like', "%{$query}%")
                        ->orWhere('matric_no', 'like', "%{$query}%")
                        ->orWhere('programme', 'like', "%{$query}%")
                        ->orWhere('role_title', 'like', "%{$query}%")
                        ->orWhereHas('committeePosition', fn ($positions) => $positions->where('title', 'like', "%{$query}%"));
                });
            })
            ->orderBy('full_name')
            ->get();

        $committeePositions = CommitteePosition::query()
            ->when($query !== '', fn ($builder) => $builder->where('title', 'like', "%{$query}%"))
            ->orderBy('sort_order')
            ->get();

        $meetings = Meeting::query()
            ->when($query !== '', function ($builder) use ($query): void {
                $builder->where(function ($search) use ($query): void {
                    $search->where('title', 'like', "%{$query}%")
                        ->orWhere('location', 'like', "%{$query}%");
                });
            })
            ->when($meetingFilter === 'upcoming', fn ($builder) => $builder->whereDate('meeting_date', '>=', today()))
            ->when($meetingFilter === 'past', fn ($builder) => $builder->whereDate('meeting_date', '<', today()))
            ->latest('meeting_date')
            ->get();

        return view('pages.directory', [
            'query' => $query,
            'meetingFilter' => $meetingFilter,
            'activityStatus' => $activityStatus,
            'members' => $members,
            'committeePositions' => $committeePositions,
            'meetings' => $meetings,
            'activities' => Activity::query()
                ->when($query !== '', function ($builder) use ($query): void {
                    $builder->where(function ($search) use ($query): void {
                        $search->where('title', 'like', "%{$query}%")
                            ->orWhere('location', 'like', "%{$query}%");
                    });
                })
                ->when($activityStatus !== '', fn ($builder) => $builder->where('status', $activityStatus))
                ->latest('activity_date')
                ->get(),
        ]);
    }

    private function safeCount(string $modelClass): int
    {
        return $this->safeValue(fn () => $modelClass::count(), 0);
    }

    private function safeCollection(callable $callback)
    {
        return $this->safeValue($callback, collect());
    }

    private function safeValue(callable $callback, mixed $default = null): mixed
    {
        try {
            return $callback();
        } catch (Throwable $exception) {
            report($exception);

            return $default;
        }
    }
}
