@extends('admin.layouts.app')

@section('title', 'QR Code Details')
@section('page-title', 'QR Code Details')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>QR Code: {{ $qrcode->code }}</h3>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.qrcodes.download', $qrcode) }}" style="padding: 10px 20px; background: #2563eb; color: white; text-decoration: none; border-radius: 6px; display: inline-block; font-size: 14px;">
                Download QR Code
            </a>
            <a href="{{ route('admin.qrcodes.index') }}" style="padding: 10px 20px; background: #f3f4f6; color: #374151; text-decoration: none; border-radius: 6px; display: inline-block; font-size: 14px;">
                Back to List
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
        <!-- QR Code Image -->
        <div style="text-align: center; padding: 20px; background: #f9fafb; border-radius: 8px;">
            <h4 style="margin-bottom: 20px; color: #374151;">QR Code Image</h4>
            <div style="display: inline-block; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->generate(route('qr.scan', ['code' => $qrcode->code])) !!}
            </div>
            <p style="margin-top: 15px; color: #6b7280; font-size: 14px;">
                Scan URL: <code style="background: white; padding: 4px 8px; border-radius: 4px;">{{ route('qr.scan', ['code' => $qrcode->code]) }}</code>
            </p>
        </div>

        <!-- QR Code Details -->
        <div>
            <h4 style="margin-bottom: 20px; color: #374151;">Details</h4>
            
            <div style="margin-bottom: 20px;">
                <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Code:</strong>
                <code style="padding: 8px 12px; background: #f3f4f6; border-radius: 6px; display: inline-block;">
                    {{ $qrcode->code }}
                </code>
            </div>

            <div style="margin-bottom: 20px;">
                <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Gift:</strong>
                <div style="padding: 12px; background: #f9fafb; border-radius: 6px;">
                    <div style="font-weight: 600; color: #1f2937;">{{ $qrcode->gift->name ?? 'N/A' }}</div>
                    @if($qrcode->gift)
                        <div style="margin-top: 5px; color: #6b7280; font-size: 14px;">
                            Type: <span style="padding: 2px 8px; background: #dbeafe; color: #1e40af; border-radius: 8px; font-size: 12px;">{{ $qrcode->gift->type }}</span>
                        </div>
                        @if($qrcode->gift->value)
                            <div style="margin-top: 5px; color: #6b7280; font-size: 14px;">
                                Value: ${{ number_format($qrcode->gift->value, 2) }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Batch Number:</strong>
                <span>{{ $qrcode->batch_number ?? 'N/A' }}</span>
            </div>

            <div style="margin-bottom: 20px;">
                <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Status:</strong>
                <span style="padding: 6px 16px; background: {{ $qrcode->is_scanned ? '#fef3c7' : '#d1fae5' }}; color: {{ $qrcode->is_scanned ? '#92400e' : '#065f46' }}; border-radius: 12px; font-size: 14px; display: inline-block;">
                    {{ $qrcode->is_scanned ? 'Scanned' : 'Available' }}
                </span>
            </div>

            <div style="margin-bottom: 20px;">
                <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Created:</strong>
                <span>{{ $qrcode->created_at->format('M d, Y H:i') }}</span>
            </div>

            @if($qrcode->is_scanned)
                <div style="margin-bottom: 20px;">
                    <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Scanned At:</strong>
                    <span>{{ $qrcode->scanned_at->format('M d, Y H:i') }}</span>
                </div>
            @endif
        </div>
    </div>

    @if($qrcode->scan)
        <div style="margin-top: 30px; padding-top: 30px; border-top: 1px solid #e5e7eb;">
            <h4 style="margin-bottom: 20px; color: #374151;">Scan Information</h4>
            
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                <div>
                    <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Name:</strong>
                    <span>{{ $qrcode->scan->name }}</span>
                </div>

                <div>
                    <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Email:</strong>
                    <span>{{ $qrcode->scan->email }}</span>
                </div>

                <div>
                    <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Phone:</strong>
                    <span>{{ $qrcode->scan->phone }}</span>
                </div>

                <div>
                    <strong style="color: #6b7280; display: block; margin-bottom: 5px;">IP Address:</strong>
                    <span>{{ $qrcode->scan->ip_address ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection









