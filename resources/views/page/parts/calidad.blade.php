<div class="wrapper-calidad py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="title">{{ $datos["contenido"]["principal"]["titulo"] }}</h2>
                <h4 class="title">{{ $datos["contenido"]["principal"]["subtitulo"] }}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                {!! $datos["contenido"]["principal"]["texto"] !!}
            </div>
            <div class="col-12 col-md-6 d-flex align-items-top slogan">
                {!! $datos["contenido"]["principal"]["slogan"] !!}
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="list-group list-group-horizontal" role="tablist">
                    <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">{{ $datos["contenido"]["calidad"]["titulo"] }}</a>
                    <a class="list-group-item list-group-item-action" id="list-home-list2" data-toggle="list" href="#list-home2" role="tab" aria-controls="home2">{{ $datos["contenido"]["garantia"]["titulo"] }}</a>
                </div>
            </div>
            <div class="col-12">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                        <p class="title">{{ $datos["contenido"]["calidad"]["titulo"] }}</p>
                        {!! $datos["contenido"]["calidad"]["texto"] !!}
                    </div>
                    <div class="tab-pane fade" id="list-home2" role="tabpanel" aria-labelledby="list-profile-list">
                        <p class="title">{{ $datos["contenido"]["garantia"]["titulo"] }}</p>
                        {!! $datos["contenido"]["garantia"]["texto"] !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>