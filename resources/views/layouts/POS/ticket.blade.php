<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sale Ticket</title>
</head>

<body>
    <div style="text-align: center;">
        <img style="width:125px" src="{{ asset('images/logo.png') }}">
        <h5 style="font-weight: bold">Folio de venta: {{$sale->id}} </h5>
        <h5>{{$sale->company_name}}</h5>
        <h5>Sucursal: {{$sale->branch_name}}</h5>
        <h5>Direccion: {{$sale->branch_address}}</h5>
        <h5>Telefono: {{$sale->branch_phone}}</h5>
        <h5>Fecha: {{$sale->formatted_created_at}}</h5>
        <h5>Atendió: {{ $sale->user_name  }}</h5>
        <h5>Venta a: {{ $sale->customer_name }}</h5>
         <table style=" margin-left: auto; margin-right: auto;">
                <tr>
                    <th style="margin: 0 10px 0 10px; font-size: 13px;">Producto</th>
                    <th style="margin: 0 10px 0 10px; font-size: 13px;">Cant.</th>
                    <th style="margin: 0 10px 0 10px; font-size: 13px;">Prec.</th>
                    <th style="margin: 0 10px 0 10px; font-size: 13px;">Sub.</th>
                </tr>
                @foreach ($sale->sale_formatt_details as $product)
                    <tr>
                        <td style="text-align: left; font-size: 12px; font-weight: bold"> {{ substr($product['product_name'], 0, 20) }}</td>
                        <td>{{ $product['quantity'] }}</td>
                        <td>{{ $product['price'] }}</td>
                        <td>{{ $product['subtotal'] }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="4" style="height:10px">
                        <td></td>
                </tr>
                <tr style="margin-top: 20px">
                    <th style="text-align: right; font-size: 15px;" colspan="4">Total: {{$sale->formatted_total_sale}}</th>
                </tr>              
            </table> 
            <hr>
            <div style="text-align: center; margin-top:10px">
                <h5 style="font-size: 18px;">Tipo de venta: {{$sale->sale_type_name}}</h5>
                <h5 style="font-size: 18px;">Metodo de pago: {{$sale->payment_method_name}}</h5>
                @if($sale->payment_method_name == 'Efectivo')
                <h5 style="font-size: 18px;">Cantidad recibida: ${{ number_format($sale->received_amount, 2, '.', ',')}} </h5>                
                @endif
                @if($sale->payment_method_name == 'Tarjeta')
                <h5 style="font-size: 18px;">Codigo de referencia : {{$sale->reference_code}}</h5>                
                @endif
                <h5 style="font-size: 18px;">Estado de la venta: {{$sale->sale_status_name}}</h5>
                <h5 style="font-size: 18px; margin-top:10px ">¡ GRACIAS POR SU COMPRA !</h5>
            </div>

            <div style="text-align: center; margin-top:10px">
                <h5 style="font-size: 18px; ">¡ Powered by: Hidrosoft.test visit us!</h5>
            </div>
    </div>
</body>

</html>

<style>
    h5{
        margin: 0;
        padding: 0;
        font-weight: normal
    }
    .reference{
        margin: 0;
        padding: 0;
        font-size: 15px;
        font-weight: bold;
    }

    p {
        margin: 0;
        padding: 0;
        font-size: 15px;
    }

    div p {
        margin: 0;
        padding: 0;
        font-size: 15px;
        font-weight: bold;
    }

    td {
        border-bottom: 1px solid #ddd;
    }

    body {
        margin: 0;
        padding: 0;
    }
</style>
