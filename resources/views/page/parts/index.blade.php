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
                    <div class="texto text-left">
                        {!! $datos['slider'][$i]['texto'] !!}
                        @if(!empty( $datos['slider'][$i]['link'] ))
                        <a href="{{ URL::to($datos['slider'][$i]['link']) }}" style="background: #C1C0BD; padding: 10px 20px;" class="btn mt-2 text-white text-uppercase">ver {{ $datos['slider'][$i]['link'] }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>
<div class="wrapper-novedades py-5">
    <div class="container">
        <h3 class="title text-uppercase text-center mb-4">¡novedades!</h3>
        <div class="row productos">
            @foreach($datos["productos"] AS $c)
                <a href="{{ URL::to('producto/' . $c['link']) }}" class="col-12 col-md-4">
                    <div>
                        <img src="{{ asset($c['image']) }}" onError="this.src='{{ asset('images/general/no-img.png') }}'" class="w-100" />
                    </div>
                    {!! $c["nombre"] !!}
                </a>
            @endforeach
        </div>
    </div>
</div>
<div class="wrapper-categorias">
    <div class="container">
        <h3 class="title text-uppercase text-center">categorias</h3>
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <div class="row justify-content-center buscador">
                    <div class="col-12 col-md-6">
                        <form class="position-relative d-flex" action="{{ url('/buscador/home') }}" method="post">
                            @csrf
                            <button type="submit" class="btn"><i class="fas fa-search"></i></button>
                            <input placeholder="Buscar producto..." type="text" name="" id="" class="form-control">
                        </form>
                    </div>
                </div>
                <div class="row justify-content-center">
                    @foreach($datos['categorias'] AS $c)
                    <div class="col-12 col-md-4 col-lg-3 my-3 wrapper-link">
                        <a href="{{ URL::to('productos/' . $c['id']) }}">
                            <div>
                                <img style="filter:{{ $c['hsl'] }}" src="{{ asset($c['image']) }}" onError="this.src='{{ asset('images/general/no-img.png') }}'" alt="{{ $c['nombre'] }}">
                            </div>
                            <p class="mb-0 text-center">{{ $c['nombre'] }}</p>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>