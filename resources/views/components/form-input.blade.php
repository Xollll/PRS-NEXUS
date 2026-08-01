@props(['label', 'name', 'type' => 'text', 'help' => null, 'required' => false, 'value' => null])

@php
    $hasError = $errors->has($name);
    $helpId = $name.'-help';
    $errorId = $name.'-error';
    $describedBy = collect([$help ? $helpId : null, $hasError ? $errorId : null])->filter()->implode(' ');
@endphp

<div><label for="{{ $name }}" class="ui-label">{{ $label }}@if($required)<span class="text-red-600"> *</span>@endif</label><input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $value) }}" @required($required) @if($hasError) aria-invalid="true" @endif @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif {{ $attributes->class(['ui-input']) }}>@if($help)<p id="{{ $helpId }}" class="ui-help-text">{{ $help }}</p>@endif @error($name)<p id="{{ $errorId }}" class="ui-error-text">{{ $message }}</p>@enderror</div>
