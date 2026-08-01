@extends('layouts.app', ['title' => 'SiswaSphere | My Profile'])

@section('content')
    <section class="mx-auto max-w-2xl rounded-3xl border border-white/10 bg-slate-900/80 p-6 lg:p-8">
        <p class="text-sm uppercase tracking-[0.3em] text-cyan-300/80">Member Portal</p>
        <h1 class="font-display mt-3 text-3xl font-bold text-white">Edit my profile</h1>
        <p class="mt-3 text-slate-300">Your matric number, membership status, and committee position are managed by an administrator.</p>

        <form method="POST" action="{{ route('member.profile.update') }}" enctype="multipart/form-data" class="mt-7 grid gap-4 sm:grid-cols-2">
            @csrf @method('PUT')
            <div class="sm:col-span-2"><label class="mb-2 block text-sm text-slate-300">Profile photo</label><div class="flex items-center gap-4"><x-member-avatar :member="$member" size="h-16 w-16" /><input type="file" name="avatar" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-slate-300 file:mr-4 file:rounded-full file:border-0 file:bg-cyan-400 file:px-4 file:py-2 file:font-semibold file:text-slate-950"></div><p class="mt-2 text-xs text-slate-400">JPG, PNG, or WebP; maximum 2 MB.</p></div>
            <div class="sm:col-span-2"><label class="mb-2 block text-sm text-slate-300">Email</label><input type="email" name="email" value="{{ old('email', $member->email) }}" required class="w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white"></div>
            <div><label class="mb-2 block text-sm text-slate-300">Phone</label><input name="phone" value="{{ old('phone', $member->phone) }}" class="w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white"></div>
            <div><label class="mb-2 block text-sm text-slate-300">Programme</label><input name="programme" value="{{ old('programme', $member->programme) }}" class="w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white"></div>
            <div><label class="mb-2 block text-sm text-slate-300">New password</label><input type="password" name="password" class="w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white" autocomplete="new-password"></div>
            <div><label class="mb-2 block text-sm text-slate-300">Confirm new password</label><input type="password" name="password_confirmation" class="w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white" autocomplete="new-password"></div>
            <p class="text-sm text-slate-400 sm:col-span-2">Leave the password fields blank to keep your current password.</p>
            <div class="flex gap-3 sm:col-span-2"><button class="rounded-2xl bg-cyan-400 px-5 py-3 font-semibold text-slate-950">Save Profile</button><a href="{{ route('member.dashboard') }}" class="rounded-2xl border border-white/10 px-5 py-3 font-medium text-white">Cancel</a></div>
        </form>
    </section>
@endsection
