@extends('layouts.app', ['title' => 'PRS NEXUS | Edit meeting'])

@section('content')
    @php($isUpcoming = $meeting->meeting_date->isToday() || $meeting->meeting_date->isFuture())
    <a href="{{ route('admin.meetings.index') }}" class="text-sm font-semibold text-blue-700 hover:underline">Back to meetings</a>

    <section class="mx-auto mt-5 max-w-3xl ui-panel">
        <div class="flex flex-col gap-4 border-b border-slate-200 pb-6 sm:flex-row sm:items-start sm:justify-between"><div><p class="text-sm font-semibold text-blue-700">Events</p><h1 class="mt-1 text-3xl font-bold text-slate-900">Edit meeting</h1><p class="mt-2 text-sm leading-6 text-slate-600">Update the meeting information shared with the PRS community.</p></div><x-badge :variant="$isUpcoming ? 'upcoming' : 'inactive'">{{ $isUpcoming ? 'Upcoming meeting' : 'Past meeting' }}</x-badge></div>

        <div class="mt-6 rounded-xl border border-blue-100 bg-blue-50 p-4"><p class="text-xs font-semibold uppercase tracking-wide text-blue-700">Scheduled date</p><p class="mt-1 text-lg font-semibold text-slate-900">{{ $meeting->meeting_date->format('l, d M Y') }}</p><p class="mt-1 text-sm text-slate-600">{{ $meeting->location ?: 'Venue to be confirmed' }}</p></div>

        <form method="POST" action="{{ route('admin.meetings.update', $meeting) }}" class="mt-8 space-y-6">
            @csrf
            @method('PUT')
            <section><h2 class="text-lg font-semibold text-slate-900">Meeting details</h2><div class="mt-4 grid gap-4 sm:grid-cols-2"><div class="sm:col-span-2"><x-form-input label="Meeting title" name="title" :value="$meeting->title" :required="true" /></div><x-form-input label="Meeting date" name="meeting_date" type="date" :value="$meeting->meeting_date->format('Y-m-d')" :required="true" /><x-form-input label="Location" name="location" :value="$meeting->location" help="Leave empty if the venue is not confirmed." /><div class="sm:col-span-2"><label for="summary" class="ui-label">Agenda or summary <span class="font-normal text-slate-500">(optional)</span></label><textarea id="summary" name="summary" rows="5" class="ui-textarea">{{ old('summary', $meeting->summary) }}</textarea>@error('summary')<p class="ui-error-text">{{ $message }}</p>@enderror</div></div></section><div class="flex flex-wrap gap-3 border-t border-slate-200 pt-6"><button class="ui-button-primary">Save changes</button><a href="{{ route('admin.meetings.index') }}" class="ui-button-secondary">Cancel</a></div>
        </form>
    </section>
@endsection
