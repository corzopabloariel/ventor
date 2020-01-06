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
            @foreach($datos["novedades"] AS $c)
                <a id="nov_{{$c['id']}}" onclick="event.preventDefault(); descargar(this);" data-tipo="privado"  @if($datos["logueado"]) href="{{ asset($c['documento']) }}" target="blank" @else href="" @endif class="col-12 col-md-4">
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
                        <form class="position-relative d-flex" action="{{ url('/buscador/body') }}" method="post">
                            @csrf
                            <button type="submit" class="btn"><i class="fas fa-search"></i></button>
                            <input placeholder="Buscar producto..." type="text" name="buscar" id="" class="form-control">
                        </form>
                    </div>
                </div>
                <div class="row justify-content-center">
                    @foreach($datos['categorias'] AS $c)
                    <div class="col-12 col-md-4 col-lg-3 my-3 wrapper-link wow zoomIn">
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

@push("scripts_distribuidor")
<script>
    const logueado = parseInt(@json($datos["logueado"]));
    descargar = function(t) {
        console.log($(t).attr("href"))
        if($(t).data("tipo") == "privado" && !logueado) {
            if(window.alertt === undefined) {
                window.alertt = 1;
                alertify.notify('Por favor, ingrese a su cuenta para poder acceder a este archivo', 'error', 30, function() {
                    delete window.alertt;
                });
            }
        }
        if($(t).attr("href") == "" || $(t).attr("href") == "http://ventor.com.ar/descargas" || $(t).next().attr("href") == "http://www.ventor.com.ar/descargas" || t.href == "https://ventor.com.ar" || t.href == "https://www.ventor.com.ar")
          return false;

        $(t).removeAttr("onclick");

        setTimeout(() => {
            document.getElementById(t.id).click();
            $(t).attr("onclick","event.preventDefault(); descargar(this);");
        }, 500);
        
    };
    
    linkActive = function(t) {
        if(logueado) {
            let doc = $(t).val();
            $(t).removeAttr("disabled");
            $(t).attr("href",doc);
            $(t).click();
        } else {
            if(window.alertt === undefined) {
                window.alertt = 1;
                alertify.notify('Por favor, ingrese a su cuenta para poder acceder a este archivo', 'error', 30, function() {
                    delete window.alertt;
                });
            }
        }
    }
</script>
@endpush