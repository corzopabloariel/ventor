<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Storage;


class Pedido extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mensaje, $archivo)
    {
        $this->mensaje = $mensaje;
        $this->archivo = $archivo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //$this->archivo = Storage::disk('public')->path($this->archivo->file('document')->store('folder', 'public'));

        return $this->view('page.form.pedido')->with([
            'mensaje' => $this->mensaje
        ])->attach($this->archivo, ['as' => 'PEDIDO.xls']);
    }
}
