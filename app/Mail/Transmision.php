<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Transmision extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->nombre = $data["nombre"];
        $this->telefono = $data["telefono"];
        $this->domicilio = $data["domicilio"];
        $this->localidad = $data["localidad"];
        $this->email = $data["email"];
        $this->transmision = $data["transmision"];
        $this->correa = $data["correa"];
        $this->potencia = $data["potencia"];
        $this->factor = $data["factor"];
        $this->poleaMotor = $data["poleaMotor"];
        $this->poleaConducida = $data["poleaConducida"];
        $this->centroMin = $data["centroMin"];
        $this->centroMax = $data["centroMax"];
        $this->mensaje = $data["mensaje"];
        $this->perfil = $data["perfil"];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->replyTo($this->email,$this->nombre)->subject('Análisis de Transmisión')->view('page.form.transmision')->with([
            'nombre' => $this->nombre,
            'telefono' => $this->telefono,
            'domicilio' => $this->domicilio,
            'localidad' => $this->localidad,
            'email' => $this->email,
            'transmision' => $this->transmision,
            'correa' => $this->correa,
            'potencia' => $this->potencia,
            'factor' => $this->factor,
            'poleaMotor' => $this->poleaMotor,
            'poleaConducida' => $this->poleaConducida,
            'centroMin' => $this->centroMin,
            'centroMax' => $this->centroMax,
            'mensaje' => $this->mensaje,
            'perfil' => $this->perfil
        ]);
    }
}
