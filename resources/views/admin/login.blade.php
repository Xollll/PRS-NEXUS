@extends('layouts.app', ['title' => 'SiswaSphere | Admin Login'])

@section('content')
    <section class="mx-auto max-w-lg rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl shadow-black/20 backdrop-blur">
        <p class="text-sm uppercase tracking-[0.3em] text-amber-300/80">Admin Access</p>
        <h1 class="font-display mt-3 text-4xl font-bold text-white">Sign in to manage SiswaSphere.</h1>
        <p class="mt-3 text-slate-300">Use the seeded admin account to access the dashboard.</p>

        @if($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-2 mb-4">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.authenticate') }}" class="mt-8 space-y-4">
            @csrf
            <div>
                <label class="mb-2 block text-sm text-slate-300">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500" placeholder="admin@siswasphere.test">
            </div>
            <div>
                <label class="mb-2 block text-sm text-slate-300">Password</label>
                <input type="password" name="password" class="w-full rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white placeholder:text-slate-500" placeholder="password">
            </div>
            <button class="w-full rounded-2xl bg-amber-400 px-5 py-3 font-semibold text-slate-950 transition hover:bg-amber-300">Login</button>
        </form>
    </section>
@endsection