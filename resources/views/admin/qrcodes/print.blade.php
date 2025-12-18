<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print QR Codes - {{ count($qrCodes) }} codes</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 10mm;
            background: white;
        }

        .print-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #333;
        }

        .print-header h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .print-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 12px;
            color: #666;
        }

        .qr-grid {
            display: grid;
            gap: 15px;
            @if($size === 'small')
                grid-template-columns: repeat(6, 1fr);
            @elseif($size === 'large')
                grid-template-columns: repeat(3, 1fr);
            @else
                grid-template-columns: repeat(4, 1fr);
            @endif
        }

        .qr-item {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            page-break-inside: avoid;
            background: white;
        }

        .qr-item.scanned {
            background: #fef3c7;
            border-color: #fbbf24;
        }

        .qr-code {
            margin: 0 auto 8px;
            display: block;
        }

        .qr-code svg {
            max-width: 100%;
            height: auto;
        }

        .qr-info {
            font-size: 9px;
            color: #374151;
            margin-top: 5px;
        }

        .qr-code-text {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            font-size: 10px;
            margin: 5px 0;
            word-break: break-all;
        }

        .qr-gift {
            font-size: 8px;
            color: #6b7280;
            margin-top: 3px;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
            margin-top: 5px;
        }

        .status-scanned {
            background: #fbbf24;
            color: #92400e;
        }

        .status-available {
            background: #10b981;
            color: white;
        }

        /* Print styles */
        @media print {
            body {
                padding: 5mm;
            }

            .print-header {
                margin-bottom: 10px;
            }

            .no-print {
                display: none;
            }

            .qr-grid {
                gap: 10px;
            }

            .qr-item {
                page-break-inside: avoid;
            }

            @page {
                size: A4;
                margin: 10mm;
            }
        }

        .print-actions {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 1000;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }

        .btn-print {
            background: #2563eb;
            color: white;
        }

        .btn-close {
            background: #6b7280;
            color: white;
        }

        .summary-box {
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .summary-item {
            text-align: center;
        }

        .summary-value {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
        }

        .summary-label {
            font-size: 12px;
            color: #6b7280;
            margin-top: 5px;
        }

        @media print {
            .print-actions {
                display: none !important;
            }

            .summary-box {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <!-- Print Actions (Hidden when printing) -->
    <div class="print-actions no-print">
        <button onclick="window.print()" class="btn btn-print">🖨️ Print</button>
        <button onclick="window.close()" class="btn btn-close">✕ Close</button>
    </div>

    <!-- Print Header -->
    <div class="print-header">
        <h1>M&M QR Codes Print Sheet</h1>
        <div class="print-info">
            <div>
                <strong>Total Codes:</strong> {{ count($qrCodes) }}
            </div>
            <div>
                <strong>Date:</strong> {{ now()->format('M d, Y H:i') }}
            </div>
            <div>
                <strong>Size:</strong> {{ ucfirst($size) }}
            </div>
        </div>
    </div>

    <!-- Summary Statistics (Hidden when printing) -->
    <div class="summary-box no-print">
        <div class="summary-item">
            <div class="summary-value">{{ count($qrCodes) }}</div>
            <div class="summary-label">Total QR Codes</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ $qrCodes->where('is_scanned', false)->count() }}</div>
            <div class="summary-label">Available</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ $qrCodes->where('is_scanned', true)->count() }}</div>
            <div class="summary-label">Scanned</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ $qrCodes->groupBy('gift_id')->count() }}</div>
            <div class="summary-label">Different Gifts</div>
        </div>
    </div>

    @if($qrCodes->isEmpty())
        <div style="text-align: center; padding: 50px; color: #6b7280;">
            <p style="font-size: 18px;">No QR codes found matching your filters.</p>
            <button onclick="window.close()" class="btn btn-close" style="margin-top: 20px;">Close Window</button>
        </div>
    @else
        <!-- QR Codes Grid -->
        <div class="qr-grid">
            @foreach($qrCodes as $qrCode)
                <div class="qr-item {{ $qrCode->is_scanned ? 'scanned' : '' }}">
                    <div class="qr-code">
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size($size === 'small' ? 120 : ($size === 'large' ? 180 : 150))->generate(route('qr.scan', ['code' => $qrCode->code])) !!}
                    </div>
                    <div class="qr-code-text">{{ $qrCode->code }}</div>
                    <div class="qr-gift">{{ $qrCode->gift->name ?? 'N/A' }}</div>
                    @if($qrCode->batch_number)
                        <div class="qr-info">Batch: {{ $qrCode->batch_number }}</div>
                    @endif
                    <span class="status-badge {{ $qrCode->is_scanned ? 'status-scanned' : 'status-available' }}">
                        {{ $qrCode->is_scanned ? 'SCANNED' : 'AVAILABLE' }}
                    </span>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Auto-print on load (optional) -->
    <script>
        // Automatically open print dialog when page loads
        window.onload = function() {
            // Uncomment the line below to auto-print
            // setTimeout(() => window.print(), 500);
        };

        // Close window after printing
        window.onafterprint = function() {
            // Uncomment to auto-close after printing
            // window.close();
        };
    </script>
</body>
</html>








