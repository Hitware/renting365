<!DOCTYPE html>
<html>
<head>
    <title>Proyección de Pagos - {{ $contract->contract_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #EA580C; padding-bottom: 20px; }
        .header h1 { color: #EA580C; margin: 0; }
        .info-section { margin-bottom: 20px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .info-label { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #EA580C; color: white; padding: 10px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .summary { margin-top: 30px; background-color: #FFF7ED; padding: 15px; border-radius: 5px; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 8px; }
        .total { font-size: 18px; font-weight: bold; color: #EA580C; }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="background-color: #EA580C; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
            Imprimir
        </button>
        <button onclick="window.close()" style="background-color: #6B7280; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
            Cerrar
        </button>
    </div>

    <div class="header">
        <h1>RENTING365</h1>
        <h2>PROYECCIÓN DE PAGOS</h2>
        <p>Contrato: {{ $contract->contract_number }}</p>
    </div>

    <div class="info-section">
        <div class="info-row">
            <div><span class="info-label">Cliente:</span> {{ $contract->client->full_name }}</div>
            <div><span class="info-label">Documento:</span> {{ $contract->client->document_type }} {{ $contract->client->document_number }}</div>
        </div>
        <div class="info-row">
            <div><span class="info-label">Motocicleta:</span> {{ $contract->motorcycle->brand }} {{ $contract->motorcycle->model }}</div>
            <div><span class="info-label">Placa:</span> {{ $contract->motorcycle->plate }}</div>
        </div>
        <div class="info-row">
            <div><span class="info-label">Fecha Inicio:</span> {{ $contract->start_date->format('d/m/Y') }}</div>
            <div><span class="info-label">Fecha Fin:</span> {{ $contract->end_date->format('d/m/Y') }}</div>
        </div>
    </div>

    <div class="summary">
        <div class="summary-row">
            <span>Valor Motocicleta:</span>
            <span>${{ number_format($contract->motorcycle_value, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span>Cuota Inicial:</span>
            <span>${{ number_format($contract->initial_payment, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span>Monto Financiado:</span>
            <span>${{ number_format($contract->financed_amount, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span>Tasa Mensual:</span>
            <span>{{ number_format($contract->monthly_rate, 2) }}%</span>
        </div>
        <div class="summary-row">
            <span>Plazo:</span>
            <span>{{ $contract->term_months }} meses</span>
        </div>
        <div class="summary-row total">
            <span>Cuota Mensual:</span>
            <span>${{ number_format($contract->monthly_payment, 0, ',', '.') }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha Vencimiento</th>
                <th style="text-align: right;">Cuota</th>
                <th style="text-align: right;">Capital</th>
                <th style="text-align: right;">Interés</th>
                <th style="text-align: right;">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contract->payments as $payment)
            <tr>
                <td>{{ $payment->payment_number }}</td>
                <td>{{ $payment->due_date->format('d/m/Y') }}</td>
                <td style="text-align: right;">${{ number_format($payment->amount, 0, ',', '.') }}</td>
                <td style="text-align: right;">${{ number_format($payment->principal, 0, ',', '.') }}</td>
                <td style="text-align: right;">${{ number_format($payment->interest, 0, ',', '.') }}</td>
                <td style="text-align: right;">${{ number_format($payment->balance, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #FFF7ED; font-weight: bold;">
                <td colspan="2">TOTALES</td>
                <td style="text-align: right;">${{ number_format($contract->payments->sum('amount'), 0, ',', '.') }}</td>
                <td style="text-align: right;">${{ number_format($contract->payments->sum('principal'), 0, ',', '.') }}</td>
                <td style="text-align: right;">${{ number_format($contract->payments->sum('interest'), 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 40px; font-size: 12px; color: #6B7280;">
        <p>Documento generado el {{ now()->format('d/m/Y H:i') }}</p>
        <p>Este documento es una proyección de pagos y no constituye un recibo oficial.</p>
    </div>
</body>
</html>
