<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Trabajo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $archivo)
    {
        $this->nombre = $data["nombre"];
        $this->apellido = $data["telefono"];
        $this->domicilio = $data["domicilio"];
        $this->cp = $data["cp"];
        $this->provincia = $data["provincia"];
        $this->localidad = $data["localidad"];
        $this->nacionalidad = $data["nacionalidad"];
        $this->dni = $data["dni"];
        $this->fecha = $data["fecha"];//nacimiento
        $this->estado = $data["estado"];//civil
        $this->email = $data["email"];
        $this->telefono = $data["telefono"];
        $this->postular = $data["postular"];//OBJ
        //ARRAY
        $this->puesto_trabajos = $data["puesto_trabajos"];
        $this->trabajos_seniority = $data["trabajos_seniority"];
        $this->empresa_trabajos = $data["empresa_trabajos"];
        $this->trabajos_pais = $data["trabajos_pais"];
        $this->industria_trabajos = $data["industria_trabajos"];
        $this->area_trabajos = $data["area_trabajos"];
        $this->actual_trabajos = $data["actual_trabajos"];
        $this->desde_trabajos = $data["desde_trabajos"];
        $this->hasta_trabajos = isset($data["hasta_trabajos"]) ? $data["hasta_trabajos"] : [];
        $this->descripcion_trabajos = $data["descripcion_trabajos"];
        $this->titulo_educacion = $data["titulo_educacion"];
        $this->educacion_pais = $data["educacion_pais"];
        $this->educacion_area = $data["educacion_area"];
        $this->educacion_nivel = $data["educacion_nivel"];
        $this->educacion_estado = $data["educacion_estado"];
        $this->actual_educacion = $data["actual_educacion"];
        $this->desde_educacion = $data["desde_educacion"];
        $this->hasta_educacion = isset($data["hasta_educacion"]) ? $data["hasta_educacion"] : [];
        $this->descripcion_educacion = $data["descripcion_educacion"];
        $this->url_redes = $data["url_redes"];

        $this->remuneracion = $data["remuneracion"];
        $this->mensaje = $data["mensaje"];

        $this->archivo = $archivo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->replyTo($this->email,"{$this->nombre} {$this->apellido}")->subject('Curriculum Vitae')->view('page.form.trabaje')->with([
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'domicilio' => $this->domicilio,
            'cp' => $this->cp,
            'provincia' => $this->provincia,
            'localidad' => $this->localidad,
            'nacionalidad' => $this->nacionalidad,
            'dni' => $this->dni,
            'fecha' => $this->fecha,
            'estado' => $this->estado,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'postular' => $this->postular,
            'puesto_trabajos' => $this->puesto_trabajos,
            'trabajos_seniority' => $this->trabajos_seniority,
            'empresa_trabajos' => $this->empresa_trabajos,
            'empresa_trabajos' => $this->empresa_trabajos,
            'trabajos_pais' => $this->trabajos_pais,
            'area_trabajos' => $this->area_trabajos,
            'actual_trabajos' => $this->actual_trabajos,
            'desde_trabajos' => $this->desde_trabajos,
            'hasta_trabajos' => $this->hasta_trabajos,
            'descripcion_trabajos' => $this->descripcion_trabajos,
            'titulo_educacion' => $this->titulo_educacion,
            'educacion_pais' => $this->educacion_pais,
            'educacion_area' => $this->educacion_area,
            'educacion_nivel' => $this->educacion_nivel,
            'educacion_estado' => $this->educacion_estado,
            'actual_educacion' => $this->actual_educacion,
            'desde_educacion' => $this->desde_educacion,
            'hasta_educacion' => $this->hasta_educacion,
            'descripcion_educacion' => $this->descripcion_educacion,
            'url_redes' => $this->url_redes,
            'remuneracion' => $this->remuneracion,
            'mensaje' => $this->mensaje
        ])->attach($this->archivo->getRealPath(),
        [
            'as' => $this->archivo->getClientOriginalName(),
            'mime' => $this->archivo->getClientMimeType(),
        ]);
    }
}
