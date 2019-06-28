<!DOCTYPE html>
<html>
<body>
    <p><strong>NOMBRE Y APELLIDO:</strong> {{$nombre}} {{$apellido}}</p>
    <p><strong>TELÉFONO:</strong> {{$telefono}}</p>
    <p><strong>DOMICILIO:</strong> {{$domicilio}}, CP: {{$cp}}</p>
    <p><strong>PROVINCIA:</strong> {{$provincia}}, {{$localidad}}</p>
    <p><strong>NACIONALIDAD:</strong> {{$nacionalidad}}</p>
    <p><strong>FECHA DE NACIMIENTO:</strong> {{$fecha}}</p>
    <p><strong>ESTADO CIVIL:</strong> {{$estado}}</p>
    @php                            
    $Arr_postular = [ "vendedor" => "Vendedor en Zona", "atencionCliente" => "Atención al cliente (CABA)", "administracionCABA" => "Administración (CABA)", "otroCABA" => "Otro (CABA)", "produccion" => "Producción" ];
    $Arr_correa = [ "v" => "Correas en V", "sincronica" => "Correas Sincrónicas" ];
    @endphp
    <p>
        <strong>RUBROS:</strong><br/>
        @php
        $postulaciones = "";
        for($i = 0 ; $i < count($postular) ; $i++) {
            if(!empty($postulaciones)) $postulaciones .= " / ";
            $postulaciones .= $Arr_postular[$postular[$i]];
        }
        echo empty($postulaciones) ? "Sin seleccionar" : $postulaciones;
        @endphp
    </p>
    @php
    $seniority = ["senior" => "Senior","semisenior" => "Semi senior","junior" => "Junior"];
    $trabajos = "";
    for($i = 0 ; $i < count($puesto_trabajos) ; $i++) {
        $trabajo = "";
        if(empty($puesto_trabajos[$i])) continue;
        if(!empty($trabajos)) $trabajos .= "<hr/>";
        $T_seniority = $T_empresa = $T_pais = $T_industria = $T_area = $T_desde = $T_hasta = $T_descripcion = "Sin seleccionar";
        if(!empty($trabajos_seniority[$i]))
            $T_seniority = $seniority[$trabajos_seniority[$i]];
        if(!empty($empresa_trabajos[$i]))
            $T_empresa = $empresa_trabajos[$i];
        if(!empty($trabajos_pais[$i]))
            $T_pais = $trabajos_pais[$i];
        if(!empty($industria_trabajos[$i]))
            $T_industria = $industria_trabajos[$i];
        if(!empty($area_trabajos[$i]))
            $T_area = $area_trabajos[$i];
        if(!empty($desde_trabajos[$i]))
            $T_desde = $desde_trabajos[$i];
        if(!empty($hasta_trabajos[$i]))
            $T_hasta = $hasta_trabajos[$i];
        if(isset($actual_trabajos[$i]))
            $T_hasta = "Actualmente trabajo aquí";
        if(!empty($descripcion_trabajos[$i]))
            $T_descripcion = $descripcion_trabajos[$i];
        $trabajo .= '<table style="width:100%;border-collapse: collapse;">';
            $trabajo .= '<tr>';
                $trabajo .= "<td>Nombre del puesto / Título<br/>{$puesto_trabajos[$i]}</td>";
                $trabajo .= "<td>Nivel Seniority<br/>{$T_seniority}</td>";
            $trabajo .= '</tr>';
            $trabajo .= '<tr>';
                $trabajo .= "<td>Nombre de Empresa / Negocio<br/>{$T_empresa}</td>";
                $trabajo .= "<td>País<br/>{$T_pais}</td>";
            $trabajo .= '</tr>';
            $trabajo .= '<tr>';
                $trabajo .= "<td>Tipo de Industria<br/>{$T_industria}</td>";
                $trabajo .= "<td>Área de Trabajo<br/>{$T_area}</td>";
            $trabajo .= '</tr>';
            $trabajo .= '<tr>';
                $trabajo .= "<td>Desde<br/>{$T_desde}</td>";
                $trabajo .= "<td>Hasta<br/>{$T_hasta}</td>";
            $trabajo .= '</tr>';
            $trabajo .= '<tr>';
                $trabajo .= "<td colspan='2'>Descripción<br/>{$T_descripcion}</td>";
            $trabajo .= '</tr>';
        $trabajo .= '</table>';
        $trabajos .= $trabajo;
    }
    if(!empty($trabajos))
        echo "<fieldset style='padding: 10px; border: 1px solid;'><legend>Trabajos</legend>{$trabajos}</fieldset>";

    $Arr_areas = ["sociales" => "Ciencias Sociales, del Comportamiento, de la Comunicación, Administración, Trabajo y Derecho", "ingenieria" => "Ingeniería, Tecnología, Industria, Arquitectura y Construcción", "salud" => "Ciencias de la Salud y Servicios Sociales", "arte" => "Artes y humanidades", "vida" => "Ciencias de la Vida, de la Tierra, del Espacio, Químicas, Físicas y Exactas", "pedagodia" => "Pedagogía", "servicios" => "Turismo, Hostelería, Deportes, Belleza, Transporte, Medio Ambiente y Seguridad", "agronomia" => "Agronomía, Agricultura, Ganadería, Pesca y Veterinaria"];
    $educaciones = "";
    for($i = 0 ; $i < count($titulo_educacion) ; $i ++) {
        $educacion = "";
        if(empty($titulo_educacion[$i])) continue;
        if(!empty($educaciones)) $educaciones .= "<hr/>";
        $T_titulo = $T_area = $T_pais = $T_nivel = $T_area = $T_estado = $T_desde = $T_hasta = $T_descripcion = "Sin seleccionar";
        if(!empty($titulo_educacion[$i]))
            $T_titulo = $titulo_educacion[$i];
        if(!empty($educacion_area[$i]))
            $T_area = $Arr_areas[$educacion_area[$i]];
        if(!empty($educacion_pais[$i]))
            $T_pais = $educacion_pais[$i];
        if(!empty($educacion_nivel[$i]))
            $T_nivel = $educacion_nivel[$i];
        if(!empty($area_trabajos[$i]))
            $T_area = $area_trabajos[$i];
        if(!empty($educacion_estado[$i]))
            $T_estado = $educacion_estado[$i];
        if(!empty($desde_educacion[$i]))
            $T_desde = $desde_educacion[$i];
        if(!empty($hasta_educacion[$i]))
            $T_hasta = $hasta_educacion[$i];
        if(isset($actual_educacion[$i]))
            $T_hasta = "Actualmente asisto aquí";
        if(!empty($descripcion_educacion[$i]))
            $T_descripcion = $descripcion_educacion[$i];

        $educacion .= '<table style="width:100%;border-collapse: collapse;">';
            $educacion .= '<tr>';
                $educacion .= "<td>Título<br/>{$titulo_educacion[$i]}</td>";
                $educacion .= "<td>País<br/>{$T_pais}</td>";
            $educacion .= '</tr>';
            $educacion .= '<tr>';
                $educacion .= "<td style='width: 33.33%'>Área de Estudio<br/>{$T_area}</td>";
                $educacion .= "<td style='width: 33.33%'>Nivel de Estudio<br/>{$T_nivel}</td>";
                $educacion .= "<td style='width: 33.33%'>Estado de Estudio<br/>{$T_estado}</td>";
            $educacion .= '</tr>';
            $educacion .= '<tr>';
                $educacion .= "<td>Tipo de Industria<br/>{$T_industria}</td>";
                $educacion .= "<td>Área de Trabajo<br/>{$T_area}</td>";
            $educacion .= '</tr>';
            $educacion .= '<tr>';
                $educacion .= "<td>Desde<br/>{$T_desde}</td>";
                $educacion .= "<td>Hasta<br/>{$T_hasta}</td>";
            $educacion .= '</tr>';
            $educacion .= '<tr>';
                $educacion .= "<td colspan='2'>Descripción<br/>{$T_descripcion}</td>";
            $educacion .= '</tr>';
        $educacion .= '</table>';
        $educaciones .= $educacion;
    }
    
    if(!empty($educaciones))
        echo "<fieldset style='padding: 10px; border: 1px solid;'><legend>Educación</legend>{$educaciones}</fieldset>";

    $redes = "";
    for($i = 0; $i < count($url_redes); $i ++) {
        if(empty($url_redes[$i])) continue;
        $redes .= "<p><a href='{$url_redes[$i]}' target='blank'>{$url_redes[$i]}</a></p>";
    }
    if(!empty($redes))
        echo "<fieldset style='padding: 10px; border: 1px solid;'><legend>Redes Sociales</legend>{$redes}</fieldset>";
    
    if(empty($remuneracion))
        $remuneracion = "No ingresado";
    else {
        if(is_numeric($remuneracion))
        $remuneracion = "$" . number_format($remuneracion,0,",",".");
    }
    echo "<p><strong>REMUNERACIÓN:</strong> {$remuneracion}</p>";
    @endphp
    @if(!empty($mensaje))
    <p><strong>MENSAJE:</strong> {{ $mensaje }}</p>
    @endif
</body>
</html>