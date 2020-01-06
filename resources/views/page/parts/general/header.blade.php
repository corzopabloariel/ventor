<div id="menuNav" class="modal fade menuNav" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-modal="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-top-0 border-left-0 border-bottom-0">
            <div class="modal-header bg-light">
                @if(auth()->guard('client')->check())
                <h5 class="modal-title">Bienvenido, {{auth()->guard('client')->user()["name"]}}</h5>
                @else
                <h5 class="modal-title">Menú</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush">
                    @if(auth()->guard('client')->check())
                    <li class="list-group-item px-0 text-uppercase border-bottom-0 position-relative pr-1">
                        <div data-toggle="collapse" data-target="#sesion" aria-controls="sesion" aria-expanded="false" aria-label="Toggle navigation"><a href="#">Mis datos</a><i class="fas fa-caret-down position-absolute" style="right: 0; top: 15px"></i></div>
                        <ul class="collapse list-group list-group-flush" id="sesion">
                            @if(auth()->guard('client')->user()["username"] != "111")
                            <li class="list-group-item px-0 pr-1 position-relative">
                                <a style="font-size:inherit; font-weight: normal" class="d-block" href="{{ URL::to('cliente/datos') }}"><i class="fas fa-id-card mr-3"></i>Mis datos</a>
                            </li>
                            @endif
                            <li class="list-group-item px-0 pr-1 position-relative">
                                <a style="font-size:inherit; font-weight: normal" class="d-block" href="#" onclick="confirguracionMarkUP(this)"><i class="fas fa-cog mr-3"></i>Configuración</a>
                            </li>
                            @if(auth()->guard('client')->user()["is_vendedor"] == 0)
                            <li class="list-group-item px-0 pr-1 position-relative">
                                <a style="font-size:inherit; font-weight: normal" class="d-block isDisabled" href="#{{-- URL::to('cliente/pedidos') --}}"><i class="fas fa-cash-register mr-3"></i>Mis pedidos</a>
                            </li>
                            @endif
                            <li class="list-group-item px-0 pr-1 position-relative">
                                <a style="font-size:inherit; font-weight: normal" onclick="event.preventDefault(); limpiar(this);" class="d-block d-flex justify-content-between align-items-center" href="{{ URL::to('salir') }}">Cerrar sesión<i class="text-danger fas fa-sign-out-alt"></i></a>
                            </li>
                        </ul>
                    </li>
                    <li class="list-group-item border-dark px-0 text-uppercase"><a href="{{ route('index') }}">Home</a></li>
                    <li class="list-group-item px-0 text-uppercase"><a href="{{ route('empresa') }}">Empresa</a></li>
                    <li class="list-group-item px-0 text-uppercase" data-pedido><a href="{{ route('pedido') }}">Pedido</a></li>
                    <li class="list-group-item px-0 text-uppercase" data-carrito><a href="{{ route('carrito') }}">Carrito</a></li>

                    <li class="list-group-item px-0 text-uppercase position-relative pr-1">
                        <div data-toggle="collapse" data-target="#cuenta" aria-controls="cuenta" aria-expanded="false" aria-label="Toggle navigation"><a href="#">@if(auth()->guard('client')->user()["is_vendedor"] == 0) Cuenta @else Cuentas @endif</a><i class="fas fa-caret-down position-absolute" style="right: 0; top: 15px"></i></div>
                        <ul class="collapse list-group list-group-flush" id="cuenta">
                            <li class="list-group-item px-0 pr-1 position-relative">
                                <a class="isDisabled" href="#">Análisis de deuda</a>
                            </li>
                            <li class="list-group-item px-0 pr-1 position-relative">
                                <a class="isDisabled" href="#">Faltantes</a>
                            </li>
                            <li class="list-group-item px-0 pr-1 position-relative">
                                <a class="isDisabled" href="#">Comprobantes</a>
                            </li>
                        </ul>
                    </li>
                    <li class="list-group-item px-0 text-uppercase"><a href="{{ route('descargas') }}">Descargas</a></li>
                    <li class="list-group-item px-0 text-uppercase position-relative pr-1">
                        <div data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation"><a href="#">Atención al Cliente</a><i class="fas fa-caret-down position-absolute" style="right: 0; top: 15px"></i></div>
                        <ul class="collapse list-group list-group-flush" id="navbarToggleExternalContent">
                            <li class="list-group-item px-0 pr-1 position-relative">
                                <a href="{{ URL::to('atencion/transmision') }}">Análisis de transmisión</a>
                            </li>
                            <li class="list-group-item px-0 pr-1 position-relative">
                                <a href="{{ URL::to('atencion/pagos') }}">Información sobre pago</a>
                            </li>
                            <li class="list-group-item px-0 pr-1 position-relative">
                                <a href="{{ URL::to('atencion/consulta') }}">Consulta general</a>
                            </li>
                        </ul>
                    </li>
                    <li class="list-group-item px-0 text-uppercase"><a href="{{ route('calidad') }}">Calidad</a></li>
                    <li class="list-group-item px-0 text-uppercase"><a href="{{ route('contacto') }}">Contacto</a></li>
                    @else
                    <li class="list-group-item px-0 text-uppercase"><a href="{{ route('index') }}">Home</a></li>
                    <li class="list-group-item px-0 text-uppercase"><a href="{{ route('empresa') }}">Empresa</a></li>
                    <li class="list-group-item px-0 text-uppercase"><a href="{{ route('productos.productos') }}">Productos</a></li>
                    <li class="list-group-item px-0 text-uppercase"><a href="{{ route('descargas') }}">Descargas</a></li>
                    <li class="list-group-item px-0 text-uppercase position-relative pr-1">
                        <div data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation"><a href="#">Atención al Cliente</a><i class="fas fa-caret-down position-absolute" style="right: 0; top: 15px"></i></div>
                        <ul class="collapse list-group list-group-flush" id="navbarToggleExternalContent">
                            <li class="list-group-item px-0 pr-1 position-relative">
                                <a href="{{ URL::to('atencion/transmision') }}">Análisis de transmisión</a>
                            </li>
                            <li class="list-group-item px-0 pr-1 position-relative">
                                <a href="{{ URL::to('atencion/pagos') }}">Información sobre pago</a>
                            </li>
                            <li class="list-group-item px-0 pr-1 position-relative">
                                <a href="{{ URL::to('atencion/consulta') }}">Consulta general</a>
                            </li>
                        </ul>
                    </li>
                    <li class="list-group-item px-0 text-uppercase"><a href="{{ route('calidad') }}">Calidad</a></li>
                    <li class="list-group-item px-0 text-uppercase"><a href="{{ route('trabaje') }}">Trabaje con nosotros</a></li>
                    <li class="list-group-item px-0 text-uppercase"><a href="{{ route('contacto') }}">Contacto</a></li>
                    @endif
                </ul>
                <p class="my-3 text-dark text-center">
                    <a class="" href="tel:{{$datos['empresa']['telefono']['tel'][0]}}"><i class="fas fa-phone-volume mr-2"></i>{{$datos['empresa']['telefono']['tel'][0]}}</a>
                </p>
                <p class="mb-0 text-dark text-center">
                    <i class="fas fa-map-marker-alt mr-2"></i>{!! $datos["empresa"]["domicilio"]["calle"] !!} {!! $datos["empresa"]["domicilio"]["altura"] !!}<br/>C.A.B.A | Argentina
                </p>
            </div>
            @if(!auth()->guard('client')->check())
            <div class="modal-footer bg-light info">
                <form method="post" action="{{ url('/buscador/body') }}" class="position-relative w-100">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="text" class="form-control" name="buscar" placeholder="Buscar..." id="">
                    <i class="fas fa-search position-absolute" style="right:10px; top:10px;"></i>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
<div id="wrapper-header">
    <nav class="navbar navbar-expand-lg pb-0 navbar-light">
        <div class="container">
            @if(auth()->guard('client')->check())
            <a style="top:0" class="navbar-brand position-absolute" href="{{ route('index') }}">
                <img onerror="this.src='{{ asset('images/general/no-img.png') }}'" src="{{ asset($datos['empresa']['images']['logo']) }}@php echo '?t=' . time() @endphp" style="width: 257px;height: 65px;">
            </a>
            <div class="row justify-content-end flex-column w-100">
                <ul class="list-unstyled menu d-flex justify-content-end pt-2 mb-1 align-items-center info">
                  @if(!auth()->guard('client')->check())
                    <li class="buscador hidden-tablet">
                        <form class="position-relative d-flex" action="{{ url('/buscador/body') }}" method="post">
                            <button type="submit" class="btn">
                                <i class="fas fa-search"></i>
                            </button>
                            <input placeholder="Estoy buscando..." type="text" name="buscar" class="form-control form-control-sm">
                        </form>
                    </li>
                    @endif
                    <li class="border-left-0 btnMenuModal">
                        <button class="navbar-toggler btn btn-light rounded-0" type="button" data-toggle="modal" data-target="#menuNav">
                            <i class="fas fa-bars"></i>
                        </button>
                    </li>
					<li class="hidden-tablet">
					</li>
                    <li class="hidden-tablet border-left-0" style="width:400px;">
						<span style="color:#0099D6;" class="text-truncate d-block text-left">
                            <i class="fas fa-user-circle mr-2"></i>Bienvenido, {{auth()->guard('client')->user()["name"]}}
                            <ul class="submenu list-unstyled shadow-sm" style="font-size: 17px;">
                                @if(auth()->guard('client')->user()["username"] != "0")
                                <li class="p-0">
                                    <a style="font-size:inherit; font-weight: normal" class="d-block" href="{{ URL::to('cliente/datos') }}"><i class="fas fa-id-card mr-3"></i>Mis datos</a>
                                </li>
                                @endif
                                <li class="p-0">
                                    <a style="font-size:inherit; font-weight: normal" class="d-block" href="#" onclick="confirguracionMarkUP(this)"><i class="fas fa-cog mr-3"></i>Configuración</a>
                                </li>
                                @if(auth()->guard('client')->user()["is_vendedor"] == 0)
                                <li class="p-0">
                                    <a style="font-size:inherit; font-weight: normal" class="d-block isDisabled" href="#{{-- URL::to('cliente/pedidos') --}}"><i class="fas fa-cash-register mr-3"></i>Mis pedidos</a>
                                </li>
                                @endif
                                <li class="p-0">
                                    <a style="font-size:inherit; font-weight: normal" onclick="event.preventDefault(); limpiar(this);" class="d-block d-flex justify-content-between align-items-center" href="{{ URL::to('salir') }}">Cerrar sesión<i class="text-danger fas fa-sign-out-alt"></i></a>
                                </li>
                            </ul>
						</span>
                    </li>
					<li class="redes">
                        @php
                        $Arr_redes = ["facebook" => '<i class="fab fa-facebook-square"></i>',"instagram" => '<i class="fab fa-instagram"></i>'];
                        @endphp
                        @foreach($datos["empresa"]["redes"] AS $i => $r)
                        <a href="{{ $r['url'] }}">{!! $Arr_redes[$r['redes']] !!}</a>
                        @endforeach
                    </li>
                </ul>
                <ul id="ulNavFixed" class="hidden-tablet list-unstyled mb-0 menu d-flex pb-3 justify-content-end align-items-center">
                    <li data-empresa="" class="hidden-tablet">
                        <a href="{{ route('empresa') }}">Empresa</a>
                    </li>
                    <li data-productos="" class="hidden-tablet" data-pedido>
                        <a href="{{ URL::to('pedido') }}">Pedido</a>
                    </li>
                    <li data-productos="" class="hidden-tablet" data-carrito>
                        <a href="{{ URL::to('carrito') }}">Carrito</a>
                    </li>
                    <li data-atencion="" class="hidden-tablet">
                        <a data-href="atencion" href="#">@if(auth()->guard('client')->user()["is_vendedor"] == 0) Cuenta @else Cuentas @endif</a>
                        <ul class="submenu list-unstyled shadow-sm">
                            <li>
                                <a class="isDisabled" href="#">Análisis de deuda</a>
                            </li>
                            <li>
                                <a class="isDisabled" href="#">Faltantes</a>
                            </li>
                            <li>
                                <a class="isDisabled" href="#">Comprobantes</a>
                            </li>
                        </ul>
                    </li>
                    <li data-descargas="" class="hidden-tablet">
                        <a href="{{ route('descargas') }}">Descargas</a>
                    </li>
                    <li data-atencion="" class="hidden-tablet">
                        <a data-href="atencion" href="#">Atención al Cliente</a>
                        <ul class="submenu list-unstyled shadow-sm">
                            <li>
                                <a href="{{ URL::to('atencion/transmision') }}">Análisis de transmisión</a>
                            </li>
                            <li>
                                <a href="{{ URL::to('atencion/pagos') }}">Información sobre pagos</a>
                            </li>
                            <li>
                                <a href="{{ URL::to('atencion/consulta') }}">Consulta general</a>
                            </li>
                        </ul>
                    </li>
                    <li data-calidad="" class="hidden-tablet">
                        <a href="{{ route('calidad') }}">Calidad</a>
                    </li>
                    <li data-contacto="" class="hidden-tablet">
                        <a href="{{ route('contacto') }}">Contacto</a>
                    </li>
                </ul>
            </div>
            @else
            <a style="top:0" class="navbar-brand position-absolute" href="{{ route('index') }}">
                <img onerror="this.src='{{ asset('images/general/no-img.png') }}'" src="{{ asset($datos['empresa']['images']['logo']) }}@php echo '?t=' . time() @endphp" style="width: 257px;height: 65px;">
            </a>
            <div class="row justify-content-end flex-column w-100">
                <ul class="list-unstyled d-flex justify-content-end pt-2 mb-1 align-items-center info">
                    <li class="border-left-0 btnMenuModal">
                        <button class="navbar-toggler btn btn-light rounded-0" type="button" data-toggle="modal" data-target="#menuNav">
                            <i class="fas fa-bars"></i>
                        </button>
                    </li>

                    <li class="zonaCliente dropdown">
                        <a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-circle mr-2"></i>Zona de clientes</a>
                        <ul class="submenu list-unstyled shadow-sm rounded dropdown-menu" id="login" aria-labelledby="dropdownMenuButton">
                            <li>
                                <div>
                                    <form action="{{ url('/cliente/acceso') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="password" value="pablopablo">
                                        <div class="contenedorForm w-100" id="form_formulario_login">
                                            <div class="row justify-content-center align-items-center">
                                                <div class="col-12">
                                                    <input value="" name="username" id="username" class="form-control  texto-text" type="text" placeholder="USUARIO" required>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn mx-auto px-5 text-white d-block mx-auto mt-3 text-uppercase" type="submit">ingresar</button>
                                    </form>
                                </div>
                            </li>
                            <li class="border-top bg-white">
                                <p class="text-center mb-0"><a href="{{ route('olvide') }}" class="text-primary">Olvidé mi contraseña</a></p>
                            </li>
                        </ul>
                    </li>
                    <li class="buscador hidden-tablet">
                        <form class="position-relative d-flex" action="{{ url('/buscador/body') }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <button type="submit" class="btn">
                                <i class="fas fa-search"></i>
                            </button>
                            <input placeholder="Estoy buscando..." type="text" name="buscar" class="form-control form-control-sm">
                        </form>
                    </li>
                    <li class="redes">
                        @php
                        $Arr_redes = ["facebook" => '<i class="fab fa-facebook-square"></i>',"instagram" => '<i class="fab fa-instagram"></i>'];
                        @endphp
                        @foreach($datos["empresa"]["redes"] AS $i => $r)
                        <a href="{{ $r['url'] }}">{!! $Arr_redes[$r['redes']] !!}</a>
                        @endforeach
                    </li>
                </ul>
                <ul id="ulNavFixed" class="hidden-tablet list-unstyled mb-0 menu d-flex pb-3 justify-content-end align-items-center">
                    <li data-empresa="" class="hidden-tablet">
                        <a href="{{ route('empresa') }}">Empresa</a>
                    </li>
                    <li data-productos="" class="hidden-tablet">
                        <a href="{{ URL::to('productos') }}">Productos</a>
                    </li>
                    <li data-descargas="" class="hidden-tablet">
                        <a href="{{ route('descargas') }}">Descargas</a>
                    </li>
                    <li data-atencion="" class="hidden-tablet">
                        <a data-href="atencion" href="#">Atención al Cliente</a>
                        <ul class="submenu list-unstyled shadow-sm">
                            <li>
                                <a href="{{ URL::to('atencion/transmision') }}">Análisis de transmisión</a>
                            </li>
                            <li>
                                <a href="{{ URL::to('atencion/pagos') }}">Información sobre pagos</a>
                            </li>
                            <li>
                                <a href="{{ URL::to('atencion/consulta') }}">Consulta general</a>
                            </li>
                        </ul>
                    </li>
                    <li data-calidad="" class="hidden-tablet">
                        <a href="{{ route('calidad') }}">Calidad</a>
                    </li>
                    <li data-trabaje="" class="hidden-tablet">
                        <a href="{{ route('trabaje') }}">Trabaje con nosotros</a>
                    </li>
                    <li data-contacto="" class="hidden-tablet">
                        <a href="{{ route('contacto') }}">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
        @endif
    </nav>
</div>
