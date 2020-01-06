<div class="wrapper-descargas py-5">
    <div class="container">
        <div class="mb-4 text-center">
            <a download href="http://pedidos.ventor.com.ar/pedidos/actualizacion_cd/instalador_ventor.exe" class="btn btn-inline-block btn-info rounded-pill px-5 mx-auto"><strong>Descargar:</strong> VENTOR Catálogo y Pedidos</a>
        </div>
        
        <h2 class="title mt-5" style="color: #0099D6;">Descargas e instructivos</h2>
        <div class="row mt-3">
            @foreach($datos["descargasPublicas"] AS $d)
                <div class="col-12 col-md-3 mt-2 descarga d-flex justify-content-center">
                    <div class="d-inline-block">
                        <a onclick="event.preventDefault(); descargar(this);" data-tipo="publico" href="{{ asset($d['documento']) }}" download>
                            <img style="width: 100%;" src="{{ asset($d['image']) }}" onError="this.src='{{ asset('images/general/no-descarga.fw.png') }}'" class="border d-block mx-auto" />
                            <p class="w-75 mx-auto mb-1 mt-2 text-center">{{ $d["nombre"] }}</p>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <h2 class="title mt-4" style="color: #0099D6;">Listas de Precios</h2>
        @php
        $Arr = [];
        $Arr2 = [];
        //dd($datos["descargasPrivadas"]);
        for($i = 0; $i < count($datos["descargasPrivadas"]) ; $i++) {
            if($datos["descargasPrivadas"][$i]["precio"] == 0) {
                if(!isset($Arr2[$datos["descargasPrivadas"][$i]["did"]])) {
                    $Arr2[$datos["descargasPrivadas"][$i]["did"]] = [];
                    $Arr2[$datos["descargasPrivadas"][$i]["did"]]["nombre"] = $datos["descargasPrivadas"][$i]["nombre"];
                    $Arr2[$datos["descargasPrivadas"][$i]["did"]]["image"] = $datos["descargasPrivadas"][$i]["image"];
                    $Arr2[$datos["descargasPrivadas"][$i]["did"]]["partes"] = [];
                }

                $Arr2[$datos["descargasPrivadas"][$i]["did"]]["partes"][] = ["parte" => $datos["descargasPrivadas"][$i]["parte"], "documento" => $datos["descargasPrivadas"][$i]["documento"]];
                continue;
            }
            if(!isset($Arr[$datos["descargasPrivadas"][$i]["did"]])) {
                $Arr[$datos["descargasPrivadas"][$i]["did"]] = [];
                $Arr[$datos["descargasPrivadas"][$i]["did"]]["nombre"] = $datos["descargasPrivadas"][$i]["nombre"];
                $Arr[$datos["descargasPrivadas"][$i]["did"]]["image"] = $datos["descargasPrivadas"][$i]["image"];
                $Arr[$datos["descargasPrivadas"][$i]["did"]]["formatos"] = [];
            }
            $Arr[$datos["descargasPrivadas"][$i]["did"]]["formatos"][] = ["ext" => $datos["descargasPrivadas"][$i]["formato"], "documento" => $datos["descargasPrivadas"][$i]["documento"]];
        }

        @endphp
        <div class="row mt-3">
        @foreach($Arr AS $did => $d)
            <div class="col-12 col-md-3 descarga mt-2">
                <a id="link-{{ $did }}" onclick="event.preventDefault(); descargar(this);" data-tipo="privado" class="link w-100" download style="cursor:pointer;">
                    <img style="width: 100%;" src="{{ asset($d['image']) }}" onError="this.src='{{ asset('images/general/no-descarga.fw.png') }}'" class="border d-block mx-auto" />
                </a>
                <select onchange="linkActive(this)" class="w-100 d-block bg-light p-2 border" style="margin-top:-1px;">
                    <option value="" hidden>Seleccione un archivo</option>
                    @foreach($d["formatos"] AS $f)
                        <option value="{{ asset($f['documento']) }}">Ventor Lista de precios - formato {{ $f["ext"] }} {{ $d["nombre"] }}</option>
                    @endforeach
                </select>
            </div>
        @endforeach
        </div>
        <h2 class="title mt-5" style="color: #0099D6;">Catálogos</h2>
        <div class="row mt-3">
        @foreach($Arr2 AS $did => $d)
            <div class="col-12 col-md-3 mt-2 descarga">
                <a id="link-{{ $did }}" onclick="event.preventDefault(); descargar(this);" data-tipo="privado" disabled class="link d-block w-100" download style="cursor:pointer;">
                    <img style="width: 100%;" src="{{ asset($d['image']) }}" onError="this.src='{{ asset('images/general/no-descarga.fw.png') }}'" class="border d-block" />
                </a>
                <select onchange="linkActive(this)" style="width: 100%" class="d-block bg-light p-2 border" style="margin-top:-1px;">
                    <option value="" hidden>Seleccione un archivo</option>
                    @foreach($d["partes"] AS $f)
                        <option class="text-uppercase" value="{{ asset($f['documento']) }}">{{ $f["parte"] }}</option>
                    @endforeach
                </select>
            </div>
        @endforeach
        </div>

        <h2 class="title mt-5" style="color: #0099D6;">Otros Catálogos</h2>

        <div class="row mt-3">
            @foreach($datos["descargasOtras"] AS $d)
                <div class="col-12 col-md-3 mt-4 descarga d-flex justify-content-center">
                    <a style="cursor:pointer;" class="w-100" onclick="event.preventDefault(); descargar(this);" data-tipo="privado" @if($datos["logueado"]) href="{{ asset($d['documento']) }}" @endif download>
                        <img style="width: 100%;" src="{{ asset($d['image']) }}" onError="this.src='{{ asset('images/general/no-descarga.fw.png') }}'" class="border d-block" />
                        <p class="w-75 mx-auto mb-1 mt-2 text-center">{{ $d["nombre"] }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push("scripts_distribuidor")
<script>
    const logueado = parseInt(@json($datos["logueado"]));
    descargar = function(t) {
        if($(t).data("tipo") == "privado" && !logueado) {
            if(window.alertt === undefined) {
                window.alertt = 1;
                alertify.notify('Por favor, ingrese a su cuenta para poder acceder a este archivo', 'error', 30, function() {
                    delete window.alertt;
                });
            }
        }
        if($(t).next().attr("href") == "" || $(t).next().attr("href") == "http://ventor.com.ar/descargas" || $(t).next().attr("href") == "http://www.ventor.com.ar/descargas" || t.href == "https://ventor.com.ar/descargas" || t.href == "https://www.ventor.com.ar/descargas")
          return false;

        alertify.confirm("ATENCIÓN","¿Descargar archivo?",
            function() {
                $(t).removeAttr("onclick");

                setTimeout(() => {
                  document.getElementById(t.id).click();
                  $(t).attr("onclick","event.preventDefault(); descargar(this);");
                }, 500);
            },
            function() {}
        ).set('labels', {ok:'Confirmar', cancel:'Cancelar'});
    };

    linkActive = function(t) {
        if(logueado) {
            let doc = $(t).val();
            $(t).prev().removeAttr("disabled");
            $(t).prev().attr("href",doc);
            $(t).prev().click();
        } else {
            if(window.alertt === undefined) {
                window.alertt = 1;
                alertify.notify('Por favor, ingrese a su cuenta para poder acceder a este archivo', 'error', 30, function() {
                    delete window.alertt;
                });
            }
        }
    }
</script>
@endpush
