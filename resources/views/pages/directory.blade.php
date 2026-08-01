@extends('layouts.app', ['title' => 'SiswaSphere | Directory'])

@section('content')
    <section class="rounded-[2rem] border border-white/10 bg-white/5 p-6 backdrop-blur lg:p-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-amber-300/80">Public Directory</p>
                <h1 class="font-display mt-3 text-4xl font-bold text-white lg:text-5xl">Search members, committees, and meetings.</h1>
                <p class="mt-3 max-w-2xl text-slate-300">This page mirrors the document's view-only layer for fast lookups across the student organization.</p>
            </div>
            <form method="GET" action="{{ route('directory') }}" class="grid w-full max-w-xl gap-3 sm:grid-cols-2">
                <input name="q" value="{{ $query }}" placeholder="Search name, role, title, or location" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500 focus:border-amber-400/40 focus:outline-none sm:col-span-2">
                <select name="meeting_filter" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white"><option value="">All meetings</option><option value="upcoming" @selected($meetingFilter === 'upcoming')>Upcoming meetings</option><option value="past" @selected($meetingFilter === 'past')>Past meetings</option></select>
                <select name="activity_status" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white"><option value="">All activities</option><option value="planned" @selected($activityStatus === 'planned')>Planned activities</option><option value="ongoing" @selected($activityStatus === 'ongoing')>Ongoing activities</option><option value="completed" @selected($activityStatus === 'completed')>Completed activities</option></select>
                <button class="rounded-2xl bg-amber-400 px-5 py-3 font-semibold text-slate-950 transition hover:bg-amber-300 sm:col-span-2">Apply Filters</button>
            </form>
        </div>
    </section>

    <div class="mt-8 grid gap-6 xl:grid-cols-3">
        <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-6">
            <h2 class="font-display text-2xl font-bold text-white">Members</h2>
            <div class="mt-5 space-y-4">
                @forelse ($members as $member)
                    <article class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <div class="flex items-center gap-3"><x-member-avatar :member="$member" size="h-11 w-11" /><div><p class="font-semibold text-white">{{ $member->full_name }}</p><p class="text-sm text-slate-400">{{ $member->matric_no }} · {{ $member->programme ?? 'Programme not set' }}</p><p class="mt-2 text-sm text-amber-200">{{ $member->display_role }}</p></div></div>
                    </article>
                @empty
                    <p class="text-sm text-slate-400">No matching members found.</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-6">
            <h2 class="font-display text-2xl font-bold text-white">Committee Structure</h2>
            <div class="mt-5 space-y-4">
                @forelse ($committeePositions as $position)
                    <article class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="font-semibold text-white">{{ $position->title }}</p>
                        <p class="text-sm text-slate-400">{{ ucfirst($position->category) }}</p>
                        <p class="mt-2 text-sm text-slate-300">{{ $position->description ?? 'No description available.' }}</p>
                    </article>
                @empty
                    <p class="text-sm text-slate-400">No committee positions found.</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-6">
            <h2 class="font-display text-2xl font-bold text-white">Meeting History</h2>
            <div class="mt-5 space-y-4">
                @forelse ($meetings as $meeting)
                    <article class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="font-semibold text-white">{{ $meeting->title }}</p>
                        <p class="text-sm text-slate-400">{{ $meeting->meeting_date->format('d M Y') }} · {{ $meeting->location ?? 'TBA' }}</p>
                        <p class="mt-2 text-sm text-slate-300">{{ $meeting->summary ?? 'No summary available.' }}</p>
                    </article>
                @empty
                    <p class="text-sm text-slate-400">No meeting records found.</p>
                @endforelse
            </div>
        </section>
    </div>

    <section class="mt-8 rounded-3xl border border-white/10 bg-white/5 p-6">
        <h2 class="font-display text-2xl font-bold text-white">Upcoming Activities</h2>
        <div class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($activities as $activity)
                <article class="rounded-2xl border border-white/10 bg-slate-950/50 p-4">
                    <p class="font-semibold text-white">{{ $activity->title }}</p>
                    <p class="text-sm text-slate-400">{{ $activity->activity_date->format('d M Y') }} · {{ $activity->location ?? 'TBA' }}</p>
                    <p class="mt-2 text-sm text-slate-300">{{ $activity->description ?? 'No description available.' }}</p>
                </article>
            @empty
                <p class="text-sm text-slate-400">No activities scheduled yet.</p>
            @endforelse
        </div>
    </section>
@endsection
