@props(['type'])
<div
    class="alert-{{$type}}"
    style="z-index: 200"
>
    {{$slot}}
</div>