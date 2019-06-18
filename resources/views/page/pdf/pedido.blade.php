<!DOCTYPE html>
<html>
    <head>
        <title>Pedido {{ $title }}</title>
        <style type="text/css">
            body{
                font-size: 16px;
                font-family: "Arial";
            }
            table{
                border-collapse: collapse;
            }
        </style>
    </head>
    <body>
        <table width="100%">
            <tr>
                <td width="50%">
                    <img id="logo" style="width: 300px; display: block;" src="{{ $empresa['images']['logo'] }}"/>
                </td>
                <td width="50%" style="text-align: right;">
                @php
                $fecha = date("d/m/Y H:i:s",strtotime($pedido["autofecha"]));
                echo "ID Pedido: {$pedido["id"]}<br/>";
                echo "Fecha: {$fecha}";
                @endphp
                </td>
            </tr>
        </table>
        @php
        $total = 0;
        @endphp
        <table width="100%" style="margin-top:15px;">
            <tbody>
            <tr>
                <td style="border-bottom: 2px solid #dee2e6; border-top: 1px solid #dee2e6; color: #0099D8; padding: .75rem; background: #F2F2F2; width:30%; text-transform: uppercase">Producto</td>
                <td style="border-bottom: 2px solid #dee2e6; border-top: 1px solid #dee2e6; color: #0099D8; padding: .75rem; background: #F2F2F2; width:15%; text-transform: uppercase">Categoría</td>
                <td style="border-bottom: 2px solid #dee2e6; border-top: 1px solid #dee2e6; color: #0099D8; padding: .75rem; background: #F2F2F2; text-align:right; width:20%; text-transform: uppercase">P. unitario</td>
                <td style="border-bottom: 2px solid #dee2e6; border-top: 1px solid #dee2e6; color: #0099D8; padding: .75rem; background: #F2F2F2; text-align:center; width:15%; text-transform: uppercase">cantidad</td>
                <td style="border-bottom: 2px solid #dee2e6; border-top: 1px solid #dee2e6; color: #0099D8; padding: .75rem; background: #F2F2F2; text-align:right; width:20%; text-transform: uppercase">subtotal</td>
            </tr>
            @foreach($productos AS $p)
            <tr>
                <td style="border-top: 1px solid #dee2e6; padding: .75rem;">
                    <p style="color: #C01939">{{ $p->producto["stmpdh_art"] }}</p>
                    <p>{!! $p->producto["stmpdh_tex"] !!}</p>
                </td>
                <td style="border-top: 1px solid #dee2e6; padding: .75rem;">{!! $p->producto->parte_id() !!}</td>
                <td style="border-top: 1px solid #dee2e6; padding: .75rem; text-align:right">{{ "$ " . $p->producto->getPrecio() }}</td>
                <td style="border-top: 1px solid #dee2e6; padding: .75rem; text-align:center">{{$p->cnt}}</td>
                <td style="border-top: 1px solid #dee2e6; background: #fdfdfd; padding: .75rem; text-align:right">
                @php
                $subtotal = $p->cnt * $p->producto->precio;
                $total += $subtotal;
                echo "$" . number_format($subtotal,2,",",".");
                @endphp
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" style="border-top: 1px solid #000; padding: .75rem; text-align:right; font-size: 20px;"></td>
                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000; background: #fdfdfd; padding: .75rem; text-align:left; font-size: 20px;">
                <span>Total</span>
                </td>
                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000; background: #fdfdfd; padding: .75rem; text-align:right; font-size: 20px;">
                    @php
                    echo "$" . number_format($total,2,",",".");
                    @endphp
                </td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="2" style="padding: .75rem;">
                    <small style="color: #C01939">El total no incluye IVA ni impuestos internos</small>
                </td>
            </tr>
            </tbody>
        </table>
    </body>
</html>