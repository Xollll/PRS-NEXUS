@extends('layouts.app', ['title' => 'SiswaSphere | Edit Activity'])

@section('content')
    <section class="mx-auto max-w-2xl rounded-3xl border border-white/10 bg-slate-900/80 p-6 lg:p-8">
        <p class="text-sm uppercase tracking-[0.3em] text-fuchsia-300/80">Admin Management</p>
        <h1 class="font-display mt-3 text-3xl font-bold text-white">Edit activity</h1>
        <form method="POST" action="{{ route('admin.activities.update', $activity) }}" class="mt-7 grid gap-4 sm:grid-cols-2">
            @csrf @method('PUT')
            <input name="title" value="{{ old('title', $activity->title) }}" required placeholder="Activity title" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white sm:col-span-2">
            <input name="activity_date" type="date" value="{{ old('activity_date', $activity->activity_date->format('Y-m-d')) }}" required class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white">
            <input name="location" value="{{ old('location', $activity->location) }}" placeholder="Location" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white">
            <select name="status" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white sm:col-span-2"><option value="planned" @selected(old('status', $activity->status) === 'planned')>Planned</option><option value="ongoing" @selected(old('status', $activity->status) === 'ongoing')>Ongoing</option><option value="completed" @selected(old('status', $activity->status) === 'completed')>Completed</option></select>
            <textarea name="description" rows="5" placeholder="Description" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white sm:col-span-2">{{ old('description', $activity->description) }}</textarea>
            <div class="flex gap-3 sm:col-span-2"><button class="rounded-2xl bg-fuchsia-400 px-5 py-3 font-semibold text-slate-950">Save Changes</button><a href="{{ route('admin.dashboard') }}" class="rounded-2xl border border-white/10 px-5 py-3 font-medium text-white">Cancel</a></div>
        </form>
    </section>
@endsection
