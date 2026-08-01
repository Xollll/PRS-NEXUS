@extends('layouts.app', ['title' => 'SiswaSphere | Edit Meeting'])

@section('content')
    <section class="mx-auto max-w-2xl rounded-3xl border border-white/10 bg-slate-900/80 p-6 lg:p-8">
        <p class="text-sm uppercase tracking-[0.3em] text-amber-300/80">Admin Management</p>
        <h1 class="font-display mt-3 text-3xl font-bold text-white">Edit meeting</h1>
        <form method="POST" action="{{ route('admin.meetings.update', $meeting) }}" class="mt-7 grid gap-4 sm:grid-cols-2">
            @csrf @method('PUT')
            <input name="title" value="{{ old('title', $meeting->title) }}" required placeholder="Meeting title" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white sm:col-span-2">
            <input name="meeting_date" type="date" value="{{ old('meeting_date', $meeting->meeting_date->format('Y-m-d')) }}" required class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white">
            <input name="location" value="{{ old('location', $meeting->location) }}" placeholder="Location" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white">
            <textarea name="summary" rows="5" placeholder="Summary" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white sm:col-span-2">{{ old('summary', $meeting->summary) }}</textarea>
            <div class="flex gap-3 sm:col-span-2"><button class="rounded-2xl bg-amber-400 px-5 py-3 font-semibold text-slate-950">Save Changes</button><a href="{{ route('admin.dashboard') }}" class="rounded-2xl border border-white/10 px-5 py-3 font-medium text-white">Cancel</a></div>
        </form>
    </section>
@endsection
