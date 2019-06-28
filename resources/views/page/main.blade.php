<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('headTitle', 'VENTOR :: ' . $title)</title>
        @if(!empty($datos["empresa"]["images"]["favicon"]))
            @if($datos["empresa"]["images"]["favicon"]["t"] == "png")
            <link rel="icon" type="image/png" href="{{ $datos['empresa']['images']['favicon']['i'] }}" />
            @else
            <link rel="shortcut icon" href="{{ $datos['empresa']['images']['favicon']['i'] }}" />
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
        
        <script src="{{ asset('js/WOW.js') }}"></script>
        <script src="{{ asset('js/mdb.js') }}"></script>
        <script src="{{ asset('js/alertify.min.js') }}"></script>
        <script src="{{ asset('js/select2.full.js') }}"></script>
        <script src="{{ asset('js/adm.js') }}"></script>
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
            //header = new PyrusCuerpo("header", {imgDEFAULT: imgDEFAULT, logo: logo, URLBASE: URLBASE, BUSCADOR: {PLACEHOLDER: "Estoy buscando...", NAME: "input", ACTION: "{{ url('/buscador/home') }}"}, REDES: datos.empresa.redes});
            @if(auth()->guard('client')->check())
                window.data = @json(auth()->guard('client')->user());
                const URLLOGOUT = `{{ route("salir") }}`;
                header = new PyrusCuerpo("headerLog", {imgDEFAULT: imgDEFAULT,URLLOGOUT: URLLOGOUT,BUSCADOR: {PLACEHOLDER: "Estoy buscando...", NAME: "buscar", ACTION: "{{ url('/buscador/pedido') }}"}, datos: window.data, logo: logo, URLBASE: URLBASE, REDES: datos.empresa.redes});
                //$("#wrapper-header").html(header.html());
            @endif
            
            footer = new PyrusCuerpo("footer", {imgDEFAULT: imgDEFAULT, logo: logoFooter, domicilio: datos.empresa.domicilio, telefono: datos.empresa.telefono, email: datos.empresa.email, URLBASE:URLBASE});
            form = new Pyrus("formulario_login");
            //$("#wrapper-header").html(header.html());
            $("#wrapper-footer").html(footer.html());

            let formHTML = "";
            let formACTION = "{{ route('client.acceso') }}";
            let token = "{{ csrf_token() }}";
            formHTML += `<form action="${formACTION}" method="post">`;
                formHTML += `<input type="hidden" name="_token" value="${token}"/>`;
                formHTML += `<input type="hidden" name="password" value="pablopablo"/>`;
                formHTML += form.formulario();
                formHTML += `<button class="btn mx-auto px-5 text-white d-block mx-auto mt-3 text-uppercase" type="submit">ingresar</button>`;
            formHTML += `</form>`;
            //$("#login > li:first-child > div").html(formHTML);

            if($("nav .menu").find(`a[href="${window.url}"]`).length) {
                $("nav .menu").find(`a[href="${window.url}"]`).addClass("active");
                if(window.url.indexOf('atencion') > 0) {
                    $("nav .menu").find(`a[data-href="atencion"]`).addClass("active");
                }
            }

            limpiar = function() {
                if(localStorage.productos !== undefined)
                    localStorage.removeItem("productos");
            }
        </script>
        @stack('scripts')
    </body>
</html>