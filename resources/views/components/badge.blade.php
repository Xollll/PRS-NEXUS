@props(['variant' => 'info'])

<span {{ $attributes->class(['ui-badge', 'ui-badge-'.$variant]) }}>{{ $slot }}</span>
