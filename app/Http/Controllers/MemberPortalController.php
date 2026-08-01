<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MemberPortalController extends Controller
{
    public function login(): View
    {
        return view('member.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::query()
            ->with('member')
            ->where('email', $credentials['email'])
            ->where('role', 'member')
            ->first();

        if (! $user || ! $user->member || ! Hash::check($credentials['password'], $user->password)) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'These credentials do not match our member records.']);
        }

        if ($user->member->status !== 'active') {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Your membership is currently inactive. Please contact an administrator.']);
        }

        $request->session()->regenerate();
        $request->session()->put('member_user_id', $user->id);

        return redirect()->route('member.dashboard');
    }

    public function dashboard(Request $request): View
    {
        $user = User::with('member.committeePosition')->findOrFail($request->session()->get('member_user_id'));
        $meetingFilter = $request->string('meeting_filter')->toString();
        $activityStatus = $request->string('activity_status')->toString();

        if (! in_array($meetingFilter, ['upcoming', 'past'], true)) {
            $meetingFilter = '';
        }

        if (! in_array($activityStatus, ['planned', 'ongoing', 'completed'], true)) {
            $activityStatus = '';
        }

        return view('member.dashboard', [
            'member' => $user->member,
            'meetingFilter' => $meetingFilter,
            'activityStatus' => $activityStatus,
            'meetings' => Meeting::query()
                ->when($meetingFilter === 'upcoming', fn ($builder) => $builder->whereDate('meeting_date', '>=', today()))
                ->when($meetingFilter === 'past', fn ($builder) => $builder->whereDate('meeting_date', '<', today()))
                ->orderByDesc('meeting_date')->limit(6)->get(),
            'activities' => Activity::query()
                ->when($activityStatus !== '', fn ($builder) => $builder->where('status', $activityStatus))
                ->orderByDesc('activity_date')->limit(6)->get(),
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('member_user_id');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function editProfile(Request $request): View
    {
        $user = User::with('member')->findOrFail($request->session()->get('member_user_id'));

        return view('member.profile', ['member' => $user->member]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = User::with('member')->findOrFail($request->session()->get('member_user_id'));

        $data = $request->validate([
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('members', 'email')->ignore($user->member->id),
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'programme' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $oldAvatarPath = $user->member->avatar_path;
        $avatarPath = $request->hasFile('avatar')
            ? $request->file('avatar')->store('avatars', 'public')
            : $oldAvatarPath;

        DB::transaction(function () use ($data, $user, $avatarPath): void {
            $user->member->update([
                'email' => $data['email'],
                'phone' => $data['phone'],
                'programme' => $data['programme'],
                'avatar_path' => $avatarPath,
            ]);

            $user->update(array_filter([
                'email' => $data['email'],
                'password' => $data['password'] ? Hash::make($data['password']) : null,
            ], fn ($value) => $value !== null));
        });

        if ($oldAvatarPath && $oldAvatarPath !== $avatarPath) {
            Storage::disk('public')->delete($oldAvatarPath);
        }

        return redirect()->route('member.dashboard')->with('success', 'Your profile has been updated.');
    }
}
