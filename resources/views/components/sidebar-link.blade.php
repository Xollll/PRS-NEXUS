@props(['href', 'active' => false])

<a href="{{ $href }}" @class(['ui-nav-link', 'ui-nav-link-active' => $active, 'mt-1']) @if($active) aria-current="page" @endif>{{ $slot }}</a>
