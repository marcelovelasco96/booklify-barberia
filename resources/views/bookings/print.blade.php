<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reserva #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            color: #111;
        }

        .wrap {
            max-width: 800px;
            margin: 24px auto;
            padding: 0 16px;
        }

        h1 {
            font-size: 20px;
            margin: 0 0 12px;
        }

        .muted {
            color: #555;
            font-size: 12px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 16px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .row {
            margin: 0 0 8px;
        }

        .label {
            font-size: 12px;
            color: #555;
        }

        .value {
            font-size: 14px;
            font-weight: 600;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                margin: 0;
            }

            .wrap {
                margin: 0;
                max-width: none;
            }

            .card {
                border: none;
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <div class="wrap">
        @php($code = str_pad($booking->id, 5, '0', STR_PAD_LEFT))

        <div class="no-print" style="margin-bottom: 12px;">
            <button onclick="window.print()"
                style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 8px; cursor: pointer;">
                Imprimir / Guardar PDF
            </button>
            <a href="{{ route('bookings.show', $booking) }}" style="margin-left: 10px; font-size: 14px;">
                Volver al detalle
            </a>
        </div>

        <h1>Reserva #{{ $code }}</h1>
        <p class="muted">Generado: {{ now()->format('d/m/Y H:i') }}</p>

        <div class="card">
            <div class="grid">
                <div class="row">
                    <div class="label">Servicio</div>
                    <div class="value">{{ $booking->service?->name }}</div>
                </div>

                <div class="row">
                    <div class="label">Estado</div>
                    <div class="value">{{ $booking->status === 'confirmed' ? 'Confirmada' : 'Cancelada' }}</div>
                </div>

                <div class="row">
                    <div class="label">Cliente</div>
                    <div class="value">{{ $booking->full_name }}</div>
                </div>

                <div class="row">
                    <div class="label">Teléfono</div>
                    <div class="value">{{ $booking->phone }}</div>
                </div>

                <div class="row">
                    <div class="label">Email</div>
                    <div class="value">{{ $booking->email ?: '—' }}</div>
                </div>

                <div class="row">
                    <div class="label">Fecha</div>
                    <div class="value">{{ \Illuminate\Support\Carbon::parse($booking->booking_date)->format('d/m/Y') }}
                    </div>
                </div>

                <div class="row">
                    <div class="label">Hora</div>
                    <div class="value">{{ \Illuminate\Support\Carbon::parse($booking->booking_time)->format('H:i') }}
                    </div>
                </div>

                <div class="row">
                    <div class="label">Código</div>
                    <div class="value">#{{ $code }}</div>
                </div>
            </div>
        </div>

        <p class="muted" style="margin-top: 14px;">
            Este comprobante no reemplaza una boleta/factura.
        </p>
    </div>
</body>

</html>
