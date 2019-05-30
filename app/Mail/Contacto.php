<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Contacto extends Mailable
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
        $this->apellido = $data["apellido"];
        $this->email = $data["email"];
        $this->telefono = $data["telefono"];
        $this->mensaje = $data["mensaje"];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->replyTo($this->email,"{$this->nombre} {$this->apellido}")->subject('Contacto')->view('page.form.contacto')->with([
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'mensaje' => $this->mensaje
        ]);
    }
}
