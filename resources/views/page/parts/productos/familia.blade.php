<div class="wrapper-producto">
    <div class="container pb-4 pt-2 navegador text-uppercase">
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
                <div class="row">
                    <div class="col-12">
                        <form action="" method="post">
                            {{ csrf_field() }}
                            <div class="d-flex align-items-baseline">
                                <select name="para" id="para" class="form-control">
                                    <option></option>
                                    @foreach($datos["para"] AS $i => $v)
                                        @if(isset($datos["paraID"]))
                                        <option @if($datos["paraID"] == $i) selected @endif value="{{$i}}">{{$v}}</option>
                                        @else
                                        <option value="{{$i}}">{{$v}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-sm btn-secondary text-uppercase ml-2">filtrar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row productos">
                    @foreach($datos["productos"] AS $c)
                        <a href="{{ URL::to('producto/' . $c['id']) }}" class="col-12 mb-2 col-md-6 col-lg-4">
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
                </div>
                <div class="row d-flex justify-content-center">
                    @if(isset($datos["paraID"]))
                        {{ $datos["productos"]->appends( [ "para" => $datos["paraID"] ] )->links() }}
                    @else
                        {{ $datos["productos"]->links() }}
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@push("scripts_distribuidor")
<script>
    $(document).ready(function() {
        $("#para").select2({
            theme: "bootstrap",
            placeholder: "Marca"
        });
    });
</script>
@endpush