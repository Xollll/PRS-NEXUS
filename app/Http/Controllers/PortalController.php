<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\CommitteePosition;
use App\Models\Meeting;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
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

    public function login(): View
    {
        return view('admin.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::query()
            ->where('email', $credentials['email'])
            ->where('role', 'admin')
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'These credentials do not match our admin records.']);
        }

        $request->session()->regenerate();
        $request->session()->put('admin_user_id', $user->id);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('admin_user_id');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function dashboard(): View
    {
        return view('pages.dashboard', [
            'stats' => [
                'members' => $this->safeCount(Member::class),
                'committees' => $this->safeCount(CommitteePosition::class),
                'meetings' => $this->safeCount(Meeting::class),
                'activities' => $this->safeCount(Activity::class),
            ],
            'members' => $this->safeCollection(fn () => Member::with('committeePosition')->latest()->limit(6)->get()),
            'committeePositions' => $this->safeCollection(fn () => CommitteePosition::orderBy('sort_order')->get()),
            'meetings' => $this->safeCollection(fn () => Meeting::latest('meeting_date')->limit(6)->get()),
            'activities' => $this->safeCollection(fn () => Activity::latest('activity_date')->limit(6)->get()),
            'admin' => $this->safeValue(fn () => User::find(session('admin_user_id'))),
        ]);
    }

    public function storeMember(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'matric_no' => ['required', 'string', 'max:255', 'unique:members,matric_no'],
            'email' => ['nullable', 'email', 'max:255', 'unique:members,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'programme' => ['nullable', 'string', 'max:255'],
            'role_title' => ['nullable', 'string', 'max:255'],
            'committee_position_id' => ['nullable', 'exists:committee_positions,id'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        Member::create($data);

        return back()->with('success', 'Member created successfully.');
    }

    public function destroyMember(Member $member): RedirectResponse
    {
        $member->delete();

        return back()->with('success', 'Member removed successfully.');
    }

    public function storeCommitteePosition(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        CommitteePosition::create($data);

        return back()->with('success', 'Committee position created successfully.');
    }

    public function destroyCommitteePosition(CommitteePosition $committeePosition): RedirectResponse
    {
        $committeePosition->delete();

        return back()->with('success', 'Committee position removed successfully.');
    }

    public function editCommitteePosition(CommitteePosition $committeePosition): View
    {
        return view('admin.committee-positions.edit', compact('committeePosition'));
    }

    public function updateCommitteePosition(Request $request, CommitteePosition $committeePosition): RedirectResponse
    {
        $committeePosition->update($request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ]));

        return redirect()->route('admin.dashboard')->with('success', 'Committee position updated successfully.');
    }

    public function storeMeeting(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'meeting_date' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
        ]);

        Meeting::create($data);

        return back()->with('success', 'Meeting created successfully.');
    }

    public function destroyMeeting(Meeting $meeting): RedirectResponse
    {
        $meeting->delete();

        return back()->with('success', 'Meeting removed successfully.');
    }

    public function editMeeting(Meeting $meeting): View
    {
        return view('admin.meetings.edit', compact('meeting'));
    }

    public function updateMeeting(Request $request, Meeting $meeting): RedirectResponse
    {
        $meeting->update($request->validate([
            'title' => ['required', 'string', 'max:255'],
            'meeting_date' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
        ]));

        return redirect()->route('admin.dashboard')->with('success', 'Meeting updated successfully.');
    }

    public function storeActivity(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'activity_date' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['planned', 'ongoing', 'completed'])],
        ]);

        Activity::create($data);

        return back()->with('success', 'Activity created successfully.');
    }

    public function destroyActivity(Activity $activity): RedirectResponse
    {
        $activity->delete();

        return back()->with('success', 'Activity removed successfully.');
    }

    public function editActivity(Activity $activity): View
    {
        return view('admin.activities.edit', compact('activity'));
    }

    public function updateActivity(Request $request, Activity $activity): RedirectResponse
    {
        $activity->update($request->validate([
            'title' => ['required', 'string', 'max:255'],
            'activity_date' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['planned', 'ongoing', 'completed'])],
        ]));

        return redirect()->route('admin.dashboard')->with('success', 'Activity updated successfully.');
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
        } catch (Throwable) {
            return $default;
        }
    }
}
