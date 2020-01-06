<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('headTitle', 'VENTOR :: ' . $title)</title>
        @if(!empty($datos["empresa"]["images"]["favicon"]))
            @if($datos["empresa"]["images"]["favicon"]["t"] == "png")
            <link rel="icon" type="image/png" href="{{ asset($datos['empresa']['images']['favicon']['i']) }}" />
            @else
            <link rel="shortcut icon" href="{{ asset($datos['empresa']['images']['favicon']['i']) }}" />
            @endif
        @endif
        <!-- <Fonts> -->
        <link href="https://fonts.googleapis.com/css?family=Exo+2:300,400,400i,500,600,700|Montserrat:300,400,400i,500,600,700" rel="stylesheet">
        <link href="{{ asset('css/fontawesome/css/regular.css') }}" rel="stylesheet">
        <link href="{{ asset('css/fontawesome/css/solid.css') }}" rel="stylesheet">
        <link href="{{ asset('css/fontawesome/css/all.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

        <!-- </Fonts> -->
        <!-- <Styles> -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="{{ asset('css/select2.css') }}" rel="stylesheet">
        <link href="https://select2.github.io/select2-bootstrap-theme/css/select2-bootstrap.css" rel="stylesheet">
        <link href="{{ asset('css/alertifyjs/alertify.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/alertifyjs/themes/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/css.css') }}" rel="stylesheet">
        <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('css/page.css') }}" rel="stylesheet">
        @stack('styles')
        <!-- </Styles> -->
    </head>
    <body>
        @if(auth()->guard('client')->check())
        @php
            $mark = auth()->guard('client')->user()['descuento'];
            $mark = number_format($mark , 2 , "," , ".");
        @endphp
        <div class="modal fade bd-example-modal-sm" role="dialog" id="markupConf">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title">Configuración</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form onsubmit="event.preventDefault(); edifConfiguracion(this);" action="{{ url('/cliente/mark') }}" method="post" id="formMark">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 d-flex align-items-center">
                                    <label for="utilidad" class="mb-0 d-block w-100 text-uppercase">% de utilidad</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" name="utilidad" id="utilidad" class="form-control text-right" value="{{ $mark }}" placeholder="Mark Up">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @if(session('success'))
            <div class="position-fixed w-100 text-center" style="z-index:9999;">
                <div class="alert alert-success" style="display: inline-block;">
                    {!! session('success')["mssg"] !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="position-fixed w-100 text-center" style="z-index:9999;">
                <div class="alert alert-danger alert-dismissible fade show d-inline-block">
                    @if(empty($errors->first('mssg')))
                    Datos incorrectos
                    @else
                    {!! $errors->first('mssg') !!}
                    @endif
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        <div class="wrapper">
            @include('page.parts.general.header')
            <section>
                @yield('body')
            </section>
            @include('page.parts.general.footer')
        </div>
        <!-- Scripts -->
        <script src="{{ asset('js/jquery-3.3.1.slim.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('css/fontawesome/js/all.js') }}"></script>
        <script src="{{ asset('css/fontawesome/js/brands.js') }}"></script>
        <script src="{{ asset('css/fontawesome/js/solid.js') }}"></script>
        
        <script src="{{ asset('js/bootstrap-notify.js') }}"></script>
        <script src="{{ asset('js/WOW.js') }}"></script>
        <script src="{{ asset('js/mdb.js') }}"></script>
        <script src="{{ asset('js/alertify.min.js') }}"></script>
        <script src="{{ asset('js/select2.full.js') }}"></script>
        <script src="{{ asset('js/adm.js') }}"></script>
        <script src="{{ asset('js/jquery.maskMoney.js') }}"></script>
        <script src="{{ asset('js/page/declaration.js') }}"></script>
        <script src="{{ asset('js/page/prueba.js') }}"></script>
        <script src="{{ asset('js/declaration.js') }}"></script>
        <script src="{{ asset('js/pyrus.min.js') }}"></script>
        <script src="{{ asset('js/janimate.min.js') }}"></script>
        <script>
            window.url = "{{ url()->current() }}";
            const imgDEFAULT = "{{ asset('images/general/no-img.png') }}";
            const datos = @json($datos);
            const URLBASE = `{{ URL::to("/") }}`;
            const logo = `{{ asset('${datos.empresa.images.logo}') }}`;
            const logoFooter = `{{ asset('${datos.empresa.images.logoFooter}') }}`;
            footer = new PyrusCuerpo("footer", {imgDEFAULT: imgDEFAULT, logo: logoFooter, domicilio: datos.empresa.domicilio, telefono: datos.empresa.telefono, email: datos.empresa.email, URLBASE:URLBASE});
            $("#wrapper-footer").html(footer.html());

            if($("nav .menu").find(`a[href="${window.url}"]`).length) {
                $("nav .menu").find(`a[href="${window.url}"]`).addClass("active");
                if(window.url.indexOf('atencion') > 0) {
                    $("nav .menu").find(`a[data-href="atencion"]`).addClass("active");
                }
            }
            if(localStorage.productos !== undefined) {
                window.productos = JSON.parse(localStorage.productos);
                if(Object.keys(window.productos).length > 0) {
                    if(!$("[data-carrito] > a > span").length) 
                        $("[data-carrito] > a").append(`<span class="ml-1">(${Object.keys(window.productos).length})</span>`);
                    if($("#cantProductos").length)
                        $("#cantProductos").text(Object.keys(window.productos).length);
                }
            }

            limpiar = function(t) {
                //if(localStorage.productos !== undefined)
                let url = $(t).attr("href");
                if(localStorage.productos !== undefined) {
                    alertify.confirm("ATENCIÓN","Hay elementos agregados en el carrito de pedidos. ¿Vaciar los productos?",
                        function() {
                            localStorage.clear();
                            window.location = url;
                        },
                        function() {
                            window.location = url;
                        }
                    ).set('labels', {ok:'Si, limpiar y salir', cancel:'No, solo salir'});
                } else
                    window.location = url;
            };
        </script>
        @stack('scripts')
    </body>
</html>