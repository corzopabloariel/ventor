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

<div class="wrapper-empresa">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-7 col-lg-7 principal">
                {!! $datos["contenido"]["texto"] !!}
            </div>
            <div class="col-12 col-md-5 col-lg-5">
                <table class="w-100">
                @foreach($datos["contenido"]["numeros"] AS $n)
                    <tr>
                        <td class="title">
                            {{ $n["N"] }}
                        </td>
                        <td>
                            {{ $n["T"] }}
                        </td>
                    </tr>
                @endforeach
                </table>
            </div>
        </div>

        <div class="row timeline my-5">
            <div class="col-12 d-flex justify-content-center">
                <div>
                    <div class="d-flex justify-content-around" style="width:77vh">
                        @foreach($datos["contenido"]["fechas"] AS $f => $t)
                        <div class="input">
                            <span data-year="{{ $f }}"></span>
                        </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-3" style="width:77vh">
                        @foreach($datos["contenido"]["fechas"] AS $f => $t)
                        <div class="text text-center">
                            {!! $t !!}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="row mision-vision">
            <div class="col-12 col-md-6 d-flex align-items-stretch">
                <div class="p-4 shadow-sm text-center">
                    <p class="mb-0 title">{!! $datos["contenido"]["vision"]["TIT"] !!}</p>
                    <hr/>
                    {!! $datos["contenido"]["vision"]["TEX"] !!}
                </div>
            </div>
            <div class="col-12 col-md-6 d-flex align-items-stretch">
                <div class="p-4 shadow-sm text-center">
                    <p class="mb-0 title">{!! $datos["contenido"]["mision"]["TIT"] !!}</p>
                    <hr/>
                    {!! $datos["contenido"]["mision"]["TEX"] !!}
                </div>
            </div>
        </div>
    </div>
</div>