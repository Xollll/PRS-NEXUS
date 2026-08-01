@props(['member', 'size' => 'h-12 w-12', 'class' => ''])

@php
    $nameParts = preg_split('/\s+/', trim($member->full_name), -1, PREG_SPLIT_NO_EMPTY);
    $initials = collect($nameParts)->take(1)->map(fn ($part) => mb_substr($part, 0, 1));

    if (count($nameParts) > 1) {
        $initials->push(mb_substr(end($nameParts), 0, 1));
    }
@endphp

@if ($member->avatar_path)
    <img src="{{ '/storage/'.$member->avatar_path }}" alt="Profile photo of {{ $member->full_name }}" class="{{ $size }} {{ $class }} shrink-0 rounded-full object-cover ring-1 ring-slate-200" loading="lazy">
@else
    <div class="{{ $size }} {{ $class }} flex shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-700 ring-1 ring-blue-200" role="img" aria-label="{{ $member->full_name }}">
        {{ $initials->join('') }}
    </div>
@endif
