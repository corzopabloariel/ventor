<div class="wrapper-categorias bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <div class="row justify-content-center">
                    @foreach($datos['categorias'] AS $c)
                    <div class="col-12 col-md-4 col-lg-3 my-3 wrapper-link">
                        <a href="">
                            <div>
                                <img style="filter:{{ $c['hsl'] }}" src="{{ asset($c['image']) }}" onError="this.src='{{ asset('images/general/no-img.png') }}'" alt="{{ $c['nombre'] }}">
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
        $('.wrapper-link a:nth-child(2n + 1)').jAnimate('zoomIn', function(){
            console.log('animation was finished');
        });
    });
</script>
@endpush