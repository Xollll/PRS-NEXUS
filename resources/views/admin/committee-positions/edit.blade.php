@extends('layouts.app', ['title' => 'SiswaSphere | Edit Committee Position'])

@section('content')
    <section class="mx-auto max-w-2xl rounded-3xl border border-white/10 bg-slate-900/80 p-6 lg:p-8">
        <p class="text-sm uppercase tracking-[0.3em] text-cyan-300/80">Admin Management</p>
        <h1 class="font-display mt-3 text-3xl font-bold text-white">Edit committee position</h1>
        <form method="POST" action="{{ route('admin.committee-positions.update', $committeePosition) }}" class="mt-7 grid gap-4 sm:grid-cols-2">
            @csrf @method('PUT')
            <input name="title" value="{{ old('title', $committeePosition->title) }}" required placeholder="Position title" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white sm:col-span-2">
            <input name="category" value="{{ old('category', $committeePosition->category) }}" required placeholder="Category" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white">
            <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $committeePosition->sort_order) }}" required placeholder="Sort order" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white">
            <textarea name="description" rows="5" placeholder="Description" class="rounded-2xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white sm:col-span-2">{{ old('description', $committeePosition->description) }}</textarea>
            <div class="flex gap-3 sm:col-span-2"><button class="rounded-2xl bg-cyan-400 px-5 py-3 font-semibold text-slate-950">Save Changes</button><a href="{{ route('admin.dashboard') }}" class="rounded-2xl border border-white/10 px-5 py-3 font-medium text-white">Cancel</a></div>
        </form>
    </section>
@endsection
