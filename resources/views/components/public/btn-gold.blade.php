@props(['href' => null, 'type' => 'button'])

@php
    $style =
        'display:block; width:100%; margin-top:16px; background:#c9a227; color:#0b0f14; padding:12px 14px; border-radius:10px; font-weight:600; text-align:center; box-shadow:0 8px 20px rgba(0,0,0,.15); border:1px solid rgba(0,0,0,.12); transition:0.2s;';
    $on = "this.style.background='#d4af37'";
    $off = "this.style.background='#c9a227'";
@endphp

@if ($href)
    <a href="{{ $href }}" style="{{ $style }}" onmouseover="{{ $on }}"
        onmouseout="{{ $off }}">
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" style="{{ $style }}" onmouseover="{{ $on }}"
        onmouseout="{{ $off }}">
        {{ $slot }}
    </button>
@endif
