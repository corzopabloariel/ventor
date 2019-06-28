<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="ISO-8859-5">

        <title>@yield('headTitle', 'VENTOR :: ' . $title)</title>
        <!-- <Fonts> -->
        <link href="https://fonts.googleapis.com/css?family=Titillium+Web:400,400i,600,700,900" rel="stylesheet">
        <link href="{{ asset('css/fontawesome/css/regular.css') }}" rel="stylesheet">
        <link href="{{ asset('css/fontawesome/css/solid.css') }}" rel="stylesheet">
        <link href="{{ asset('css/fontawesome/css/svg-with-js.css') }}" rel="stylesheet">
        <link href="{{ asset('css/fontawesome/css/v4-shims.css') }}" rel="stylesheet">
        <link href="{{ asset('css/fontawesome/css/all.css') }}" rel="stylesheet">
        <!-- </Fonts> -->
        <!-- <Styles> -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="{{ asset('css/select2.css') }}" rel="stylesheet">
        <link href="https://select2.github.io/select2-bootstrap-theme/css/select2-bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://csshake.surge.sh/csshake.min.css">
        <link href="{{ asset('css/alertifyjs/alertify.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/alertifyjs/themes/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/css.css') }}" rel="stylesheet">
        <link href="{{ asset('css/adm.css') }}" rel="stylesheet">
        <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
        @stack('styles')
        <!-- </Styles> -->
    </head>
    <body>
        @if(session('success'))
            <div class="position-fixed w-100 text-center" style="z-index:9999;">
                <div class="alert alert-success" style="display: inline-block;">
                    {!! session('success')["mssg"] !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="far fa-times-circle"></i>
                    </button>
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="position-fixed w-100 text-center" style="z-index:9999;">
                <div class="alert alert-danger alert-dismissible fade show d-inline-block">
                    {!! $errors->first('mssg') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="far fa-times-circle"></i>
                    </button>
                </div>
            </div>
        @endif
        <div class="modal fade bd-example-modal-sm" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="far fa-times-circle"></i>
                        </button>
                    </div>{{-- event.preventDefault(); submitModal(this); --}}
                    <form action="" method="post" onsubmit="" id="form_modal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer bg-light">
                            <button class="btn btn-success text-uppercase" type="submit">cambiar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="wrapper">
            <!-- Sidebar -->
            <nav id="sidebar" class="position-fixed h-100">
                @include('adm.general.menu')
            </nav>

            <!-- Page Content -->
            <div id="content">
                @yield('body')
            </div>
        </div>
        <!-- Scripts -->
        <script src="{{ asset('js/jquery-3.3.1.slim.min.js') }}"></script>
        
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/select2.full.js') }}"></script>
        <script src="{{ asset('js/jquery.maskMoney.js') }}"></script>
        <script src="{{ asset('js/alertify.min.js') }}"></script>
        <script src="{{ asset('js/declaration.js') }}"></script>
        <script src="{{ asset('js/pyrus.min.js') }}"></script>
        <script src="{{ asset('js/color.js') }}"></script>
        <script src="{{ asset('js/solver.js') }}"></script>
        <script src="{{ asset('js/adm.js') }}"></script>
        <script>
            window.url = "{{ url()->current() }}";console.log(window.url)
            limpiar = function(t) {
                if(localStorage.carrito !== undefined) {
                    localStorage.removeItem("carrito");
                    localStorage.removeItem("pedido");
                }
                if(localStorage.idCliente !== undefined) {
                    localStorage.removeItem("idCliente");
                    localStorage.removeItem("idPedido");
                    localStorage.removeItem("observaciones");
                }
            }
        </script>
        @stack('scripts')
    </body>
</html>