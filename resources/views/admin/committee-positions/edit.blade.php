@extends('layouts.app', ['title' => 'PRS NEXUS | Edit committee position'])

@section('content')
    <a href="{{ route('admin.committee-positions.index') }}" class="text-sm font-semibold text-blue-700 hover:underline">Back to committee positions</a>

    <section class="mx-auto mt-5 max-w-3xl ui-panel">
        <p class="text-sm font-semibold text-blue-700">Organization</p>
        <h1 class="mt-1 text-3xl font-bold text-slate-900">Edit committee position</h1>
        <p class="mt-2 text-sm leading-6 text-slate-600">Update the position details used across the PRS directory and member profiles.</p>

        <form method="POST" action="{{ route('admin.committee-positions.update', $committeePosition) }}" class="mt-8 space-y-6">
            @csrf
            @method('PUT')

            <section>
                <h2 class="text-lg font-semibold text-slate-900">Position details</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2"><x-form-input label="Position title" name="title" :value="$committeePosition->title" :required="true" /></div>
                    <x-form-input label="Category" name="category" :value="$committeePosition->category" :required="true" help="For example, executive or project team." />
                    <x-form-input label="Display order" name="sort_order" type="number" :value="$committeePosition->sort_order" :required="true" min="0" help="Lower numbers appear first." />
                    <div class="sm:col-span-2"><label for="description" class="ui-label">Description <span class="font-normal text-slate-500">(optional)</span></label><textarea id="description" name="description" rows="5" class="ui-textarea">{{ old('description', $committeePosition->description) }}</textarea>@error('description')<p class="ui-error-text">{{ $message }}</p>@enderror</div>
                </div>
            </section>

            <div class="flex flex-wrap gap-3 border-t border-slate-200 pt-6">
                <button class="ui-button-primary">Save changes</button>
                <a href="{{ route('admin.committee-positions.index') }}" class="ui-button-secondary">Cancel</a>
            </div>
        </form>
    </section>
@endsection
