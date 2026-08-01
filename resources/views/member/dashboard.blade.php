@extends('layouts.app', ['title' => 'SiswaSphere | Member Portal'])

@section('content')
    <section class="rounded-[2rem] border border-white/10 bg-white/5 p-6 backdrop-blur lg:p-8">
        <p class="text-sm uppercase tracking-[0.3em] text-cyan-300/80">Member Dashboard</p>
        <div class="mt-3 flex items-center gap-4"><x-member-avatar :member="$member" size="h-16 w-16" /><h1 class="font-display text-4xl font-bold text-white">Welcome back, {{ $member->full_name }}.</h1></div>
        <div class="mt-3 flex flex-wrap items-center justify-between gap-4"><p class="text-slate-300">Your personal organization information and latest records are all in one place.</p><a href="{{ route('member.profile.edit') }}" class="rounded-full border border-cyan-400/30 bg-cyan-400/10 px-4 py-2 text-sm font-medium text-cyan-100">Edit My Profile</a></div>
    </section>

    <form method="GET" action="{{ route('member.dashboard') }}" class="mt-6 grid gap-3 rounded-3xl border border-white/10 bg-slate-900/80 p-5 sm:grid-cols-2">
        <select name="meeting_filter" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white"><option value="">All meetings</option><option value="upcoming" @selected($meetingFilter === 'upcoming')>Upcoming meetings</option><option value="past" @selected($meetingFilter === 'past')>Past meetings</option></select>
        <select name="activity_status" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white"><option value="">All activities</option><option value="planned" @selected($activityStatus === 'planned')>Planned activities</option><option value="ongoing" @selected($activityStatus === 'ongoing')>Ongoing activities</option><option value="completed" @selected($activityStatus === 'completed')>Completed activities</option></select>
        <button class="rounded-2xl bg-cyan-400 px-5 py-3 font-semibold text-slate-950 sm:col-span-2">Apply Record Filters</button>
    </form>

    <div class="mt-8 grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
        <section class="rounded-3xl border border-cyan-400/20 bg-cyan-400/5 p-6">
            <h2 class="font-display text-2xl font-bold text-white">My Profile</h2>
            <dl class="mt-5 space-y-4 text-sm">
                <div><dt class="text-slate-400">Matric number</dt><dd class="mt-1 font-medium text-white">{{ $member->matric_no }}</dd></div>
                <div><dt class="text-slate-400">Programme</dt><dd class="mt-1 font-medium text-white">{{ $member->programme ?: 'Not recorded' }}</dd></div>
                <div><dt class="text-slate-400">Organization role</dt><dd class="mt-1 font-medium text-white">{{ $member->display_role }}</dd></div>
                <div><dt class="text-slate-400">Membership status</dt><dd class="mt-1 font-medium capitalize text-white">{{ $member->status }}</dd></div>
                <div><dt class="text-slate-400">Contact</dt><dd class="mt-1 font-medium text-white">{{ $member->email ?: 'Not recorded' }}{{ $member->phone ? ' · '.$member->phone : '' }}</dd></div>
            </dl>
        </section>

        <div class="space-y-6">
            <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-6">
                <h2 class="font-display text-2xl font-bold text-white">Meetings</h2>
                <div class="mt-5 space-y-3">
                    @forelse ($meetings as $meeting)
                        <article class="rounded-2xl border border-white/10 bg-slate-950/50 p-4"><p class="font-semibold text-white">{{ $meeting->title }}</p><p class="mt-1 text-sm text-slate-400">{{ $meeting->meeting_date->format('d M Y') }} · {{ $meeting->location ?: 'Location TBA' }}</p>@if($meeting->summary)<p class="mt-2 text-sm text-slate-300">{{ $meeting->summary }}</p>@endif</article>
                    @empty <p class="text-sm text-slate-400">No meeting records are available.</p> @endforelse
                </div>
            </section>
            <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-6">
                <h2 class="font-display text-2xl font-bold text-white">Activities</h2>
                <div class="mt-5 space-y-3">
                    @forelse ($activities as $activity)
                        <article class="rounded-2xl border border-white/10 bg-slate-950/50 p-4"><p class="font-semibold text-white">{{ $activity->title }}</p><p class="mt-1 text-sm text-slate-400">{{ $activity->activity_date->format('d M Y') }} · {{ ucfirst($activity->status) }} · {{ $activity->location ?: 'Location TBA' }}</p>@if($activity->description)<p class="mt-2 text-sm text-slate-300">{{ $activity->description }}</p>@endif</article>
                    @empty <p class="text-sm text-slate-400">No activity records are available.</p> @endforelse
                </div>
            </section>
        </div>
    </div>
@endsection
