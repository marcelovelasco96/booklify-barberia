<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reserva #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #0b0f14;
            background: linear-gradient(180deg, #f8f8f7 0%, #eeeeec 100%);
        }

        .wrap {
            max-width: 840px;
            margin: 32px auto;
            padding: 0 18px;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-bottom: 18px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 13px;
            font-weight: 700;
            color: #0b0f14;
            background: #fff;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-dark {
            background: #0b0f14;
            color: #fff;
            border-color: #0b0f14;
        }

        .receipt {
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, .06);
            border-radius: 28px;
            background: #fff;
            box-shadow: 0 24px 70px rgba(0, 0, 0, .08);
        }

        .top {
            padding: 28px 32px;
            color: #fff;
            background: #080b10;
        }

        .brand {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .brand-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .logo {
            height: 54px;
            width: auto;
            object-fit: contain;
            border-radius: 10px;
        }

        .brand-title {
            margin: 0;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -.02em;
        }

        .brand-subtitle {
            margin: 4px 0 0;
            color: rgba(255, 255, 255, .68);
            font-size: 13px;
        }

        .code-box {
            text-align: right;
        }

        .code-label {
            color: rgba(255, 255, 255, .55);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
            font-weight: 700;
        }

        .code-value {
            margin-top: 5px;
            font-size: 28px;
            font-weight: 800;
            color: #d4af37;
        }

        .content {
            padding: 32px;
        }

        .status-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            padding-bottom: 24px;
            border-bottom: 1px solid #f0f0f0;
        }

        .eyebrow {
            margin: 0;
            color: #9ca3af;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
            font-weight: 800;
        }

        .main-title {
            margin: 8px 0 0;
            font-size: 26px;
            line-height: 1.2;
            font-weight: 800;
            letter-spacing: -.03em;
        }

        .status {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: 800;
        }

        .status-confirmed {
            color: #047857;
            background: #dcfce7;
            border: 1px solid #bbf7d0;
        }

        .status-cancelled {
            color: #b91c1c;
            background: #fee2e2;
            border: 1px solid #fecaca;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-top: 24px;
        }

        .item {
            border: 1px solid #f0f0f0;
            border-radius: 18px;
            background: #fafafa;
            padding: 16px;
        }

        .label {
            color: #9ca3af;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
            font-weight: 800;
        }

        .value {
            margin-top: 7px;
            font-size: 15px;
            font-weight: 800;
            color: #0b0f14;
            word-break: break-word;
        }

        .highlight {
            background: #fffaf0;
            border-color: rgba(212, 175, 55, .28);
        }

        .footer {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-top: 26px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
            color: #6b7280;
            font-size: 12px;
            line-height: 1.5;
        }

        .note {
            max-width: 520px;
        }

        @media print {
            body {
                background: #fff;
            }

            .no-print {
                display: none !important;
            }

            .wrap {
                max-width: none;
                margin: 0;
                padding: 0;
            }

            .receipt {
                border-radius: 0;
                box-shadow: none;
                border: none;
            }

            .top {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .status,
            .highlight {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        @media (max-width: 640px) {

            .brand,
            .status-row,
            .footer {
                flex-direction: column;
                align-items: flex-start;
            }

            .code-box {
                text-align: left;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .top,
            .content {
                padding: 24px;
            }
        }
    </style>
</head>

<body>
    @php
        $code = str_pad($booking->id, 5, '0', STR_PAD_LEFT);
        $isConfirmed = $booking->status === 'confirmed';
    @endphp

    <div class="wrap">

        <div class="actions no-print">
            <button onclick="window.print()" class="btn btn-dark">
                Imprimir / Guardar PDF
            </button>

            <a href="{{ route('bookings.show', $booking) }}" class="btn">
                Volver al detalle
            </a>
        </div>

        <div class="receipt">

            <div class="top">
                <div class="brand">
                    <div class="brand-left">
                        <img src="{{ asset('images/cusi-logo.png') }}" alt="CUSI BARBERSHOP" class="logo">

                        <div>
                            <h1 class="brand-title">CUSI BARBERSHOP</h1>
                            <p class="brand-subtitle">Comprobante de reserva</p>
                        </div>
                    </div>

                    <div class="code-box">
                        <div class="code-label">Código</div>
                        <div class="code-value">#{{ $code }}</div>
                    </div>
                </div>
            </div>

            <div class="content">

                <div class="status-row">
                    <div>
                        <p class="eyebrow">Reserva registrada</p>
                        <h2 class="main-title">
                            {{ $booking->service?->name ?? 'Servicio no disponible' }}
                        </h2>

                        @if ($booking->barber)
                            <p style="margin: 8px 0 0; color:#6b7280; font-size: 14px;">
                                Barbero: <strong style="color:#0b0f14;">{{ $booking->barber->name }}</strong>
                            </p>
                        @endif
                    </div>

                    <div class="status {{ $isConfirmed ? 'status-confirmed' : 'status-cancelled' }}">
                        {{ $isConfirmed ? 'Confirmada' : 'Cancelada' }}
                    </div>
                </div>

                <div class="grid">
                    <div class="item highlight">
                        <div class="label">Fecha</div>
                        <div class="value">
                            {{ \Illuminate\Support\Carbon::parse($booking->booking_date)->format('d/m/Y') }}
                        </div>
                    </div>

                    <div class="item highlight">
                        <div class="label">Hora</div>
                        <div class="value">
                            {{ \Illuminate\Support\Carbon::parse($booking->booking_time)->format('H:i') }}
                        </div>
                    </div>

                    <div class="item">
                        <div class="label">Cliente</div>
                        <div class="value">{{ $booking->full_name }}</div>
                    </div>

                    <div class="item">
                        <div class="label">Teléfono</div>
                        <div class="value">{{ $booking->phone }}</div>
                    </div>

                    <div class="item">
                        <div class="label">Email</div>
                        <div class="value">{{ $booking->email ?: '—' }}</div>
                    </div>

                    <div class="item">
                        <div class="label">Generado</div>
                        <div class="value">{{ now()->format('d/m/Y H:i') }}</div>
                    </div>
                </div>

                <div class="footer">
                    <div class="note">
                        Este comprobante confirma la reserva registrada en el sistema.
                        No reemplaza una boleta o factura.
                    </div>

                    <div>
                        Booklify · CUSI BARBERSHOP
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
