<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Pago</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .logo { width: 150px; }
        .title { font-size: 24px; font-weight: bold; }
        .recibo-info { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .recibo-info th, .recibo-info td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .recibo-info th { background-color: #f4f4f4; }
        .footer { text-align: center; margin-top: 30px; font-size: 14px; }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('images/logo_empresa.png') }}" class="logo">
        <p class="title">Recibo de Pago</p>
    </div>

    <table class="recibo-info">
        <tr>
            <th>Recibo No:</th>
            <td>{{ $recibo->numero_recibo }}</td>
        </tr>
        <tr>
            <th>Recibido de:</th>
            <td>{{ $recibo->recibido_de }}</td>
        </tr>
        <tr>
            <th>Concepto:</th>
            <td>{{ $recibo->concepto }}</td>
        </tr>
        <tr>
            <th>Total:</th>
            <td>Bs. {{ number_format($recibo->total, 2) }}</td>
        </tr>
        <tr>
            <th>A cuenta:</th>
            <td>Bs. {{ number_format($totalAbonado, 2) }}</td>
        </tr>
        <tr>
            <th>Saldo:</th>
            <td>Bs. {{ number_format($recibo->saldo, 2) }}</td>
        </tr>
        <tr>
            <th>Estado:</th>
            <td>{{ $recibo->estado }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Gracias por su pago</p>
    </div>

</body>
</html>
