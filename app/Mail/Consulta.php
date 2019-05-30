<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Consulta extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->empresa = $data["empresa"];
        $this->email = $data["email"];
        $this->telefono = $data["telefono"];
        $this->localidad = $data["localidad"];
        $this->mensaje = $data["mensaje"];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->replyTo($this->email,$this->empresa)->subject('Consulta general')->view('page.form.consulta')->with([
            'empresa' => $this->empresa,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'localidad' => $this->localidad,
            'mensaje' => $this->mensaje
        ]);
    }
}
