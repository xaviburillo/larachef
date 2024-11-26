@php
    $filledStar = "<i class='bi bi-star-fill'></i>";
    $emptyStar = "<i class='bi bi-star'></i>";
@endphp
<div id="estrellas">
    @if ($rating)
        @for ($i=1; $i<=5; $i++)
            @if ($i <= round($rating))
                {!! $filledStar !!}
            @else                
                {!! $emptyStar !!}
            @endif
        @endfor
        @if ($count != null)
            <span class="ps-1 text-dark">
                @if ($extended)
                    de {{ $count." ".$tipo }}
                @else                
                    ({{ $count }})
                @endif
            </span>
        @endif
    @else
        Sin valoraciones
    @endif
</div>