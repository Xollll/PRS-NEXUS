@props(['title' => 'Nothing to show yet', 'description' => null])

<div {{ $attributes->class(['ui-empty-state']) }}>
    <svg class="mx-auto h-8 w-8 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5V6.375A3.375 3.375 0 0 0 11.25 3h-3A3.375 3.375 0 0 0 4.875 6.375V8.25h-1.5A3.375 3.375 0 0 0 0 11.625v6.75a2.625 2.625 0 0 0 2.625 2.625h14.25a2.625 2.625 0 0 0 2.625-2.625V16.5" /></svg>
    <h3 class="mt-3 font-semibold text-slate-900">{{ $title }}</h3>
    @if($description)
        <p class="mt-1 text-sm text-slate-500">{{ $description }}</p>
    @endif
    @if(trim((string) $slot) !== '')
        <div class="mt-4">{{ $slot }}</div>
    @endif
</div>
