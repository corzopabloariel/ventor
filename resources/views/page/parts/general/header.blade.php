<div id="menuNav" class="modal fade menuNav" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-modal="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-top-0 border-left-0 border-bottom-0">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Menú</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-uppercase"><a href="/">Home</a></li>
                    <li class="list-group-item text-uppercase"><a href="{{ route('empresa') }}">Empresa</a></li>
                    <li class="list-group-item text-uppercase"><a href="{{ route('productos.productos') }}">Productos</a></li>
                    <li class="list-group-item text-uppercase position-relative pr-1">
                        <div data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation"><a href="#">Atención al Cliente</a><i class="fas fa-caret-down position-absolute" style="right: 0; top: 15px"></i></div>
                        <ul class="collapse list-group list-group-flush" id="navbarToggleExternalContent">
                            <li class="list-group-item pr-1 position-relative">
                                <a href="{{ URL::to('atencion/transmision') }}">Análisis de transmisión</a>
                            </li>
                            <li class="list-group-item pr-1 position-relative">
                                <a href="{{ URL::to('atencion/pagos') }}">Información sobre pago</a>
                            </li>
                            <li class="list-group-item pr-1 position-relative">
                                <a href="{{ URL::to('atencion/consulta') }}">Consulta general</a>
                            </li>
                        </ul>
                    </li>
                    <li class="list-group-item text-uppercase"><a href="{{ route('calidad') }}">Calidad</a></li>
                    <li class="list-group-item text-uppercase"><a href="{{ route('trabaje') }}">Trabaje con nosotros</a></li>
                    <li class="list-group-item text-uppercase"><a href="{{ route('contacto') }}">Contacto</a></li>
                </ul>
                <p class="my-3 text-dark text-center">
                    <a class="" href="tel:{{$datos['empresa']['telefono']['tel'][0]}}"><i class="fas fa-phone-volume mr-2"></i>{{$datos['empresa']['telefono']['tel'][0]}}</a>
                </p>
                <p class="mb-0 text-dark text-center">
                    <i class="fas fa-map-marker-alt mr-2"></i>{!! $datos["empresa"]["domicilio"]["calle"] !!} {!! $datos["empresa"]["domicilio"]["altura"] !!}<br/>C.A.B.A | Argentina
                </p>
            </div>
            <div class="modal-footer bg-light info">
                <form method="post" action="{{ url('/buscador/header') }}" class="position-relative w-100">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="text" class="form-control" name="input" placeholder="Buscar..." id="">
                    <i class="fas fa-search position-absolute"></i>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="wrapper-header"></div>