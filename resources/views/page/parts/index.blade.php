<div id="carouselExampleIndicators" class="carousel slide wrapper-slider" data-ride="carousel">
    <ol class="carousel-indicators">
        @for($i = 0 ; $i < count($datos['slider']) ; $i++)
            @if($i == 0)
                <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}" class="active"></li>
            @else
                <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}"></li>
            @endif
        @endfor
    </ol>
    <div class="carousel-inner">
        @for($i = 0 ; $i < count($datos['slider']) ; $i++)
        @if($i == 0)
            <div class="carousel-item active">
        @else
            <div class="carousel-item">
        @endif
            <img class="d-block w-100" src="{{asset('' . $datos['slider'][$i]['image'])}}" >
            <div class="carousel-caption position-absolute w-100 h-100" style="top: 0; left: 0;">
                <div class="container position-relative h-100 d-flex align-items-center">
                    <div class="texto">
                        {!! $datos['slider'][$i]['texto'] !!}
                        @if(!empty( $datos['slider'][$i]['link'] ))
                        <button style="background: #C1C0BD; padding: 10px 20px;" class="btn d-block text-white text-uppercase">ver {{ $datos['slider'][$i]['link'] }}</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>

<div class="wrapper-categorias">
    <div class="container">
        <h3 class="title text-uppercase text-center">categorias</h3>
        <div class="row justify-content-center">
            @foreach($datos['categorias'] AS $c)
            <div class="col-12 col-md-4 col-lg-3 my-3">
                <img style="filter:{{ $c['hsl'] }}" src="{{ asset($c['image']) }}" onError="this.src='{{ asset('images/general/no-img.png') }}'" alt="{{ $c['nombre'] }}">
                <p class="mb-0 text-center">{{ $c['nombre'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>