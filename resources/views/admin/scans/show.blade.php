@extends('admin.layouts.app')

@section('title', 'Scan Details')
@section('page-title', 'Customer Scan Details')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Scan Record #{{ $scan->id }}</h3>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.scans.edit', $scan) }}" style="padding: 10px 20px; background: #2563eb; color: white; text-decoration: none; border-radius: 6px; display: inline-block; font-size: 14px;">
                Edit Details
            </a>
            <a href="{{ route('admin.scans.index') }}" style="padding: 10px 20px; background: #f3f4f6; color: #374151; text-decoration: none; border-radius: 6px; display: inline-block; font-size: 14px;">
                Back to List
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
        <!-- Customer Information -->
        <div>
            <h4 style="margin-bottom: 20px; color: #374151; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px;">👤 Customer Information</h4>
            
            <div style="margin-bottom: 20px;">
                <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Full Name:</strong>
                <div style="font-size: 18px; font-weight: 600; color: #1f2937;">{{ $scan->name }}</div>
            </div>

            <div style="margin-bottom: 20px;">
                <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Email Address:</strong>
                <a href="mailto:{{ $scan->email }}" style="color: #2563eb; text-decoration: none; font-size: 16px;">
                    {{ $scan->email }}
                </a>
            </div>

            <div style="margin-bottom: 20px;">
                <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Phone Number:</strong>
                <a href="tel:{{ $scan->phone }}" style="color: #2563eb; text-decoration: none; font-size: 16px;">
                    {{ $scan->phone }}
                </a>
            </div>

            <div style="margin-bottom: 20px;">
                <strong style="color: #6b7280; display: block; margin-bottom: 5px;">IP Address:</strong>
                <span style="font-family: monospace; background: #f3f4f6; padding: 6px 12px; border-radius: 6px; display: inline-block;">
                    {{ $scan->ip_address ?? 'Not recorded' }}
                </span>
            </div>

            <div style="margin-bottom: 20px;">
                <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Scan Date & Time:</strong>
                <div style="font-size: 16px; color: #1f2937;">
                    {{ $scan->created_at->format('l, F j, Y') }}<br>
                    <span style="color: #6b7280;">{{ $scan->created_at->format('h:i A') }}</span>
                </div>
            </div>
        </div>

        <!-- QR Code & Gift Information -->
        <div>
            <h4 style="margin-bottom: 20px; color: #374151; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px;">🎁 Prize Information</h4>
            
            @if($scan->qrCode)
                <div style="margin-bottom: 20px;">
                    <strong style="color: #6b7280; display: block; margin-bottom: 5px;">QR Code:</strong>
                    <code style="padding: 10px 15px; background: #f3f4f6; border-radius: 8px; display: inline-block; font-size: 16px; font-weight: 600;">
                        {{ $scan->qrCode->code }}
                    </code>
                </div>

                @if($scan->qrCode->gift)
                    <div style="margin-bottom: 20px;">
                        <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Gift Won:</strong>
                        <div style="padding: 15px; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border: 2px solid #fbbf24; border-radius: 10px;">
                            <div style="font-size: 20px; font-weight: 700; color: #92400e;">
                                {{ $scan->qrCode->gift->name }}
                            </div>
                            @if($scan->qrCode->gift->description)
                                <p style="color: #78350f; margin-top: 8px; font-size: 14px;">
                                    {{ $scan->qrCode->gift->description }}
                                </p>
                            @endif
                            <div style="margin-top: 10px;">
                                <span style="padding: 4px 12px; background: white; color: #92400e; border-radius: 12px; font-size: 12px; font-weight: 600;">
                                    {{ $scan->qrCode->gift->type }}
                                </span>
                                @if($scan->qrCode->gift->value)
                                    <span style="padding: 4px 12px; background: white; color: #92400e; border-radius: 12px; font-size: 12px; font-weight: 600; margin-left: 5px;">
                                        ${{ number_format($scan->qrCode->gift->value, 2) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                @if($scan->qrCode->batch_number)
                    <div style="margin-bottom: 20px;">
                        <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Batch Number:</strong>
                        <span style="padding: 6px 12px; background: #e0e7ff; color: #3730a3; border-radius: 6px; display: inline-block;">
                            {{ $scan->qrCode->batch_number }}
                        </span>
                    </div>
                @endif
            @else
                <div style="padding: 20px; background: #fee2e2; border: 2px solid #fca5a5; border-radius: 8px; color: #991b1b;">
                    QR Code information not available
                </div>
            @endif

            <!-- QR Code Visual -->
            @if($scan->qrCode)
                <div style="margin-top: 30px; text-align: center; padding: 20px; background: #f9fafb; border-radius: 8px;">
                    <strong style="color: #374151; display: block; margin-bottom: 15px;">QR Code Visual:</strong>
                    <div style="display: inline-block; padding: 15px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate(route('qr.scan', ['code' => $scan->qrCode->code])) !!}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Actions -->
    <div style="margin-top: 30px; padding-top: 30px; border-top: 1px solid #e5e7eb; display: flex; gap: 10px;">
        <a href="{{ route('admin.scans.edit', $scan) }}" style="padding: 12px 24px; background: #2563eb; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 500;">
            ✏️ Edit Customer Details
        </a>
        <form action="{{ route('admin.scans.destroy', $scan) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this customer record? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" style="padding: 12px 24px; background: #dc2626; color: white; border: none; border-radius: 6px; font-size: 14px; cursor: pointer; font-weight: 500;">
                🗑️ Delete Record
            </button>
        </form>
    </div>
</div>
@endsection


