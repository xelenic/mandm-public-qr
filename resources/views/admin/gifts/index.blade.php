@extends('admin.layouts.app')

@section('title', 'Gifts')
@section('page-title', 'Gifts Management')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>All Gifts</h3>
        <a href="{{ route('admin.gifts.create') }}" style="padding: 10px 20px; background: #2563eb; color: white; text-decoration: none; border-radius: 6px; display: inline-block; font-size: 14px;">
            + Add New Gift
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">ID</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Name</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Type</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Value</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">QR Codes</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Status</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gifts as $gift)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 12px;">{{ $gift->id }}</td>
                        <td style="padding: 12px;">{{ $gift->name }}</td>
                        <td style="padding: 12px;">
                            <span style="padding: 4px 12px; background: #dbeafe; color: #1e40af; border-radius: 12px; font-size: 12px;">
                                {{ $gift->type }}
                            </span>
                        </td>
                        <td style="padding: 12px;">{{ $gift->value ? '$' . number_format($gift->value, 2) : 'N/A' }}</td>
                        <td style="padding: 12px;">
                            <span style="padding: 4px 12px; background: #e0e7ff; color: #3730a3; border-radius: 12px; font-size: 12px; font-weight: 600;">
                                {{ $gift->qr_codes_count }}
                            </span>
                        </td>
                        <td style="padding: 12px;">
                            <span style="padding: 4px 12px; background: {{ $gift->is_active ? '#d1fae5' : '#fee2e2' }}; color: {{ $gift->is_active ? '#065f46' : '#991b1b' }}; border-radius: 12px; font-size: 12px;">
                                {{ $gift->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td style="padding: 12px;">
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('admin.gifts.edit', $gift) }}" style="padding: 6px 12px; background: #f3f4f6; color: #374151; text-decoration: none; border-radius: 4px; font-size: 12px;">
                                    Edit
                                </a>
                                <form action="{{ route('admin.gifts.destroy', $gift) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this gift?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="padding: 6px 12px; background: #fee2e2; color: #991b1b; border: none; border-radius: 4px; font-size: 12px; cursor: pointer;">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 40px; text-align: center; color: #6b7280;">
                            No gifts found. <a href="{{ route('admin.gifts.create') }}" style="color: #2563eb; text-decoration: none;">Create your first gift</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($gifts->hasPages())
        <div style="padding: 20px; border-top: 1px solid #e5e7eb;">
            {{ $gifts->links() }}
        </div>
    @endif
</div>
@endsection









