@props(['type' => 'success', 'messages' => null])

@php
    $messages ??= $type === 'success' && session('success') ? [session('success')] : [];
    $styles = ['success' => 'ui-alert-success', 'error' => 'ui-alert-error', 'warning' => 'ui-alert-warning', 'info' => 'ui-alert-info'];
@endphp

@if (count($messages))
    <div {{ $attributes->class(['ui-alert', $styles[$type] ?? $styles['info']]) }} role="{{ $type === 'error' ? 'alert' : 'status' }}" aria-live="{{ $type === 'error' ? 'assertive' : 'polite' }}">
        @if (count($messages) === 1)<p>{{ $messages[0] }}</p>@else<p class="font-semibold">Please review the following:</p><ul class="mt-1 list-disc space-y-1 pl-5">@foreach ($messages as $message)<li>{{ $message }}</li>@endforeach</ul>@endif
    </div>
@endif
