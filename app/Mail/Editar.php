<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Editar extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->cliente = $data["cliente"];
        $this->datos = $data["datos"];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->replyTo($this->cliente["direml"],"{$this->cliente["nombre"]}")->subject('*** MODIFICACIÓN DE DATOS ***')->view('page.form.editar')->with([
            'cliente' => $this->cliente,
            'datos' => $this->datos,
        ]);
    }
}
