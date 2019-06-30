<div class="wrapper-contacto pb-5">
    <div class="container mt-2 mb-5">
        <h3 class="title text-uppercase" style="font-size: 32px; color: #595959; font-weight: 200">Mis datos</h3>
        <div class="row">
            <div class="col-12 col-md-6 text-right"><strong class="text-uppercase">nombre</strong></div>
            <div class="col-12 col-md-6">{{ $datos["datos"]["name"] }}</div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 text-right"><strong class="text-uppercase">usuario</strong></div>
            <div class="col-12 col-md-6">{{ $datos["datos"]["username"] }}</div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 text-right"><strong class="text-uppercase">contraseña</strong></div>
            <div class="col-12 col-md-6">
                @if(isset($datos["empleado"]))
                NO
                @elseif(isset($datos["vendedor"]))
                NO
                @else
                SI
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 text-right"><strong class="text-uppercase">tipo de cuenta</strong></div>
            <div class="col-12 col-md-6">
                @if(isset($datos["empleado"]))
                VENTOR
                @elseif(isset($datos["vendedor"]))
                VENDEDOR
                @else
                CLIENTE
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <hr>
            </div>
        </div>
        @if(isset($datos["empleado"]))
        <div class="row">
            <div class="col-12 col-md-6 text-right">
                <strong class="text-uppercase">email</strong>
            </div>
            <div class="col-12 col-md-6">{{ empty($datos["empleado"]["email"]) ? "-" : $datos["empleado"]["email"] }}</div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 text-right">
                <strong class="text-uppercase">CUIT</strong>
            </div>
            <div class="col-12 col-md-6">{{ str_replace("EMP_","",$datos["empleado"]["username"]) }}</div>
        </div>
        <div class="row">
            <div class="col-12">
                <hr>
            </div>
        </div>
        @endif
        @if(isset($datos["cliente"]))
        <div class="row">
            <div class="col-12 col-md-6 text-right">
                <strong class="text-uppercase">número de cuenta</strong>
            </div>
            <div class="col-12 col-md-6">{{ $datos["cliente"]["nrocta"] }}</div>
        </div>
        <div class="row">
            <div class="col-12">
                <hr>
            </div>
        </div>
        <fieldset>
            <legend>DOMICILIO</legend>
            <div class="row">
                <div class="col-12 col-md-6 text-right">
                    <strong class="text-uppercase">Dirección</strong>
                </div>
                <div class="col-12 col-md-6">
                    {{ $datos["cliente"]["direcc"] }}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 text-right">
                    <strong class="text-uppercase">Provincia / localidad</strong>
                </div>
                <div class="col-12 col-md-6">
                    {{ $datos["cliente"]->localidad["descr_001"] }} / {{ $datos["cliente"]->localidad["descrp"] }} ({{$datos["cliente"]->localidad["codpos"]}})
                </div>
            </div>
        </fieldset>
        <div class="row">
            <div class="col-12">
                <hr>
            </div>
        </div>
        <fieldset>
            <legend>CONTACTO</legend>
            <div class="row">
                <div class="col-12 col-md-6 text-right">
                    <strong class="text-uppercase">teléfono</strong>
                </div>
                <div class="col-12 col-md-6">
                    {{ $datos["cliente"]["telefn"] }}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 text-right">
                    <strong class="text-uppercase">whatsapp</strong>
                </div>
                <div class="col-12 col-md-6">
                    -
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 text-right">
                    <strong class="text-uppercase">instagram</strong>
                </div>
                <div class="col-12 col-md-6">
                    -
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 text-right">
                    <strong class="text-uppercase">fax</strong>
                </div>
                <div class="col-12 col-md-6">
                    {{ empty($datos["cliente"]["nrofax"]) ? "-" : $datos["cliente"]["nrofax"] }}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 text-right">
                    <strong class="text-uppercase">email</strong>
                </div>
                <div class="col-12 col-md-6">
                    {{ $datos["cliente"]["direml"] }}
                </div>
            </div>
        </fieldset>
        @endif
        @if(isset($datos["vendedor"]))
        <fieldset>
            <legend>INFORMACIÓN</legend>
            <div class="row">
                <div class="col-12 col-md-6 text-right"><strong class="text-uppercase">código</strong></div>
                <div class="col-12 col-md-6">{{ $datos["vendedor"]["vnddor"] }}</div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 text-right">
                    <strong class="text-uppercase">CUIT</strong>
                </div>
                <div class="col-12 col-md-6">{{ str_replace("VND_","",$datos["datos"]["username"]) }}</div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 text-right"><strong class="text-uppercase">teléfono</strong></div>
                <div class="col-12 col-md-6">{{ $datos["vendedor"]["nrotel"] }}</div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 text-right"><strong class="text-uppercase">email</strong></div>
                <div class="col-12 col-md-6">{{ $datos["vendedor"]["mail"] }}</div>
            </div>
        </fieldset>
        @endif
    </div>
</div>