<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\CommitteePosition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($members) use ($q): void {
                $members->where('full_name', 'like', "%{$q}%")
                    ->orWhere('matric_no', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $members = $query->with('committeePosition')->orderBy('full_name')->paginate(20)->withQueryString();

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create', ['committeePositions' => CommitteePosition::orderBy('sort_order')->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'matric_no' => 'required|string|unique:members,matric_no',
            'email' => ['required', 'email', 'unique:members,email', 'unique:users,email'],
            'phone' => 'nullable|string|max:30',
            'programme' => 'nullable|string|max:255',
            'role_title' => 'nullable|string|max:255',
            'committee_position_id' => 'nullable|exists:committee_positions,id',
            'status' => 'required|in:active,inactive',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($data): void {
            $member = Member::create(collect($data)->except(['password', 'password_confirmation'])->all());

            User::create([
                'member_id' => $member->id,
                'name' => $member->full_name,
                'email' => $member->email,
                'password' => Hash::make($data['password']),
                'role' => 'member',
            ]);
        });

        return redirect()->route('admin.members.index')->with('success', 'Member created.');
    }

    public function show(Member $member)
    {
        $member->load('committeePosition');
        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('members.edit', ['member' => $member, 'committeePositions' => CommitteePosition::orderBy('sort_order')->get()]);
    }

    public function update(Request $request, Member $member)
    {

        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'matric_no' => 'required|string|unique:members,matric_no,'. $member->id,
            'email' => ['required', 'email', Rule::unique('members', 'email')->ignore($member->id), Rule::unique('users', 'email')->ignore($member->user?->id)],
            'phone' => 'nullable|string|max:30',
            'programme' => 'nullable|string|max:255',
            'role_title' => 'nullable|string|max:255',
            'committee_position_id' => 'nullable|exists:committee_positions,id',
            'status' => 'required|in:active,inactive',
            'password' => [Rule::requiredIf(! $member->user()->exists()), 'nullable', 'string', 'min:8', 'confirmed'],
        ]);

        DB::transaction(function () use ($data, $member): void {
            $member->update(collect($data)->except(['password', 'password_confirmation'])->all());

            $member->user()->updateOrCreate([], array_filter([
                'name' => $member->full_name,
                'email' => $member->email,
                'role' => 'member',
                'password' => ($data['password'] ?? null) ? Hash::make($data['password']) : null,
            ], fn ($value) => $value !== null));
        });

        return redirect()->route('admin.members.index')->with('success', 'Member updated.');
    }

    public function destroy(Member $member)
    {
        DB::transaction(function () use ($member): void {
            $member->user()->delete();
            $member->delete();
        });
        return redirect()->route('admin.members.index')->with('success', 'Member removed.');
    }
}
