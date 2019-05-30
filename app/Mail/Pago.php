<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Pago extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->nroCliente = $data["nroCliente"];
        $this->razon = $data["razon"];
        $this->fecha = $data["fecha"];
        $this->importe = $data["importe"];
        $this->banco = $data["banco"];
        $this->sucursal = $data["sucursal"];
        $this->facturas = $data["facturas"];
        $this->descuento = $data["descuento"];
        $this->observaciones = $data["observaciones"];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Informe de Pago')->view('page.form.pago')->with([
            'nroCliente' => $this->nroCliente,
            'razon' => $this->razon,
            'fecha' => $this->fecha,
            'importe' => $this->importe,
            'banco' => $this->banco,
            'sucursal' => $this->sucursal,
            'facturas' => $this->facturas,
            'descuento' => $this->descuento,
            'observaciones' => $this->observaciones
        ]);
    }
}
