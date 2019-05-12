<div class="wrapper-descargas py-5">
    <div class="container">
        <h2 class="title text-uppercase">información adicional</h2>
        <h4>Descargas e instructivos</h4>

        <div class="row mt-3">
            @foreach($datos["descargas"] AS $d)
                <div class="col-12 col-md-3 descarga d-flex justify-content-center">
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
</div>