<div class="wrapper-contacto py-5">
    <div class="container mb-5">
        <h3 class="title text-uppercase" style="font-size: 32px; color: #595959; font-weight: 200">Sede ciudad de buenos aires</h3>
        <div class="row numeros">
            @foreach($datos["numeros"] AS $n)
                @if($n["is_vendedor"] == 0)
                @php
                $n["email"] = json_decode($n["email"], true);
                @endphp
                <div class="col-12 col-md-4 col-lg-3 d-flex align-items-stretch mt-2">
                    <article class="article w-100">
                        <p class="title text-uppercase">{{ $n["nombre"] }}</p>
                        <p class="title">{{ $n["persona"] }}</p>
                        @foreach($n["email"] AS $e)
                        <p class="text-truncate"><a href="mailto:{{$e}}">{!!$e!!}</a></p>
                        @endforeach
                        <p><strong>Interno</strong> {{ $n["interno"] }}</p>
                        @if(!empty($n["celular"]))
                            <p><strong>Celular</strong> {{ $n["celular"] }}</p>
                        @endif
                    </article>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="container-fluid mb-2">
        <div class="row">
            <div class="col-12 px-0">
                <iframe src="https://www.google.com/maps/d/embed?mid=1jX6Gl5rvxwMRNP-QFoWdofQHGxWr5zce" class="w-100 border-0" height="480"></iframe>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4">
                <h3 class="title mb-3">Ventor</h3>
                <ul class="list-unstyled info mb-0">
                    <li class="d-flex align-items-start">
                        <i class="fas fa-map-marker-alt"></i>
                        <div class="ml-2">
                            <p class="mb-0">{!! $datos["empresa"]["domicilio"]["calle"] !!} {!! $datos["empresa"]["domicilio"]["altura"] !!}</p>
                            <p class="mb-0">Ciudad Autónoma de Buenos Aires</p>
                        </div>
                    </li>
                    <li class="d-flex align-items-start">
                        <i class="fas fa-phone-volume"></i>
                        <div class="ml-2">
                            @foreach($datos["empresa"]["telefono"]["tel"] as $t)
                                <a title="{{$t}}" class="text-truncate d-block" href="tel:{{$t}}">{!!$t!!}</a>
                            @endforeach
                        </div>
                    </li>
                    <li class="d-flex align-items-start">
                        <i class="far fa-envelope"></i>
                        <div class="ml-2">
                            @foreach($datos["empresa"]["email"] as $e)
                                <a title="{{$e}}" class="text-truncate d-block" href="mailto:{!!$e!!}" target="blank">{!!$e!!}</a>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-md-8">
                <form action="{{ url('/form/contacto') }}" novalidate id="form" onsubmit="event.preventDefault(); enviar(this);" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <input placeholder="Nombre *" required type="text" value="{{ old('nombre') }}" name="nombre" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <input placeholder="Apellido" type="text" value="{{ old('apellido') }}" name="apellido" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <input placeholder="Email *" required type="email" name="email" value="{{ old('email') }}" class="form-control">
                        </div>
                        <div class="col-lg-6 col-12">
                            <input placeholder="Teléfono" type="phone" name="telefono" value="{{ old('telefono') }}" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <textarea name="mensaje" required rows="5" placeholder="Mensaje *" class="form-control">{{ old('mensaje') }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="g-recaptcha" data-sitekey="6Lf8ypkUAAAAAKVtcM-8uln12mdOgGlaD16UcLXK"></div>
                        </div>
                        <div class="col-lg-6 col-12">
                        <div class="form-check">
                            <input class="form-check-input" required data-placeholder="Términos y condiciones" type="checkbox" value="1" name="terminos" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Acepto los términos y condiciones de privacidad
                            </label>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn px-5 text-white text-uppercase">enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src='https://www.google.com/recaptcha/api.js'></script>

<script>

function zfill(number, width) {
    var numberOutput = Math.abs(number); /* Valor absoluto del número */
    var length = number.toString().length; /* Largo del número */ 
    var zero = "0"; /* String de cero */  
    
    if (width <= length) {
        if (number < 0) {
             return ("-" + numberOutput.toString()); 
        } else {
             return numberOutput.toString(); 
        }
    } else {
        if (number < 0) {
            return ("-" + (zero.repeat(width - length)) + numberOutput.toString()); 
        } else {
            return ((zero.repeat(width - length)) + numberOutput.toString()); 
        }
    }
}

validar = function(t, marca = true, visible = true) {
    let flag = 1;
    $(t).find('*[required]').each(function() {
        if($(this).is(":visible")) {
            flagI = true;
            if($(this).attr("type") !== undefined) {
                if($(this).attr("type") == "file" || $(this).attr("type") == "date")
                    flagI = false;
            }
            if(flagI) {
                if($(this).is(":invalid") || $(this).val() == "") {
                    flag = 0;
                    if(marca) $(this).addClass("has-error");
                }
            }
        }
    });
    return flag;
};
validarSTRING = function(t) {
    let string = "";
    $(t).find('*[required]').each(function() {
        if($(this).is(":invalid") || $(this).val() == "") {
            flag = true;
            if($(this).attr("type") !== undefined) {
                if($(this).attr("type") == "file" || $(this).attr("type") == "date")
                    flag = false;
            }
            if(flag) {
                if($(this).is(":invalid") || $(this).val() == "") {
                    if(string != "") string += ", ";
                    if($(this).attr("placeholder") === undefined)
                        string += $(this).data("placeholder");
                    else {
                        t = $(this).attr("placeholder");
                        if(t.indexOf("*") >= 0)
                            t = t.replace(" *","");
                        string += t;
                    }
                }
            }
        }
    });
    return string;
}
enviar = function(t) {
    if(!validar($("#form"))) {
        str = validarSTRING($("#form"));
        alertify.notify(`Complete ${str} para enviar`, 'warning');
        return false;
    }
    document.getElementById("form").submit();
}

</script>

@endpush