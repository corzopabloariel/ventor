<!DOCTYPE html>
<html>
<body>
    <p>Email automático generado por cambio de contraseña</p>
    <p><strong>EMPRESA:</strong> {{$usuario["name"]}}</p>
    <p><strong>E-MAIL:</strong> @if(empty($usuario["name"])) SIN DATO @else <a href="mailto:{{$usuario['email']}}">{{$usuario['email']}}</a> @endif</p>
    <p><strong>RESPONSABLE:</strong> {{$usuario->cliente["respon"]}}</p>
    <p><strong>DIRECCIÓN:</strong> {{$usuario->cliente["direcc"]}}</p>
    <p><strong>LOCALIDAD:</strong> {{$usuario->cliente->localidad["descrp_001"]}}, {{$usuario->cliente->localidad["descrp"]}} ({{$usuario->cliente->localidad["codpos"]}})</p>
</body>
</html>