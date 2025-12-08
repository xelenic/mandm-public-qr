@extends('admin.layouts.app')

@section('title', 'Edit Scan')
@section('page-title', 'Edit Customer Details')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Edit Customer Record #{{ $scan->id }}</h3>
    </div>

    <form action="{{ route('admin.scans.update', $scan) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label for="name" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                Full Name <span style="color: #dc2626;">*</span>
            </label>
            <input type="text" name="name" id="name" value="{{ old('name', $scan->name) }}" required
                style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="email" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                Email Address <span style="color: #dc2626;">*</span>
            </label>
            <input type="email" name="email" id="email" value="{{ old('email', $scan->email) }}" required
                style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="phone" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                Phone Number <span style="color: #dc2626;">*</span>
            </label>
            <input type="tel" name="phone" id="phone" value="{{ old('phone', $scan->phone) }}" required
                style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="gift_status" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                Gift Status <span style="color: #dc2626;">*</span>
            </label>
            <select name="gift_status" id="gift_status" required
                style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; background: white; cursor: pointer;">
                <option value="pending" {{ old('gift_status', $scan->gift_status) === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                <option value="confirmed" {{ old('gift_status', $scan->gift_status) === 'confirmed' ? 'selected' : '' }}>✓ Confirmed</option>
                <option value="sent" {{ old('gift_status', $scan->gift_status) === 'sent' ? 'selected' : '' }}>📦 Sent</option>
                <option value="delivered" {{ old('gift_status', $scan->gift_status) === 'delivered' ? 'selected' : '' }}>✅ Delivered</option>
            </select>
        </div>

        <!-- Read-only information -->
        <div style="margin-top: 30px; padding: 20px; background: #f9fafb; border-radius: 8px;">
            <h4 style="margin-bottom: 15px; color: #374151;">Additional Information (Read-only)</h4>
            
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <strong style="color: #6b7280; font-size: 12px; display: block; margin-bottom: 5px;">QR Code:</strong>
                    <code style="padding: 6px 10px; background: white; border-radius: 4px; font-size: 13px; display: inline-block;">
                        {{ $scan->qrCode->code ?? 'N/A' }}
                    </code>
                </div>

                <div>
                    <strong style="color: #6b7280; font-size: 12px; display: block; margin-bottom: 5px;">Gift Won:</strong>
                    <span style="padding: 6px 10px; background: #dbeafe; color: #1e40af; border-radius: 4px; font-size: 13px; display: inline-block;">
                        {{ $scan->qrCode->gift->name ?? 'N/A' }}
                    </span>
                </div>

                <div>
                    <strong style="color: #6b7280; font-size: 12px; display: block; margin-bottom: 5px;">Current Gift Status:</strong>
                    <span style="padding: 6px 10px; background: {{ 
                        $scan->gift_status === 'delivered' ? '#d1fae5' : 
                        ($scan->gift_status === 'sent' ? '#dbeafe' : 
                        ($scan->gift_status === 'confirmed' ? '#fef3c7' : '#f3f4f6')) 
                    }}; color: {{ 
                        $scan->gift_status === 'delivered' ? '#065f46' : 
                        ($scan->gift_status === 'sent' ? '#1e40af' : 
                        ($scan->gift_status === 'confirmed' ? '#92400e' : '#6b7280')) 
                    }}; border-radius: 4px; font-size: 13px; display: inline-block;">
                        {{ ucfirst($scan->gift_status ?? 'pending') }}
                    </span>
                </div>

                <div>
                    <strong style="color: #6b7280; font-size: 12px; display: block; margin-bottom: 5px;">IP Address:</strong>
                    <span style="font-family: monospace; font-size: 13px;">{{ $scan->ip_address ?? 'N/A' }}</span>
                </div>

                <div>
                    <strong style="color: #6b7280; font-size: 12px; display: block; margin-bottom: 5px;">Scan Date:</strong>
                    <span style="font-size: 13px;">{{ $scan->created_at->format('M d, Y H:i') }}</span>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 10px; padding-top: 20px; margin-top: 20px; border-top: 1px solid #e5e7eb;">
            <button type="submit" style="padding: 10px 24px; background: #2563eb; color: white; border: none; border-radius: 6px; font-size: 14px; cursor: pointer;">
                Update Customer Details
            </button>
            <a href="{{ route('admin.scans.show', $scan) }}" style="padding: 10px 24px; background: #f3f4f6; color: #374151; text-decoration: none; border-radius: 6px; font-size: 14px; display: inline-block;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

