<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SiswaSphere' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,700|inter:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 antialiased">
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
        <div class="absolute -left-32 top-0 h-96 w-96 rounded-full bg-amber-500/20 blur-3xl"></div>
        <div class="absolute right-0 top-48 h-96 w-96 rounded-full bg-cyan-500/20 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/3 h-72 w-72 rounded-full bg-fuchsia-500/10 blur-3xl"></div>
    </div>

    <header class="relative z-10 border-b border-white/10 bg-slate-950/70 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-400 to-orange-600 font-bold text-slate-950 shadow-lg shadow-amber-500/20">SS</div>
                <div>
                    <p class="font-display text-lg font-bold tracking-wide">SiswaSphere</p>
                    <p class="text-xs uppercase tracking-[0.28em] text-slate-400">UPSI Club Administration</p>
                </div>
            </a>

            <nav class="flex items-center gap-2 text-sm">
                <a class="rounded-full px-4 py-2 text-slate-300 transition hover:bg-white/5 hover:text-white" href="{{ route('home') }}">Home</a>
                <a class="rounded-full px-4 py-2 text-slate-300 transition hover:bg-white/5 hover:text-white" href="{{ route('directory') }}">Directory</a>
                @if(session('admin_user_id'))
                    <a class="rounded-full px-4 py-2 text-slate-300 transition hover:bg-white/5 hover:text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="rounded-full border border-amber-400/30 bg-amber-400/10 px-4 py-2 font-medium text-amber-200 transition hover:bg-amber-400/20">Logout</button>
                    </form>
                @else
                    <a class="rounded-full border border-white/10 bg-white/5 px-4 py-2 font-medium text-white transition hover:bg-white/10" href="{{ route('admin.login') }}">Admin Login</a>
                @endif
            </nav>
        </div>
    </header>

    <main class="relative z-10 mx-auto max-w-7xl px-6 py-10 lg:px-8 lg:py-14">
        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-400/30 bg-emerald-400/10 px-5 py-4 text-emerald-100">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-red-400/30 bg-red-400/10 px-5 py-4 text-red-100">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>