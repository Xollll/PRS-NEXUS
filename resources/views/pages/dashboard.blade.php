@extends('layouts.app', ['title' => 'SiswaSphere | Dashboard'])

@section('content')
    <section class="rounded-[2rem] border border-white/10 bg-white/5 p-6 backdrop-blur lg:p-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-emerald-300/80">Admin Dashboard</p>
                <h1 class="font-display mt-3 text-4xl font-bold text-white lg:text-5xl">Manage the SiswaSphere record system.</h1>
                <p class="mt-3 max-w-2xl text-slate-300">Logged in as {{ $admin?->name ?? 'Admin' }}. Use the forms below to create records and keep the system aligned with the architecture document.</p>
            </div>
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                @foreach ($stats as $label => $value)
                    <div class="rounded-2xl border border-white/10 bg-slate-950/50 p-4 text-center">
                        <p class="text-xs uppercase tracking-[0.22em] text-slate-500">{{ str_replace('_', ' ', $label) }}</p>
                        <p class="mt-2 font-display text-3xl font-bold text-white">{{ $value }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-5">
        <a href="{{ route('admin.members.index') }}" class="rounded-2xl border border-white/10 bg-white/5 px-5 py-4 text-center font-semibold text-white transition hover:border-cyan-400/40 hover:bg-cyan-400/10">Manage All Members</a>
        <a href="#add-member" class="rounded-2xl border border-emerald-400/30 bg-emerald-400/10 px-5 py-4 text-center font-semibold text-emerald-100 transition hover:bg-emerald-400/20">Add Member</a>
        <a href="#committee-management" class="rounded-2xl border border-cyan-400/30 bg-cyan-400/10 px-5 py-4 text-center font-semibold text-cyan-100 transition hover:bg-cyan-400/20">Committee Positions</a>
        <a href="#meeting-management" class="rounded-2xl border border-amber-400/30 bg-amber-400/10 px-5 py-4 text-center font-semibold text-amber-100 transition hover:bg-amber-400/20">Meetings</a>
        <a href="#activity-management" class="rounded-2xl border border-fuchsia-400/30 bg-fuchsia-400/10 px-5 py-4 text-center font-semibold text-fuchsia-100 transition hover:bg-fuchsia-400/20">Activities</a>
    </section>

    <div class="mt-8 grid gap-6 xl:grid-cols-2">
        <section id="add-member" class="rounded-3xl border border-white/10 bg-slate-900/80 p-6">
            <h2 class="font-display text-2xl font-bold text-white">Add Member</h2>
            <form method="POST" action="{{ route('admin.members.store') }}" class="mt-5 grid gap-4 sm:grid-cols-2">
                @csrf
                <input name="full_name" placeholder="Full name" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500 sm:col-span-2">
                <input name="matric_no" placeholder="Matric number" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500">
                <input name="email" type="email" required placeholder="Email" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500">
                <input name="password" type="password" required placeholder="Member portal password" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500">
                <input name="password_confirmation" type="password" required placeholder="Confirm portal password" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500">
                <input name="phone" placeholder="Phone" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500">
                <input name="programme" placeholder="Programme" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500">
                <select name="committee_position_id" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white"><option value="">No committee position</option>@foreach ($committeePositions as $position)<option value="{{ $position->id }}">{{ $position->title }}</option>@endforeach</select>
                <input name="role_title" placeholder="Custom role title (optional)" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500">
                <select name="status" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white sm:col-span-2">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <button class="rounded-2xl bg-emerald-400 px-5 py-3 font-semibold text-slate-950 sm:col-span-2">Save Member</button>
            </form>
        </section>

        <section id="committee-management" class="rounded-3xl border border-white/10 bg-slate-900/80 p-6">
            <h2 class="font-display text-2xl font-bold text-white">Add Committee Position</h2>
            <form method="POST" action="{{ route('admin.committee-positions.store') }}" class="mt-5 grid gap-4 sm:grid-cols-2">
                @csrf
                <input name="title" placeholder="Position title" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500 sm:col-span-2">
                <input name="category" placeholder="Category" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500">
                <input name="sort_order" type="number" min="0" value="0" placeholder="Sort order" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500">
                <textarea name="description" rows="4" placeholder="Description" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500 sm:col-span-2"></textarea>
                <button class="rounded-2xl bg-cyan-400 px-5 py-3 font-semibold text-slate-950 sm:col-span-2">Save Position</button>
            </form>
        </section>

        <section id="meeting-management" class="rounded-3xl border border-white/10 bg-slate-900/80 p-6">
            <h2 class="font-display text-2xl font-bold text-white">Add Meeting</h2>
            <form method="POST" action="{{ route('admin.meetings.store') }}" class="mt-5 grid gap-4 sm:grid-cols-2">
                @csrf
                <input name="title" placeholder="Meeting title" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500 sm:col-span-2">
                <input name="meeting_date" type="date" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white">
                <input name="location" placeholder="Location" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500">
                <textarea name="summary" rows="4" placeholder="Summary" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500 sm:col-span-2"></textarea>
                <button class="rounded-2xl bg-amber-400 px-5 py-3 font-semibold text-slate-950 sm:col-span-2">Save Meeting</button>
            </form>
        </section>

        <section id="activity-management" class="rounded-3xl border border-white/10 bg-slate-900/80 p-6">
            <h2 class="font-display text-2xl font-bold text-white">Add Activity</h2>
            <form method="POST" action="{{ route('admin.activities.store') }}" class="mt-5 grid gap-4 sm:grid-cols-2">
                @csrf
                <input name="title" placeholder="Activity title" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500 sm:col-span-2">
                <input name="activity_date" type="date" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white">
                <input name="location" placeholder="Location" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500">
                <select name="status" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white">
                    <option value="planned">Planned</option>
                    <option value="ongoing">Ongoing</option>
                    <option value="completed">Completed</option>
                </select>
                <textarea name="description" rows="4" placeholder="Description" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500 sm:col-span-2"></textarea>
                <button class="rounded-2xl bg-fuchsia-400 px-5 py-3 font-semibold text-slate-950 sm:col-span-2">Save Activity</button>
            </form>
        </section>
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-2">
        <section class="rounded-3xl border border-white/10 bg-white/5 p-6">
            <h2 class="font-display text-2xl font-bold text-white">Recent Members</h2>
            <div class="mt-5 space-y-3">
                @forelse ($members as $member)
                    <div class="flex items-center justify-between gap-4 rounded-2xl border border-white/10 bg-slate-950/50 p-4">
                        <div class="flex items-center gap-3"><x-member-avatar :member="$member" size="h-10 w-10" /><div><p class="font-semibold text-white">{{ $member->full_name }}</p><p class="text-sm text-slate-400">{{ $member->matric_no }} · {{ $member->display_role }}</p></div></div>
                        <form method="POST" action="{{ route('admin.members.destroy', $member) }}" data-confirm="Delete {{ $member->full_name }}? This cannot be undone.">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-full border border-red-400/30 bg-red-400/10 px-4 py-2 text-sm font-medium text-red-200">Delete</button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">No members found.</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-3xl border border-white/10 bg-white/5 p-6">
            <h2 class="font-display text-2xl font-bold text-white">Records Overview</h2>
            <div class="mt-5 space-y-5">
                <div>
                    <p class="text-sm uppercase tracking-[0.24em] text-slate-400">Committee positions</p>
                    <div class="mt-3 space-y-3">
                        @forelse ($committeePositions as $position)
                            <div class="flex items-center justify-between gap-4 rounded-2xl border border-white/10 bg-slate-950/50 p-4">
                                <div>
                                    <p class="font-semibold text-white">{{ $position->title }}</p>
                                    <p class="text-sm text-slate-400">{{ ucfirst($position->category) }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.committee-positions.edit', $position) }}" class="rounded-full border border-cyan-400/30 bg-cyan-400/10 px-4 py-2 text-sm font-medium text-cyan-100">Edit</a>
                                    <form method="POST" action="{{ route('admin.committee-positions.destroy', $position) }}" data-confirm="Delete the {{ $position->title }} position? This cannot be undone.">@csrf @method('DELETE')<button class="rounded-full border border-red-400/30 bg-red-400/10 px-4 py-2 text-sm font-medium text-red-200">Delete</button></form>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400">No committee positions found.</p>
                        @endforelse
                    </div>
                </div>

                <div>
                    <p class="text-sm uppercase tracking-[0.24em] text-slate-400">Meetings</p>
                    <div class="mt-3 space-y-3">
                        @forelse ($meetings as $meeting)
                            <div class="flex items-center justify-between gap-4 rounded-2xl border border-white/10 bg-slate-950/50 p-4">
                                <div>
                                    <p class="font-semibold text-white">{{ $meeting->title }}</p>
                                    <p class="text-sm text-slate-400">{{ $meeting->meeting_date->format('d M Y') }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.meetings.edit', $meeting) }}" class="rounded-full border border-cyan-400/30 bg-cyan-400/10 px-4 py-2 text-sm font-medium text-cyan-100">Edit</a>
                                    <form method="POST" action="{{ route('admin.meetings.destroy', $meeting) }}" data-confirm="Delete {{ $meeting->title }}? This cannot be undone.">@csrf @method('DELETE')<button class="rounded-full border border-red-400/30 bg-red-400/10 px-4 py-2 text-sm font-medium text-red-200">Delete</button></form>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400">No meetings found.</p>
                        @endforelse
                    </div>
                </div>

                <div>
                    <p class="text-sm uppercase tracking-[0.24em] text-slate-400">Activities</p>
                    <div class="mt-3 space-y-3">
                        @forelse ($activities as $activity)
                            <div class="flex items-center justify-between gap-4 rounded-2xl border border-white/10 bg-slate-950/50 p-4">
                                <div>
                                    <p class="font-semibold text-white">{{ $activity->title }}</p>
                                    <p class="text-sm text-slate-400">{{ $activity->activity_date->format('d M Y') }} · {{ ucfirst($activity->status) }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.activities.edit', $activity) }}" class="rounded-full border border-cyan-400/30 bg-cyan-400/10 px-4 py-2 text-sm font-medium text-cyan-100">Edit</a>
                                    <form method="POST" action="{{ route('admin.activities.destroy', $activity) }}" data-confirm="Delete {{ $activity->title }}? This cannot be undone.">@csrf @method('DELETE')<button class="rounded-full border border-red-400/30 bg-red-400/10 px-4 py-2 text-sm font-medium text-red-200">Delete</button></form>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400">No activities found.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
