<div class="wrapper-producto">
    <div class="container py-5">
        <div class="row productos">
            @if(count($datos["productos"]) == 0)
            <div class="col-12">
                <p class="mb-0 text-center title text-uppercase">Sin resultado</p>
            </div>
            @else
                @foreach($datos["productos"] AS $c)
                    <a href="{{ URL::to('producto/' . $c['id']) }}" class="col-12 mb-2 col-md-6 col-lg-3">
                        <div>
                            @php
                            $codigo_ima = $c["codigo_ima"];
                            $image = "IMAGEN/{$codigo_ima[0]}/{$codigo_ima}.jpg";
                            
                            @endphp
                            <img src="{{ asset($image) }}" onError="this.src='{{ asset('images/general/no-img.png') }}'" class="w-100" />
                        </div>
                        <p class="mb-0">{{ $c["stmpdh_art"] }}</p>
                        <p class="mb-1 text-truncate">{{ $c->modelo["modelo_y_a"] }}</p>
                        <p class="mb-0" style="height: 66px; overflow: hidden;">{{ $c["stmpdh_tex"] }}</p>
                    </a>
                @endforeach
            @endif
        </div>

        <div class="row d-flex justify-content-center">
            @if(isset($datos["paraID"]))
                {{ $datos["productos"]->appends( [ "para" => $datos["paraID"] ] )->links() }}
            @else
                {{ $datos["productos"]->links() }}
            @endif
        </div>
        
    </div>
</div>
@push("scripts_distribuidor")

@endpush