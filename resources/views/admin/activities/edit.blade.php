@extends('layouts.app', ['title' => 'PRS NEXUS | Edit activity'])

@section('content')
    @php($badgeVariant = $activity->status === 'completed' ? 'success' : ($activity->status === 'ongoing' ? 'info' : 'upcoming'))
    <a href="{{ route('admin.activities.index') }}" class="text-sm font-semibold text-blue-700 hover:underline">Back to activities</a>

    <section class="mx-auto mt-5 max-w-3xl ui-panel">
        <div class="flex flex-col gap-4 border-b border-slate-200 pb-6 sm:flex-row sm:items-start sm:justify-between"><div><p class="text-sm font-semibold text-blue-700">Events</p><h1 class="mt-1 text-3xl font-bold text-slate-900">Edit activity</h1><p class="mt-2 text-sm leading-6 text-slate-600">Update the activity details shared with the PRS community.</p></div><x-badge :variant="$badgeVariant">{{ ucfirst($activity->status) }}</x-badge></div>

        <div class="mt-6 rounded-xl border border-blue-100 bg-blue-50 p-4"><p class="text-xs font-semibold uppercase tracking-wide text-blue-700">Activity schedule</p><p class="mt-1 text-lg font-semibold text-slate-900">{{ $activity->activity_date->format('l, d M Y') }}</p><p class="mt-1 text-sm text-slate-600">{{ $activity->location ?: 'Venue to be confirmed' }}</p></div>

        <form method="POST" action="{{ route('admin.activities.update', $activity) }}" class="mt-8 space-y-6">
            @csrf
            @method('PUT')
            <section><h2 class="text-lg font-semibold text-slate-900">Activity details</h2><div class="mt-4 grid gap-4 sm:grid-cols-2"><div class="sm:col-span-2"><x-form-input label="Activity title" name="title" :value="$activity->title" :required="true" /></div><x-form-input label="Activity date" name="activity_date" type="date" :value="$activity->activity_date->format('Y-m-d')" :required="true" /><x-form-input label="Location" name="location" :value="$activity->location" help="Leave empty if the venue is not confirmed." /><div><label for="status" class="ui-label">Activity status</label><select id="status" name="status" class="ui-select"><option value="planned" @selected(old('status', $activity->status) === 'planned')>Planned</option><option value="ongoing" @selected(old('status', $activity->status) === 'ongoing')>Ongoing</option><option value="completed" @selected(old('status', $activity->status) === 'completed')>Completed</option></select>@error('status')<p class="ui-error-text">{{ $message }}</p>@enderror</div><div class="sm:col-span-2"><label for="description" class="ui-label">Activity description <span class="font-normal text-slate-500">(optional)</span></label><textarea id="description" name="description" rows="5" class="ui-textarea">{{ old('description', $activity->description) }}</textarea>@error('description')<p class="ui-error-text">{{ $message }}</p>@enderror</div></div></section><div class="flex flex-wrap gap-3 border-t border-slate-200 pt-6"><button class="ui-button-primary">Save changes</button><a href="{{ route('admin.activities.index') }}" class="ui-button-secondary">Cancel</a></div>
        </form>
    </section>
@endsection
