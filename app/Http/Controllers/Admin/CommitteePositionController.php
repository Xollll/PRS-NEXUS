<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommitteePositionRequest;
use App\Http\Requests\UpdateCommitteePositionRequest;
use App\Models\CommitteePosition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommitteePositionController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim($request->string('q')->toString());

        return view('admin.committee-positions.index', [
            'committeePositions' => CommitteePosition::query()
                ->when($query !== '', fn ($builder) => $builder->where(function ($positions) use ($query): void {
                    $positions->where('title', 'like', "%{$query}%")
                        ->orWhere('category', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                }))
                ->orderBy('sort_order')
                ->orderBy('title')
                ->paginate(20)
                ->withQueryString(),
            'query' => $query,
        ]);
    }

    public function create(): View
    {
        return view('admin.committee-positions.create');
    }

    public function store(StoreCommitteePositionRequest $request): RedirectResponse
    {
        CommitteePosition::create($request->validated());

        return redirect()->route('admin.committee-positions.index')->with('success', 'Committee position created successfully.');
    }

    public function edit(CommitteePosition $committeePosition): View
    {
        return view('admin.committee-positions.edit', compact('committeePosition'));
    }

    public function update(UpdateCommitteePositionRequest $request, CommitteePosition $committeePosition): RedirectResponse
    {
        $committeePosition->update($request->validated());

        return redirect()->route('admin.committee-positions.index')->with('success', 'Committee position updated successfully.');
    }

    public function destroy(CommitteePosition $committeePosition): RedirectResponse
    {
        $committeePosition->delete();

        return redirect()->route('admin.committee-positions.index')->with('success', 'Committee position removed successfully.');
    }
}
