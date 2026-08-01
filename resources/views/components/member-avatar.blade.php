@props(['member', 'size' => 'h-12 w-12'])

@if ($member->avatar_path)
    <img src="{{ '/storage/'.$member->avatar_path }}" alt="{{ $member->full_name }}" class="{{ $size }} shrink-0 rounded-2xl object-cover ring-1 ring-white/15">
@else
    <div class="{{ $size }} flex shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-400 to-blue-600 font-display font-bold text-slate-950">
        {{ strtoupper(substr($member->full_name, 0, 1)) }}
    </div>
@endif
