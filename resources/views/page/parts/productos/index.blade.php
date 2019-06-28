<div class="wrapper-categorias bg-white">
    <div class="container">
        <div class="row justify-content-center buscador">
            <div class="col-12 col-md-6">
                <form class="position-relative d-flex" action="{{ url('/buscador/body') }}" method="post">
                    @csrf
                    <button type="submit" class="btn"><i class="fas fa-search"></i></button>
                    <input placeholder="Buscar producto..." type="text" name="buscar" id="" class="form-control">
                </form>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <div class="row justify-content-center">
                    @foreach($datos['categorias'] AS $c)
                    <div class="col-12 col-md-4 col-lg-3 my-3 wrapper-link wow zoomIn">
                        <a href="{{ URL::to('productos/' . $c['id']) }}">
                            <div>
                                <img src="{{ asset($c['image']) }}" onError="this.src='{{ asset('images/general/no-img.png') }}'" alt="{{ $c['nombre'] }}">
                            </div>
                            <p class="mb-0 text-center">{{ $c['nombre'] }}</p>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@push("scripts_distribuidor")
<script>
    $(document).ready(function() {
        $('.wrapper-link a:nth-child(2n + 1)').jAnimate('', function(){
            console.log('animation was finished');
        });
    });
</script>
@endpush