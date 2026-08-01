@extends('layouts.app', ['title' => 'SiswaSphere | Administrator sign in'])

@section('content')
    <section class="mx-auto grid max-w-5xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm lg:grid-cols-[0.9fr_1.1fr]">
        <div class="bg-blue-700 p-7 text-white sm:p-10 lg:p-12">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white text-sm font-bold tracking-wide text-blue-700">SS</div>
            <p class="mt-10 text-sm font-semibold text-blue-100">PRS administration</p>
            <h1 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">A clear view of your student community.</h1>
            <p class="mt-4 max-w-sm text-sm leading-6 text-blue-100">Securely manage PRS members, committee roles, meetings, and activities from the SiswaSphere administration portal.</p>
            <div class="mt-10 space-y-4 border-t border-blue-400/40 pt-6 text-sm text-blue-50">
                <div><p class="font-semibold text-white">For authorized PRS administrators</p><p class="mt-1 leading-6 text-blue-100">Use the email address and password assigned to your administrator account.</p></div>
                <a href="{{ route('home') }}" class="inline-flex font-semibold text-white underline decoration-blue-300 underline-offset-4 hover:decoration-white">Return to the public website</a>
            </div>
        </div>

        <div class="p-7 sm:p-10 lg:p-12">
            <p class="text-sm font-semibold text-blue-700">Administrator sign in</p>
            <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">Welcome back</h2>
            <p class="mt-2 max-w-md text-sm leading-6 text-slate-600">Enter your account details to access the administration portal.</p>

            @php
                $emailInvalid = $errors->has('email');
                $passwordInvalid = $errors->has('password');
                $passwordDescribedBy = $passwordInvalid ? 'password-error' : null;
            @endphp

            <form method="POST" action="{{ route('admin.authenticate') }}" class="mt-8 space-y-5">
                @csrf
                <div>
                    <label for="email" class="ui-label">Administrator email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@upsi.edu.my" aria-invalid="{{ $emailInvalid ? 'true' : 'false' }}" aria-describedby="{{ $emailInvalid ? 'email-help email-error' : 'email-help' }}" class="{{ $emailInvalid ? 'ui-input border-red-500 focus:border-red-500 focus:ring-red-500/20' : 'ui-input' }}">
                    <p id="email-help" class="ui-help-text">Use the email linked to your administrator account.</p>
                    @error('email')
                        <p id="email-error" class="ui-error-text" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="ui-label">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" aria-invalid="{{ $passwordInvalid ? 'true' : 'false' }}" aria-describedby="{{ $passwordDescribedBy }}" class="{{ $passwordInvalid ? 'ui-input border-red-500 focus:border-red-500 focus:ring-red-500/20' : 'ui-input' }}">
                    @error('password')
                        <p id="password-error" class="ui-error-text" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="ui-button-primary w-full">Sign in to administration</button>
            </form>

            <div class="mt-8 border-t border-slate-200 pt-6"><p class="text-sm text-slate-600">Looking for your PRS member space? <a href="{{ route('member.login') }}" class="font-semibold text-blue-700 hover:text-blue-800 hover:underline">Go to member login</a>.</p></div>
        </div>
    </section>
@endsection
