<h3 class="title">{{$title}}</h3>

<section class="mt-3">
    <div class="container-fluid">
        <h2 class="title" style="color: #0099D6;">Listas de Precios</h2>
        @php
        $Arr = [];
        $Arr2 = [];
        for($i = 0; $i < count($datos["descargas"]) ; $i++) {
            if($datos["descargas"][$i]["precio"] == 0) {
                if(!isset($Arr2[$datos["descargas"][$i]["did"]])) {
                    $Arr2[$datos["descargas"][$i]["did"]] = [];
                    $Arr2[$datos["descargas"][$i]["did"]]["nombre"] = $datos["descargas"][$i]["nombre"];
                    $Arr2[$datos["descargas"][$i]["did"]]["image"] = $datos["descargas"][$i]["image"];
                    $Arr2[$datos["descargas"][$i]["did"]]["partes"] = [];
                }

                $Arr2[$datos["descargas"][$i]["did"]]["partes"][] = ["parte" => $datos["descargas"][$i]["parte"], "documento" => $datos["descargas"][$i]["documento"]];
                continue;
            }
            if(!isset($Arr[$datos["descargas"][$i]["did"]])) {
                $Arr[$datos["descargas"][$i]["did"]] = [];
                $Arr[$datos["descargas"][$i]["did"]]["nombre"] = $datos["descargas"][$i]["nombre"];
                $Arr[$datos["descargas"][$i]["did"]]["image"] = $datos["descargas"][$i]["image"];
                $Arr[$datos["descargas"][$i]["did"]]["formatos"] = [];
            }
            $Arr[$datos["descargas"][$i]["did"]]["formatos"][] = ["ext" => $datos["descargas"][$i]["formato"], "documento" => $datos["descargas"][$i]["documento"]];
        }
        @endphp
        <div class="row mt-3">
        @foreach($Arr AS $did => $d)
            <div class="col-12 col-md-3 descarga d-flex mt-2 justify-content-center">
                <div class="d-inline-block">
                    <img style="width: 192px;" src="{{ asset($d['image']) }}" onError="this.src='{{ asset('images/general/no-descarga.fw.png') }}'" class="border d-block mx-auto" />
                    <select onchange="linkActive(this)" style="width: 192px" class="mx-auto d-block bg-light p-2 border">
                        <option value="" hidden>Seleccione un archivo</option>
                        @foreach($d["formatos"] AS $f)
                            <option value="{{ asset($f['documento']) }}">Ventor Lista de precios - formato {{ $f["ext"] }} {{ $d["nombre"] }}</option>
                        @endforeach
                    </select>
                    <div class="mt-2">
                        <div class="mx-auto text-center download" style="width: 192px;">
                            <a disabled class="link" download><i class="fas fa-download"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
        <h2 class="title mt-5" style="color: #0099D6;">Catálogos</h2>
        <div class="row mt-3">
        @foreach($Arr2 AS $did => $d)
            <div class="col-12 col-md-3 mt-2 descarga d-flex justify-content-center">
                <div class="d-inline-block">
                    <img style="width: 192px;" src="{{ asset($d['image']) }}" onError="this.src='{{ asset('images/general/no-descarga.fw.png') }}'" class="border d-block mx-auto" />
                    <select onchange="linkActive(this)" style="width: 192px" class="mx-auto d-block bg-light p-2 border">
                        <option value="" hidden>Seleccione un archivo</option>
                        @foreach($d["partes"] AS $f)
                            <option value="{{ asset($f['documento']) }}">{{ $f["parte"] }}</option>
                        @endforeach
                    </select>
                    <div class="row mt-2">
                        <div class="col-6 text-right eye">
                            <a disabled target="blank" class="btn btn-link"><i class="fas fa-eye"></i></a>
                        </div>
                        <div class="col-6 text-left download">
                            <a disabled class="link btn btn-link" download><i class="fas fa-download"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>

        <h2 class="title mt-5" style="color: #0099D6;">Otros catálogos</h2>
        <div class="row mt-3">
            @foreach($datos["descargasO"] AS $d)
                <div class="col-12 col-md-3 mt-2 descarga d-flex justify-content-center">
                    <div class="d-inline-block">
                        <img style="width: 192px;" src="{{ asset($d['image']) }}" onError="this.src='{{ asset('images/general/no-descarga.fw.png') }}'" class="border d-block mx-auto" />
                        <p class="w-75 mx-auto mb-1 mt-2 text-center">{{ $d["nombre"] }}</p>
                        <div class="row">
                            <div class="col-6 text-right eye">
                                <a href="{{ asset($d['documento']) }}" target="blank"><i class="fas fa-eye"></i></a>
                            </div>
                            <div class="col-6 text-left download">
                                <a href="{{ asset($d['documento']) }}" download><i class="fas fa-download"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>