<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Storage;


class PedidoM extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mensaje, $title, $archivo)
    {
        $this->mensaje = $mensaje;
        $this->archivo = $archivo;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)->view('page.form.pedido')->with([
            'mensaje' => $this->mensaje
        ])->attach($this->archivo, ['as' => 'PEDIDO.xls']);
    }
}
