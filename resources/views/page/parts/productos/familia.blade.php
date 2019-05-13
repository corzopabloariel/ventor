<div class="wrapper-producto">
    <div class="container pb-4 pt-2 navegador">
        <a href="{{ URL::to('productos') }}">Productos</a>
        @foreach($datos["nombres"] AS $n)
            <a href="{{ URL::to('productos/' . $n['id']) }}">{{ $n["nombre"] }}</a>
        @endforeach
    </div>
    <div class="container pb-5">
        <div class="row">
            <div class="col-md-5 col-lg-4">
                <button class="btn text-uppercase d-block d-sm-none rounded-0 mb-2" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" style="background: #0099D6">
                    categorias<i class="fas fa-sort-amount-down ml-2"></i>
                </button>
                <div class="sidebar collapse dont-collapse-sm" id="collapseExample">
                    <div class="sidebar">
                        @foreach($datos["menu"] AS $dato)
                            <h5 class="title mb-1 position-relative @isset($dato['active']) active @endisset" data-id="{{$dato['id']}}" style="color:{{$dato['color']}}">
                                <a href="{{ URL::to('productos/'. $dato['id']) }}">{{$dato["nombre"]}}</a>
                                <i data-tipo="close" class="fas fa-angle-down"></i>
                                <i data-tipo="open" class="fas fa-angle-right"></i>
                            </h5>
                            @if(count($dato["hijos"]) > 0)
                                <ul data-nivel="{{$dato['tipo']}}" class="list-group list-group-flush">
                                @foreach ($dato["hijos"] AS ${"dato_". $dato["id"]})
                                    @include('page.parts.productos._menuItem', ["dato" => ${"dato_". $dato["id"]}])
                                @endforeach
                                </ul>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-7 col-lg-8">
                @if(count($datos["categorias"]) == 0)
                <div class="row categorias"></div>
                @else
                <div class="row categorias">
                    @foreach($datos["categorias"] AS $c)
                        <a href="{{ URL::to('productos/' . $c['id']) }}" class="col-12 col-md-6 col-lg-4">
                            <div>
                                <img src="{{ asset($c['image']) }}" onError="this.src='{{ asset('images/general/no-img.png') }}'" class="w-100" />
                            </div>
                            <p class="mb-0">{{ $c["nombre"] }}</p>
                        </a>
                    @endforeach
                </div>
                @endif
                @if(count($datos["productos"]) == 0)
                <div class="row productos"></div>
                @else
                <div class="row productos">
                    @foreach($datos["productos"] AS $c)
                        <a href="{{ URL::to('producto/' . $c['link']) }}" class="col-12 col-md-6 col-lg-4">
                            <div>
                                <img src="{{ asset($c['image']) }}" onError="this.src='{{ asset('images/general/no-img.png') }}'" class="w-100" />
                            </div>
                            <p class="mb-0">{{ $c["codigo"] }}</p>
                            <p class="mb-1 text-truncate">{{ $c["modelo"] }}</p>
                            {!! $c["nombre"] !!}
                        </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>