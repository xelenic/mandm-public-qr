@extends('admin.layouts.app')

@section('title', 'Gift Details')
@section('page-title', 'Gift Details')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Gift: {{ $gift->name }}</h3>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.gifts.edit', $gift) }}" style="padding: 10px 20px; background: #2563eb; color: white; text-decoration: none; border-radius: 6px; display: inline-block; font-size: 14px;">
                Edit Gift
            </a>
            <a href="{{ route('admin.gifts.index') }}" style="padding: 10px 20px; background: #f3f4f6; color: #374151; text-decoration: none; border-radius: 6px; display: inline-block; font-size: 14px;">
                Back to List
            </a>
        </div>
    </div>

    <div style="margin-bottom: 30px;">
        <div style="margin-bottom: 20px;">
            <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Gift Name:</strong>
            <div style="font-size: 20px; font-weight: 600; color: #1f2937;">{{ $gift->name }}</div>
        </div>

        <div style="margin-bottom: 20px;">
            <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Type:</strong>
            <span style="padding: 6px 16px; background: #dbeafe; color: #1e40af; border-radius: 12px; font-size: 14px; display: inline-block;">
                {{ $gift->type }}
            </span>
        </div>

        @if($gift->value)
            <div style="margin-bottom: 20px;">
                <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Value:</strong>
                <div style="font-size: 18px; font-weight: 600; color: #1f2937;">${{ number_format($gift->value, 2) }}</div>
            </div>
        @endif

        @if($gift->description)
            <div style="margin-bottom: 20px;">
                <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Description:</strong>
                <p style="color: #4b5563; line-height: 1.6;">{{ $gift->description }}</p>
            </div>
        @endif

        <div style="margin-bottom: 20px;">
            <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Status:</strong>
            <span style="padding: 6px 16px; background: {{ $gift->is_active ? '#d1fae5' : '#fee2e2' }}; color: {{ $gift->is_active ? '#065f46' : '#991b1b' }}; border-radius: 12px; font-size: 14px; display: inline-block;">
                {{ $gift->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>

        <div style="margin-bottom: 20px;">
            <strong style="color: #6b7280; display: block; margin-bottom: 5px;">Total QR Codes:</strong>
            <span style="padding: 6px 16px; background: #e0e7ff; color: #3730a3; border-radius: 12px; font-size: 14px; display: inline-block; font-weight: 600;">
                {{ $gift->qrCodes->count() }}
            </span>
        </div>
    </div>

    @if($gift->qrCodes->isNotEmpty())
        <div style="padding-top: 30px; border-top: 1px solid #e5e7eb;">
            <h4 style="margin-bottom: 20px; color: #374151;">Associated QR Codes</h4>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Code</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Batch</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Status</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Scanned At</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gift->qrCodes as $qrCode)
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 12px;">
                                    <code style="padding: 4px 8px; background: #f3f4f6; border-radius: 4px; font-size: 12px;">
                                        {{ $qrCode->code }}
                                    </code>
                                </td>
                                <td style="padding: 12px;">{{ $qrCode->batch_number ?? 'N/A' }}</td>
                                <td style="padding: 12px;">
                                    <span style="padding: 4px 12px; background: {{ $qrCode->is_scanned ? '#fef3c7' : '#d1fae5' }}; color: {{ $qrCode->is_scanned ? '#92400e' : '#065f46' }}; border-radius: 12px; font-size: 12px;">
                                        {{ $qrCode->is_scanned ? 'Scanned' : 'Available' }}
                                    </span>
                                </td>
                                <td style="padding: 12px;">
                                    {{ $qrCode->scanned_at ? $qrCode->scanned_at->format('M d, Y') : '-' }}
                                </td>
                                <td style="padding: 12px;">
                                    <a href="{{ route('admin.qrcodes.show', $qrCode) }}" style="padding: 6px 12px; background: #dbeafe; color: #1e40af; text-decoration: none; border-radius: 4px; font-size: 12px;">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection



