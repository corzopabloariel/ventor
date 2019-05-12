<div class="wrapper-contacto py-5">
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
                <form action="{{ url('/form/contacto') }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <input placeholder="Nombre" required type="text" value="{{ old('nombre') }}" name="nombre" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <input placeholder="Apellido" required type="text" value="{{ old('apellido') }}" name="apellido" class="form-control">
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
                            <textarea name="mensaje" required rows="5" placeholder="Mensaje" class="form-control">{{ old('mensaje') }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="g-recaptcha" data-sitekey="6Lf8ypkUAAAAAKVtcM-8uln12mdOgGlaD16UcLXK"></div>
                        </div>
                        <div class="col-lg-6 col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="terminos" id="defaultCheck1">
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
@endpush