<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('headTitle', 'VENTOR :: ' . $title)</title>
        <!-- <Fonts> -->
        <link href="https://fonts.googleapis.com/css?family=Exo+2:300,400,400i,500,600,700|Montserrat:300,400,400i,500,600,700" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/af-2.3.2/b-1.5.4/b-colvis-1.5.4/b-html5-1.5.4/b-print-1.5.4/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.5.0/r-2.2.2/rg-1.1.0/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.css"/>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

        <!-- </Fonts> -->
        <!-- <Styles> -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
                    {!! $errors->first('mssg') !!}
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
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="{{ asset('js/WOW.js') }}"></script>
        <script src="{{ asset('js/alertify.min.js') }}"></script>
        <script src="{{ asset('js/adm.js') }}"></script>
        <script src="{{ asset('js/page/declaration.js') }}"></script>
        <script src="{{ asset('js/page/prueba.js') }}"></script>
        <script src="{{ asset('js/declaration.js') }}"></script>
        <script src="{{ asset('js/pyrus.min.js') }}"></script>
        <script src="{{ asset('js/janimate.min.js') }}"></script>
        <script>
            window.url = "{{ url()->current() }}";
            const imgDEFAULT = "{{ asset('images/general/no-img.png') }}";
            const datos = @json($datos);console.log(datos)
            const URLBASE = `{{ URL::to("/") }}`;
            const logo = `{{ asset('${datos.empresa.images.logo}') }}`;
            const logoFooter = `{{ asset('${datos.empresa.images.logoFooter}') }}`;
            header = new PyrusCuerpo("header", {imgDEFAULT: imgDEFAULT, logo: logo, URLBASE: URLBASE, BUSCADOR: {PLACEHOLDER: "Estoy buscando...", NAME: "input", ACTION: "{{ url('/buscador/home') }}"}, REDES: datos.empresa.redes});
            @if(auth()->guard('client')->check())
                window.data = @json(auth()->guard('client')->user());
                const URLLOGOUT = `{{ route("client.logout") }}`;
                header = new PyrusCuerpo("headerLog", {imgDEFAULT: imgDEFAULT,URLLOGOUT: URLLOGOUT,BUSCADOR: {PLACEHOLDER: "Estoy buscando...", NAME: "buscar", ACTION: "{{ url('/buscador/pedido') }}"}, datos: window.data, logo: logo, URLBASE: URLBASE, REDES: datos.empresa.redes});
                $("#wrapper-header").html(header.html());
            @endif
            
            footer = new PyrusCuerpo("footer", {imgDEFAULT: imgDEFAULT, logo: logoFooter, domicilio: datos.empresa.domicilio, telefono: datos.empresa.telefono, email: datos.empresa.email, URLBASE:URLBASE});
            form = new Pyrus("formulario_login");
            $("#wrapper-header").html(header.html());
            $("#wrapper-footer").html(footer.html());

            let formHTML = "";
            let formACTION = "{{ route('client.login') }}";
            let token = "{{ csrf_token() }}";
            formHTML += `<form action="${formACTION}" method="post">`;
                formHTML += `<input type="hidden" name="_token" value="${token}"/>`;
                formHTML += form.formulario();
                formHTML += `<button class="btn mx-auto px-5 text-white d-block mx-auto mt-3 text-uppercase" type="submit">ingresar</button>`;
            formHTML += `</form>`;
            $("#login > li:first-child > div").html(formHTML);

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