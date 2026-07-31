@extends('layouts.app', ['title' => 'SiswaSphere | Home'])

@section('content')
    <section class="grid gap-8 lg:grid-cols-[1.15fr_0.85fr] lg:items-center">
        <div>
            <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-amber-400/20 bg-amber-400/10 px-4 py-2 text-sm text-amber-100">
                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                Centralized club administration for UPSI
            </div>
            <h1 class="font-display max-w-3xl text-5xl font-bold leading-[1.05] tracking-tight text-white lg:text-7xl">
                One platform for members, meetings, and committee records.
            </h1>
            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">
                SiswaSphere follows a layered architecture so presentation, business logic, and data access stay cleanly separated while the club team manages records in one place.
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('directory') }}" class="rounded-full bg-white px-6 py-3 font-semibold text-slate-950 transition hover:bg-slate-200">Open Directory</a>
                <a href="{{ route('admin.login') }}" class="rounded-full border border-white/15 bg-white/5 px-6 py-3 font-semibold text-white transition hover:bg-white/10">Admin Login</a>
            </div>

            <div class="mt-10 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($stats as $label => $value)
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                        <p class="text-sm uppercase tracking-[0.24em] text-slate-400">{{ str_replace('_', ' ', $label) }}</p>
                        <p class="mt-3 font-display text-4xl font-bold text-white">{{ $value }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-6 shadow-2xl shadow-black/20 backdrop-blur">
            <div class="rounded-[1.5rem] border border-white/10 bg-gradient-to-br from-slate-900 to-slate-950 p-6">
                <p class="text-sm uppercase tracking-[0.3em] text-amber-300/80">System map</p>
                <div class="mt-6 space-y-4">
                    <div class="rounded-2xl border border-amber-400/20 bg-amber-400/10 p-4">
                        <p class="font-semibold text-white">Presentation Layer</p>
                        <p class="mt-1 text-sm text-slate-300">Web pages for home, search, and admin screens.</p>
                    </div>
                    <div class="rounded-2xl border border-cyan-400/20 bg-cyan-400/10 p-4">
                        <p class="font-semibold text-white">Application Layer</p>
                        <p class="mt-1 text-sm text-slate-300">Controllers handle directory search, record management, and session login.</p>
                    </div>
                    <div class="rounded-2xl border border-fuchsia-400/20 bg-fuchsia-400/10 p-4">
                        <p class="font-semibold text-white">Data Layer</p>
                        <p class="mt-1 text-sm text-slate-300">Members, committee positions, meetings, and activities stored in the database.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-16 grid gap-6 lg:grid-cols-3">
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
            <h2 class="font-display text-2xl font-bold text-white">Featured Members</h2>
            <div class="mt-5 space-y-4">
                @forelse ($featuredMembers as $member)
                    <div class="rounded-2xl border border-white/10 bg-slate-950/50 p-4">
                        <p class="font-semibold text-white">{{ $member->full_name }}</p>
                        <p class="text-sm text-slate-400">{{ $member->matric_no }} · {{ $member->role_title ?? 'Member' }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">No members have been added yet.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
            <h2 class="font-display text-2xl font-bold text-white">Recent Meetings</h2>
            <div class="mt-5 space-y-4">
                @forelse ($latestMeetings as $meeting)
                    <div class="rounded-2xl border border-white/10 bg-slate-950/50 p-4">
                        <p class="font-semibold text-white">{{ $meeting->title }}</p>
                        <p class="text-sm text-slate-400">{{ $meeting->meeting_date->format('d M Y') }} · {{ $meeting->location ?? 'TBA' }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">No meetings logged yet.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
            <h2 class="font-display text-2xl font-bold text-white">Upcoming Activities</h2>
            <div class="mt-5 space-y-4">
                @forelse ($latestActivities as $activity)
                    <div class="rounded-2xl border border-white/10 bg-slate-950/50 p-4">
                        <p class="font-semibold text-white">{{ $activity->title }}</p>
                        <p class="text-sm text-slate-400">{{ $activity->activity_date->format('d M Y') }} · {{ ucfirst($activity->status) }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">No activities scheduled yet.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection