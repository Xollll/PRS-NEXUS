<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim($request->string('q')->toString());
        $status = $request->string('status')->toString();

        if (! in_array($status, ['planned', 'ongoing', 'completed'], true)) {
            $status = '';
        }

        return view('admin.activities.index', [
            'activities' => Activity::query()
                ->when($query !== '', fn ($builder) => $builder->where(function ($activities) use ($query): void {
                    $activities->where('title', 'like', "%{$query}%")
                        ->orWhere('location', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                }))
                ->when($status !== '', fn ($builder) => $builder->where('status', $status))
                ->orderByDesc('activity_date')
                ->paginate(20)
                ->withQueryString(),
            'query' => $query,
            'status' => $status,
        ]);
    }

    public function create(): View
    {
        return view('admin.activities.create');
    }

    public function store(StoreActivityRequest $request): RedirectResponse
    {
        Activity::create($request->validated());

        return redirect()->route('admin.activities.index')->with('success', 'Activity created successfully.');
    }

    public function edit(Activity $activity): View
    {
        return view('admin.activities.edit', compact('activity'));
    }

    public function update(UpdateActivityRequest $request, Activity $activity): RedirectResponse
    {
        $activity->update($request->validated());

        return redirect()->route('admin.activities.index')->with('success', 'Activity updated successfully.');
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $activity->delete();

        return redirect()->route('admin.activities.index')->with('success', 'Activity removed successfully.');
    }
}
