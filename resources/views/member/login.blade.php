@extends('layouts.app', ['title' => 'SiswaSphere | Member Login'])

@section('content')
    <section class="mx-auto max-w-lg rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl shadow-black/20 backdrop-blur">
        <p class="text-sm uppercase tracking-[0.3em] text-cyan-300/80">Member Portal</p>
        <h1 class="font-display mt-3 text-4xl font-bold text-white">Sign in to your member space.</h1>
        <p class="mt-3 text-slate-300">Use the email and password issued with your organization membership.</p>

        <form method="POST" action="{{ route('member.authenticate') }}" class="mt-8 space-y-4">
            @csrf
            <div>
                <label class="mb-2 block text-sm text-slate-300">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white" autocomplete="email">
            </div>
            <div>
                <label class="mb-2 block text-sm text-slate-300">Password</label>
                <input type="password" name="password" required class="w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white" autocomplete="current-password">
            </div>
            <button class="w-full rounded-2xl bg-cyan-400 px-5 py-3 font-semibold text-slate-950 transition hover:bg-cyan-300">Member Login</button>
        </form>
    </section>
@endsection
