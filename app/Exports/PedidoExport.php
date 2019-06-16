<?php

namespace App\Exports;

use DB;
use Cookie;
use Maatwebsite\Excel\Concerns\{WithHeadings, WithMapping, FromCollection, Exportable};
use Illuminate\Database\Eloquent\Collection;

class PedidoExport implements FromCollection, WithHeadings
{
    public function __construct() {}
    public function headings(): array
    {
        return [
            'exp_1',
            'exp_2',
            'cod',
            'exp_4',
            'cnt',
            'precio',
            'bonif1',
            'bonif2',
            'observ',
            'cliente',
            'destrp',
            'dirtrp',
            'idpedido'
        ];
    }

    public function collection()
    {
        $pedido_id = Cookie::get("pedido");
        //$pedido_id = 2038;
        $pedido = DB::table('pedidos')
            ->join('pedidoproductos', 'pedidos.id', '=', 'pedidoproductos.pedido_id')
            ->join('productosventor', 'pedidoproductos.producto_id', '=', 'productosventor.id')
            ->join('clientesventor', 'pedidos.cliente_id', '=', 'clientesventor.id')
            ->join('transportesventor', 'pedidos.transporte_id', '=', 'transportesventor.id')
            //->leftJoin('vendedoresventor', 'pedidos.vendedor_id', '=', 'vendedoresventor.id')
            //->leftJoin('users', 'pedidos.usuario_id', '=', 'users.id')
            ->select(
                'pedidos.exp_1',
                'pedidos.exp_2',
                'productosventor.stmpdh_art AS cod',
                'pedidos.exp_4',
                'pedidoproductos.cnt',
                'productosventor.precio',
                'pedidos.bonif1',
                'pedidos.bonif2',
                'pedidoproductos.observ',
                'clientesventor.nrocta AS cliente',
                'transportesventor.descrp AS destrp',
                'transportesventor.tradir AS dirtrp',
                'pedidos.id AS idpedido')
            ->where('pedidos.id', $pedido_id)
            ->get();

        return $pedido;
    }

    public function startCell(): string
    {
        return 'B2';
    }
    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @return bool
     */
    private function hasRows(): bool
    {
        return $this->worksheet->cellExists('A1');
    }
}
