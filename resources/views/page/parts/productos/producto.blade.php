<div class="wrapper-producto">
    <div class="container pb-4 pt-2 navegador text-uppercase">
        <a href="{{ URL::to('productos') }}">Productos</a>
        @foreach($datos["nombres"] AS $n)
            @if(isset($n["parte"]))
                <a href="{{ URL::to('productos/' . $n['id']) . '/parte' }}">{{ $n["nombre"] }}</a>
            @else
                <a href="{{ URL::to('productos/' . $n['id']) }}">{{ $n["nombre"] }}</a>
            @endif
        @endforeach
    </div>
    <div class="container pb-5">
        <div class="row">
            <div class="col-12 col-md-4">
                <button class="btn text-uppercase d-block d-sm-none rounded-0 mb-2" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" style="background: #0099D6">
                    categorias<i class="fas fa-sort-amount-down ml-2"></i>
                </button>
                <div class="sidebar collapse dont-collapse-sm" id="collapseExample">
                    <div class="sidebar accordion" id="accordionExample">
                        @foreach($datos["menu"] AS $dato)
                        <div class="accordion md-accordion border-0" id="accordionEx" role="tablist" aria-multiselectable="true">
                            <div class="card border-0">
                                <div class="card-header bg-white p-0 border-bottom" role="tab" id="Hproductos{{$dato['id']}}">
                                    <h5 style="color:{{$dato['color']}}; cursor: pointer" class="mb-0 parte py-3" data-parent="#accordionEx" data-toggle="collapse" data-target="#productos{{$dato['id']}}" aria-expanded="@if(isset($dato['active'])) true @else false @endif" aria-controls="productos{{$dato['id']}}">
                                        <a class="" href="{{ URL::to('productos/' . $dato['id']) }}">
                                            {{$dato["nombre"]}}
                                        </a>
                                        <i class="fas fa-angle-down rotate-icon float-right"></i>
                                    </h5>
                                </div>
                                <div id="productos{{$dato['id']}}" class="collapse @if(isset($dato['active'])) show @endif" role="tabpanel" aria-labelledby="Hproductos{{$dato['id']}}" data-parent="#accordionEx">
                                    <div class="card-body p-0">
                                    @if(count($dato["hijos"]) > 0)
                                        <ul data-nivel="{{$dato['tipo']}}" class="list-group list-group-flush subPartes">
                                        @foreach ($dato["hijos"] AS ${"dato_". $dato["id"]})
                                            @include('page.parts.productos._menuItem', ["dato" => ${"dato_". $dato["id"]}])
                                        @endforeach
                                        </ul>
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-8">
                <div class="row">
                    <div class="col-12 col-md-6">
                        @php
                        $codigo_ima = $datos['producto']["codigo_ima"];
                        $image = "IMAGEN/{$codigo_ima[0]}/{$codigo_ima}.jpg";
                        
                        @endphp
                        <img src="{{ asset($image) }}" onError="this.src='{{ asset('images/general/no-img.png') }}'" class="w-100 border" />
                    </div>
                    <div class="col-12 col-md-6">
                        <p class="codigo mb-1">{{ $datos["producto"]["stmpdh_art"] }}</p>
                        <p class="para text-uppercase mb-1">{{ $datos["producto"]->modelo->marca["web_marcas"] }}</p>
                        <div class="title">{!! $datos["producto"]["stmpdh_tex"] !!}</div>
                        <div class="table-responsive">
                            <table class="table w-100">
                                <tbody>
                                    <tr>
                                        <td class="title">Código</td>
                                        <td>{{ $datos["producto"]["stmpdh_art"] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="title">Marca</td>
                                        <td>{{ $datos["producto"]->modelo->marca["web_marcas"] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="title">Modelo</td>
                                        <td>{{ $datos["producto"]->modelo["modelo_y_a"] }}</td>
                                    </tr>
                                    {{--<tr>
                                        <td class="title">Origen</td>
                                        <td>{!! $datos["producto"]->origen->nombre() !!}</td>
                                    </tr>--}}
                                    <tr>
                                        <td class="title">Cantidad Envasada</td>
                                        <td>{{ $datos["producto"]["cantminvta"] == 1 ? $datos["producto"]["cantminvta"] . " unidad" : $datos["producto"]["cantminvta"] . " unidades"}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{--<div class="row">
                            @if(!empty($datos["producto"]["catalogo"]))
                            <div class="col-12 col-md-6">
                                <a download href="{{ asset($datos['producto']['catalogo']) }}" class="btn btn-block text-uppercase text-center"><i class="fas fa-download mr-1"></i>catálogo</a>
                            </div>
                            @endif
                            @if(!empty($datos["producto"]["mercadolibre"]))
                            <div class="col-12 col-md-6">
                                <a href="{{ asset($datos['producto']['mercadolibre']) }}" target="blank" class="btn btn-block btn-ml text-uppercase text-center"><img src="{{ asset('images/general/ml.fw.png')}}" class="d-block mx-auto" alt="Mercadolibre"></a>
                            </div>
                            @endif
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>