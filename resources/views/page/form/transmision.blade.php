<!DOCTYPE html>
<html>
<body>
    <p><strong>NOMBRE Y APELLIDO:</strong> {{$nombre}}</p>
    <p><strong>TELÉFONO:</strong> {{$telefono}}</p>
    <p><strong>DOMICILIO:</strong> {{$domicilio}}, {{$localidad}}</p>
    <p><strong>EMAIL:</strong> {{$email}}</p>
    <br/>
    @php
    $Arr_transmision = [ "nueva" => "Transmisión Nueva", "existente" => "Transmisión Existente" ];
    $Arr_correa = [ "v" => "Correas en V", "sincronica" => "Correas Sincrónicas" ];
    @endphp
    <p><strong>TIPO DE TRANSMISIÓN:</strong> {{ $Arr_transmision[$transmision] }}</p>
    <p><strong>TIPO DE CORREAS:</strong> {{ $Arr_correa[$correa]}}</p>
    <br/>
    <p><strong>POTENCIA:</strong> {{$potencia}}</p>
    <p><strong>FACTOR DE SERVICIO:</strong> {{$factor}}</p>
    <p><strong>RPM POLEA MOTOR:</strong> {{$poleaMotor}}</p>
    <p><strong>RPM POLEA CONDUCIDA:</strong> {{$poleaConducida}}</p>
    
    <p><strong>ENTRE CENTRO:</strong></p>
    <ul>
        <li>MIN: {{$centroMin}}</li>
        <li>MAX: {{$centroMax}}</li>
    </ul>
    <br/>
    <p><strong>MENSAJE:</strong> {{ $mensaje }}</p>
    <br/>
    <p><strong>PREFERENCIA POR ALGÚN PERFIL:</strong> {{ $perfil }}</p>
</body>
</html>