<div class="wrapper-producto">
    <div class="container pb-4 pt-2 navegador">
        <a href="{{ URL::to('productos') }}">Productos</a>
        @foreach($datos["nombres"] AS $n)
            <a href="{{ URL::to('productos/' . $n['id']) }}">{{ $n["nombre"] }}</a>
        @endforeach
        @php
        $nombre = $datos["producto"]["nombre"];
        $nombre = str_replace("<br />"," ",$nombre);
        $nombre = strip_tags($nombre);
        @endphp
        <a>{{ $nombre }}</a>
    </div>
    <div class="container pb-5">
        <div class="row">
            <div class="col-md-4">
                <div class="sidebar" id="collapseExample">
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
            
            <div class="col-md-8">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <img src="{{ asset($datos['producto']['image']) }}" onError="this.src='{{ asset('images/general/no-img.png') }}'" class="w-100 border" />
                    </div>
                    <div class="col-12 col-md-6">
                        <p class="codigo mb-1">{{ $datos["producto"]["codigo"] }}</p>
                        <p class="para text-uppercase mb-1">para {{ $datos["producto"]->marca->getNombreEnteroAttribute(0) }}</p>
                        <div class="title">{!! $datos["producto"]["nombre"] !!}</div>
                        <div class="table-responsive">
                            <table class="table w-100">
                                <tbody>
                                    <tr>
                                        <td class="title">Código</td>
                                        <td>{{ $datos["producto"]["codigo"] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="title">Marca</td>
                                        <td>{{ $datos["producto"]->marca->padre["nombre"] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="title">Modelo</td>
                                        <td>{{ $datos["producto"]->marca["nombre"] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="title">Origen</td>
                                        <td>{!! $datos["producto"]->origen->nombre() !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="title">Cantidad Envasada</td>
                                        <td>{{ $datos["producto"]["cantidad"] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <button class="btn btn-block text-uppercase text-center"><i class="fas fa-download mr-1"></i>catálogo</button>
                            </div>
                            <div class="col-12 col-md-6">
                                <button class="btn btn-block btn-ml text-uppercase text-center"><img src="{{ asset('images/general/ml.fw.png')}}" class="d-block mx-auto" alt="Mercadolibre"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>