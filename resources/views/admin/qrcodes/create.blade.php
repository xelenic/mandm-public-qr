@extends('admin.layouts.app')

@section('title', 'Generate QR Codes')
@section('page-title', 'Generate QR Codes')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Generate New QR Codes</h3>
    </div>

    <form action="{{ route('admin.qrcodes.store') }}" method="POST">
        @csrf

        <div style="margin-bottom: 20px;">
            <label for="gift_id" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                Assign Gift <span style="color: #dc2626;">*</span>
            </label>
            <select name="gift_id" id="gift_id" required
                style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                <option value="">Select a gift...</option>
                @foreach($gifts as $gift)
                    <option value="{{ $gift->id }}" {{ old('gift_id') == $gift->id ? 'selected' : '' }}>
                        {{ $gift->name }} ({{ $gift->type }})
                    </option>
                @endforeach
            </select>
            <small style="color: #6b7280; font-size: 12px;">Each QR code will be assigned to this gift</small>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="quantity" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                Quantity <span style="color: #dc2626;">*</span>
            </label>
            <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" required min="1" max="200"
                style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;"
                placeholder="Enter number of QR codes (Max: 200)">
            <small style="color: #6b7280; font-size: 12px;">For M&M packets, typically 200 QR codes per batch</small>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="batch_number" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                Batch Number (Optional)
            </label>
            <input type="text" name="batch_number" id="batch_number" value="{{ old('batch_number') }}"
                style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;"
                placeholder="e.g., BATCH-001">
            <small style="color: #6b7280; font-size: 12px;">Use batch numbers to organize QR codes by packet or production run</small>
        </div>

        <div style="padding: 15px; background: #fef3c7; border: 1px solid #fcd34d; border-radius: 6px; margin-bottom: 20px;">
            <strong style="color: #92400e;">Note:</strong>
            <p style="color: #92400e; margin: 5px 0 0 0; font-size: 14px;">
                QR codes will be auto-generated with unique codes. After creation, you can download individual QR codes as images to print on M&M packet stickers.
            </p>
        </div>

        <div style="display: flex; gap: 10px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <button type="submit" style="padding: 10px 24px; background: #2563eb; color: white; border: none; border-radius: 6px; font-size: 14px; cursor: pointer;">
                Generate QR Codes
            </button>
            <a href="{{ route('admin.qrcodes.index') }}" style="padding: 10px 24px; background: #f3f4f6; color: #374151; text-decoration: none; border-radius: 6px; font-size: 14px; display: inline-block;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection









