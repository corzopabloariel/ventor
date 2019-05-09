<li class="list-group-item border-0">
    <span class="d-block position-relative  @isset($dato['active']) active @endisset" data-id="{{$dato['id']}}">
        <a class="d-block" href="{{ URL::to('productos/'. $dato['id']) }}">{{$dato["nombre"]}}</a>
    </span>
    @if(count($dato["hijos"]) > 0)
        <ul class="list-group list-group-flush">
        @foreach ($dato["hijos"] AS ${"dato_". $dato["id"]})
            @include('page.parts.productos._menuItem', ["dato" => ${"dato_". $dato["id"]}])
        @endforeach
        </ul>
    @endif
</li>