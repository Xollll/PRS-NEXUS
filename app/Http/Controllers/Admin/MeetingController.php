<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMeetingRequest;
use App\Http\Requests\UpdateMeetingRequest;
use App\Models\Meeting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MeetingController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim($request->string('q')->toString());
        $period = $request->string('period')->toString();

        if (! in_array($period, ['upcoming', 'past'], true)) {
            $period = '';
        }

        return view('admin.meetings.index', [
            'meetings' => Meeting::query()
                ->when($query !== '', fn ($builder) => $builder->where(function ($meetings) use ($query): void {
                    $meetings->where('title', 'like', "%{$query}%")
                        ->orWhere('location', 'like', "%{$query}%")
                        ->orWhere('summary', 'like', "%{$query}%");
                }))
                ->when($period === 'upcoming', fn ($builder) => $builder->whereDate('meeting_date', '>=', today()))
                ->when($period === 'past', fn ($builder) => $builder->whereDate('meeting_date', '<', today()))
                ->orderByDesc('meeting_date')
                ->paginate(20)
                ->withQueryString(),
            'query' => $query,
            'period' => $period,
        ]);
    }

    public function create(): View
    {
        return view('admin.meetings.create');
    }

    public function store(StoreMeetingRequest $request): RedirectResponse
    {
        Meeting::create($request->validated());

        return redirect()->route('admin.meetings.index')->with('success', 'Meeting created successfully.');
    }

    public function edit(Meeting $meeting): View
    {
        return view('admin.meetings.edit', compact('meeting'));
    }

    public function update(UpdateMeetingRequest $request, Meeting $meeting): RedirectResponse
    {
        $meeting->update($request->validated());

        return redirect()->route('admin.meetings.index')->with('success', 'Meeting updated successfully.');
    }

    public function destroy(Meeting $meeting): RedirectResponse
    {
        $meeting->delete();

        return redirect()->route('admin.meetings.index')->with('success', 'Meeting removed successfully.');
    }
}
