<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recibo de Pago - Fitrium</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Configuración de página para PDF */
        @page {
            margin: 0;
            padding: 0;
            size: 80mm 150mm;
            /* Tamaño personalizado para recibo (80x150mm) */
            background-color: #f5f5f5;
            /* Fondo gris para toda la página */
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 5mm;
            width: 70mm;
            /* 80mm - 10mm de márgenes (5mm cada lado) */
            height: 140mm;
            /* 150mm - 10mm de márgenes */
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .receipt-container {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            background-color: white;
            border-radius: 10px;
            /* Esquinas redondeadas */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* Sombra sutil */
            overflow: hidden;
            /* Para que el border-radius funcione */
            position: relative;
        }

        /* Logo de fondo tenue */
        .receipt-container::before {
            content: "";
            background-image: url("{{ public_path('inicio/images/11 (3).jpg') }}");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 40%;
            opacity: 0.08;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
        }

        .header {
            background-color: #2c3e50;
            color: white;
            padding: 8px;
            text-align: center;
            border-bottom: 4px solid #e74c3c;
            margin-bottom: 5px;
            position: relative;
            z-index: 1;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            letter-spacing: 1px;
        }

        .header p {
            margin: 3px 0 0;
            font-size: 12px;
            opacity: 0.9;
        }

        .business-info {
            padding: 5px 0;
            font-size: 10px;
            line-height: 1.3;
            text-align: center;
            border-bottom: 1px dashed #ddd;
            margin-bottom: 5px;
            position: relative;
            z-index: 1;
        }

        .receipt-title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin: 5px 0;
            color: #2c3e50;
            position: relative;
            z-index: 1;
        }

        .receipt-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .date,
        .amount {
            text-align: center;
        }

        .date span,
        .amount span {
            font-size: 10px;
            color: #7f8c8d;
            display: block;
        }

        .date .day-month-year {
            font-size: 12px;
            font-weight: bold;
        }

        .amount .value {
            font-size: 18px;
            font-weight: bold;
            color: #27ae60;
        }

        .receipt-number {
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            margin: 3px 0 8px;
            position: relative;
            z-index: 1;
        }

        .details {
            font-size: 11px;
            flex-grow: 1;
            position: relative;
            z-index: 1;
            padding: 0 10px;
        }

        .detail-row {
            display: flex;
            margin-bottom: 5px;
        }

        .detail-label {
            font-weight: bold;
            width: 35%;
            color: #2c3e50;
        }

        .detail-value {
            width: 65%;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            padding: 10px;
            border-top: 1px dashed #ddd;
            position: relative;
            z-index: 1;
            background-color: rgba(255, 255, 255, 0.7);
        }

        .signature {
            font-style: italic;
            margin: 5px 0;
        }

        .logo {
            width: 50px;
            height: auto;
            margin-bottom: 3px;
        }

        .icon {
            width: 12px;
            height: 12px;
            margin-right: 5px;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <div class="header">
            <img src="{{ public_path('inicio/images/11 (3).jpg') }}" width="80" class="logo" alt="Logo Fitrium">
            <h1>FITRUM</h1>
            <p>FITNESS-CLUB</p>
        </div>

        <div class="business-info">
            <div><img src="{{ public_path('inicio/images/Facebook_Logo_(2019).png') }}" width="80" class="icon"> Fitrium Fitness - Club</div>
            <div><img src="{{ public_path('inicio/images/ubicacion.png') }}" width="80" class="icon"> Av. Fabril entre calle Perú. Montero, Santa Cruz - Bolivia</div>
            <div><img src="{{ public_path('inicio/images/Imagen1.png') }}" width="80" class="icon"> 75018746</div>
        </div>



        <div class="receipt-title">RECIBO</div>

        <div class="receipt-info">
            <div class="date">
                <span>DIA MES ANO</span>
                <div class="day-month-year">{{ date('d | m | Y') }}</div>
            </div>
            <div class="amount">
                <span>Bs.</span>
                <div class="value">{{ number_format($recibo->total, 2) }}</div>
            </div>
        </div>

        <div class="receipt-number">N° {{ $recibo->numero_recibo }}</div>

        <div class="details">
            <div class="detail-row">
                <div class="detail-label">Recibí de:</div>
                <div class="detail-value">{{ $recibo->recibido_de }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Por concepto de:</div>
                <div class="detail-value">{{ $recibo->concepto }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">A cuenta:</div>
                <div class="detail-value">Bs. {{ number_format($totalAbonado, 2) }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Saldo:</div>
                <div class="detail-value">Bs. {{ number_format($recibo->saldo, 2) }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Estado:</div>
                <div class="detail-value">{{ $recibo->estado }}</div>
            </div>
        </div>

        <div class="footer">


            <div>Gracias por su pago</div>
        </div>
    </div>
</body>

</html>