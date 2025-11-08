<!DOCTYPE html>
<html>
<head>
    <title>Detalle Contrato - {{ $contract->contract_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #EA580C; padding-bottom: 20px; }
        .header h1 { color: #EA580C; margin: 0; font-size: 32px; }
        .section { margin-bottom: 25px; page-break-inside: avoid; }
        .section-title { background-color: #EA580C; color: white; padding: 10px; font-size: 16px; font-weight: bold; margin-bottom: 15px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .info-item { margin-bottom: 10px; }
        .info-label { font-weight: bold; color: #374151; display: block; margin-bottom: 3px; }
        .info-value { color: #1F2937; }
        .highlight-box { background-color: #FFF7ED; border-left: 4px solid #EA580C; padding: 15px; margin: 20px 0; }
        .terms { background-color: #F3F4F6; padding: 15px; border-radius: 5px; }
        .signature-section { margin-top: 60px; display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
        .signature-box { text-align: center; border-top: 2px solid #000; padding-top: 10px; }
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
        <h2 style="margin: 10px 0;">CONTRATO DE LEASING DE MOTOCICLETA</h2>
        <p style="font-size: 18px; margin: 5px 0;">{{ $contract->contract_number }}</p>
        <p style="color: #6B7280;">Fecha: {{ $contract->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="section">
        <div class="section-title">INFORMACIÓN DEL CLIENTE</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nombre Completo:</span>
                <span class="info-value">{{ $contract->client->full_name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Documento:</span>
                <span class="info-value">{{ $contract->client->document_type }} {{ $contract->client->document_number }}</span>
            </div>
            @if($contract->client->contacts->first())
            <div class="info-item">
                <span class="info-label">Teléfono:</span>
                <span class="info-value">{{ $contract->client->contacts->first()->phone_mobile }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $contract->client->contacts->first()->email }}</span>
            </div>
            @endif
        </div>
    </div>

    <div class="section">
        <div class="section-title">INFORMACIÓN DE LA MOTOCICLETA</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Marca y Modelo:</span>
                <span class="info-value">{{ $contract->motorcycle->brand }} {{ $contract->motorcycle->model }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Año:</span>
                <span class="info-value">{{ $contract->motorcycle->year }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Placa:</span>
                <span class="info-value">{{ $contract->motorcycle->plate }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Color:</span>
                <span class="info-value">{{ $contract->motorcycle->color }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Cilindraje:</span>
                <span class="info-value">{{ $contract->motorcycle->displacement }} cc</span>
            </div>
            <div class="info-item">
                <span class="info-label">Número de Motor:</span>
                <span class="info-value">{{ $contract->motorcycle->motor_number }}</span>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">CONDICIONES FINANCIERAS</div>
        <div class="highlight-box">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Valor de la Motocicleta:</span>
                    <span class="info-value" style="font-size: 18px;">${{ number_format($contract->motorcycle_value, 0, ',', '.') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Cuota Inicial:</span>
                    <span class="info-value" style="font-size: 18px;">${{ number_format($contract->initial_payment, 0, ',', '.') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Monto Financiado:</span>
                    <span class="info-value" style="font-size: 18px; color: #EA580C; font-weight: bold;">${{ number_format($contract->financed_amount, 0, ',', '.') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Cuota Mensual:</span>
                    <span class="info-value" style="font-size: 18px; color: #EA580C; font-weight: bold;">${{ number_format($contract->monthly_payment, 0, ',', '.') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tasa de Interés Mensual:</span>
                    <span class="info-value">{{ number_format($contract->monthly_rate, 2) }}%</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Plazo:</span>
                    <span class="info-value">{{ $contract->term_months }} meses</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Día de Pago:</span>
                    <span class="info-value">{{ $contract->payment_day }} de cada mes</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Total a Pagar:</span>
                    <span class="info-value" style="font-size: 18px;">${{ number_format($contract->monthly_payment * $contract->term_months, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">VIGENCIA DEL CONTRATO</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Fecha de Inicio:</span>
                <span class="info-value">{{ $contract->start_date->format('d/m/Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Fecha de Finalización:</span>
                <span class="info-value">{{ $contract->end_date->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">TÉRMINOS Y CONDICIONES</div>
        <div class="terms">
            <ol style="line-height: 1.8;">
                <li>El arrendatario se compromete a realizar los pagos mensuales en la fecha acordada.</li>
                <li>El mantenimiento preventivo de la motocicleta está incluido en el contrato.</li>
                <li>El SOAT y seguro contra todo riesgo están incluidos durante la vigencia del contrato.</li>
                <li>El arrendatario es responsable del uso adecuado y cuidado de la motocicleta.</li>
                <li>Cualquier daño o siniestro debe ser reportado inmediatamente a RENTING365.</li>
                <li>El incumplimiento en los pagos puede resultar en la terminación del contrato.</li>
                <li>Al finalizar el contrato, el arrendatario tiene opción de compra de la motocicleta.</li>
            </ol>
        </div>
    </div>

    @if($contract->notes)
    <div class="section">
        <div class="section-title">OBSERVACIONES</div>
        <p style="padding: 10px; background-color: #F9FAFB;">{{ $contract->notes }}</p>
    </div>
    @endif

    <div class="signature-section">
        <div class="signature-box">
            <p style="margin-bottom: 60px;"></p>
            <strong>{{ $contract->client->full_name }}</strong><br>
            <small>{{ $contract->client->document_type }} {{ $contract->client->document_number }}</small><br>
            <small>ARRENDATARIO</small>
        </div>
        <div class="signature-box">
            <p style="margin-bottom: 60px;"></p>
            <strong>RENTING365</strong><br>
            <small>NIT: XXX-XXXXXX-X</small><br>
            <small>ARRENDADOR</small>
        </div>
    </div>

    <div style="margin-top: 40px; font-size: 11px; color: #6B7280; text-align: center; border-top: 1px solid #E5E7EB; padding-top: 20px;">
        <p>Documento generado el {{ now()->format('d/m/Y H:i') }}</p>
        <p>RENTING365 - Cartagena, Colombia - Tel: +57 310 5367376</p>
    </div>
</body>
</html>
