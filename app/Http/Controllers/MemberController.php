<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('full_name', 'like', "%{$q}%")
                  ->orWhere('matric_no', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%");
        }

        $members = $query->orderBy('name')->paginate(20);

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'matric_no' => 'required|string|unique:members,matric_no',
            'email' => 'nullable|email|unique:members,email',
            'phone' => 'nullable|string|max:30',
            'programme' => 'nullable|string|max:255',
            'role_title' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        Member::create($data);

        return redirect()->route('members.index')->with('success', 'Member created.');
    }

    public function show(Member $member)
    {
        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {

        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'matric_no' => 'required|string|unique:members,matric_no,'. $member->id,
            'email' => 'nullable|email|unique:members,email,'. $member->id,
            'phone' => 'nullable|string|max:30',
            'programme' => 'nullable|string|max:255',
            'role_title' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $member->update($data);

        return redirect()->route('members.index')->with('success', 'Member updated.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member removed.');
    }
}
