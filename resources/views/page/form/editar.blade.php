<!DOCTYPE html>
<html>
<body>
    <table cellspacing="0" border="0" cellpadding="0">
        <tbody>
            <tr>
                <td style="padding:10px; background: #fafafa; text-transform: uppercase;">Dato</td>
                <td style="padding:10px; background: #fafafa; text-transform: uppercase;">actual</td>
                <td style="padding:10px; background: #fafafa; text-transform: uppercase;">Nuevo</td>
            </tr>
            <tr>
                <td style="padding:10px; background: #fafafa; text-transform: uppercase;">EMPRESA</td>
                <td style="padding:10px;" colspan="2">{{$cliente["nombre"]}}</td>
            </tr>
            <tr>
                <td style="padding:10px; background: #fafafa; text-transform: uppercase;">RESPONSABLE</td>
                <td style="padding:10px;" colspan="2">{{$cliente["respon"]}}</td>
            </tr>
            <tr>
                <td style="padding:10px; background: #fafafa; text-transform: uppercase;">DIRECCIÓN</td>
                <td style="padding:10px;">{{$cliente["direcc"]}}</td>
                <td style="padding:10px;">{{$datos["direcc"]}}</td>
            </tr>
            <tr>
                <td style="padding:10px; background: #fafafa; text-transform: uppercase;">LOCALIDAD</td>
                <td style="padding:10px;">{{$cliente->localidad["descrp"]}} ({{$cliente->localidad["codpos"]}})</td>
                <td style="padding:10px;">{{$datos["localidad"]}} ({{$datos["codpos"]}})</td>
            </tr>
            <tr>
                <td style="padding:10px; background: #fafafa; text-transform: uppercase;">PROVINCIA</td>
                <td style="padding:10px;">{{$cliente->localidad["descr_001"]}}</td>
                <td style="padding:10px;">{{$datos["provincia"]}}</td>
            </tr>
            <tr>
                <td style="padding:10px; background: #fafafa; text-transform: uppercase;">TELÉFONO</td>
                <td style="padding:10px;">{{$cliente["telefn"]}}</td>
                <td style="padding:10px;">{{$datos["telefn"]}}</td>
            </tr>
            <tr>
                <td style="padding:10px; background: #fafafa; text-transform: uppercase;">MAIL</td>
                <td style="padding:10px;">{{$cliente["direml"]}}</td>
                <td style="padding:10px;">{{$datos["email"]}}</td>
            </tr>
            <tr>
                <td style="padding:10px; background: #fafafa; text-transform: uppercase;">WHATSAPP</td>
                <td style="padding:10px;">{{$cliente["whatsapp"]}}</td>
                <td style="padding:10px;">{{$datos["whatsapp"]}}</td>
            </tr>
            <tr>
                <td style="padding:10px; background: #fafafa; text-transform: uppercase;">INSTAGRAM</td>
                <td style="padding:10px;">{{$cliente["instagram"]}}</td>
                <td style="padding:10px;">{{$datos["instagram"]}}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>