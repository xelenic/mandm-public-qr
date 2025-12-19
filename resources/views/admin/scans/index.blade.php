@extends('admin.layouts.app')

@section('title', 'Customer Scans')
@section('page-title', 'Customer Scan Records')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Customer Scans</h3>
        <div style="display: flex; gap: 10px;">
            <button onclick="toggleFilters()" style="padding: 10px 20px; background: #6b7280; color: white; border: none; border-radius: 6px; font-size: 14px; cursor: pointer;">
                🔍 Filters
            </button>
            <a href="{{ route('admin.scans.export', request()->query()) }}" style="padding: 10px 20px; background: #10b981; color: white; text-decoration: none; border-radius: 6px; display: inline-block; font-size: 14px;">
                📥 Export CSV
            </a>
        </div>
    </div>

    <!-- Filters Panel -->
    <div id="filtersPanel" style="display: none; padding: 20px; background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
        <form method="GET" action="{{ route('admin.scans.index') }}">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #374151; font-size: 14px;">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, email, or phone..."
                        style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #374151; font-size: 14px;">Gift Status</label>
                    <select name="gift_status" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; background: white;">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('gift_status') === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                        <option value="confirmed" {{ request('gift_status') === 'confirmed' ? 'selected' : '' }}>✓ Confirmed</option>
                        <option value="sent" {{ request('gift_status') === 'sent' ? 'selected' : '' }}>📦 Sent</option>
                        <option value="delivered" {{ request('gift_status') === 'delivered' ? 'selected' : '' }}>✅ Delivered</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #374151; font-size: 14px;">Date From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #374151; font-size: 14px;">Date To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                        style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                </div>
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit" style="padding: 8px 20px; background: #2563eb; color: white; border: none; border-radius: 6px; font-size: 14px; cursor: pointer;">
                    Apply Filters
                </button>
                <a href="{{ route('admin.scans.index') }}" style="padding: 8px 20px; background: #f3f4f6; color: #374151; text-decoration: none; border-radius: 6px; display: inline-block; font-size: 14px;">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <thead>
                <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                    <th style="padding: 8px 10px; text-align: left; font-weight: 600; color: #374151; font-size: 12px;">ID</th>
                    <th style="padding: 8px 10px; text-align: left; font-weight: 600; color: #374151; font-size: 12px;">Customer</th>
                    <th style="padding: 8px 10px; text-align: left; font-weight: 600; color: #374151; font-size: 12px;">Email</th>
                    <th style="padding: 8px 10px; text-align: left; font-weight: 600; color: #374151; font-size: 12px;">Phone</th>
                    <th style="padding: 8px 10px; text-align: left; font-weight: 600; color: #374151; font-size: 12px;">QR Code</th>
                    <th style="padding: 8px 10px; text-align: left; font-weight: 600; color: #374151; font-size: 12px;">Gift</th>
                    <th style="padding: 8px 10px; text-align: left; font-weight: 600; color: #374151; font-size: 12px;">Status</th>
                    <th style="padding: 8px 10px; text-align: left; font-weight: 600; color: #374151; font-size: 12px;">Submission Date & Time</th>
                    <th style="padding: 8px 10px; text-align: left; font-weight: 600; color: #374151; font-size: 12px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($scans as $scan)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 8px 10px;">{{ $scan->id }}</td>
                        <td style="padding: 8px 10px;">
                            <strong style="color: #1f2937; font-size: 13px;">{{ $scan->name }}</strong>
                        </td>
                        <td style="padding: 8px 10px;">
                            <a href="mailto:{{ $scan->email }}" style="color: #2563eb; text-decoration: none; font-size: 12px;">
                                {{ $scan->email }}
                            </a>
                        </td>
                        <td style="padding: 8px 10px;">
                            <a href="tel:{{ $scan->phone }}" style="color: #2563eb; text-decoration: none; font-size: 12px;">
                                {{ $scan->phone }}
                            </a>
                        </td>
                        <td style="padding: 8px 10px;">
                            <code style="padding: 3px 6px; background: #f3f4f6; color: #374151; border-radius: 3px; font-size: 11px;">
                                {{ $scan->qrCode->code ?? 'N/A' }}
                            </code>
                        </td>
                        <td style="padding: 8px 10px;">
                            <span style="padding: 3px 8px; background: #dbeafe; color: #1e40af; border-radius: 10px; font-size: 11px; white-space: nowrap;">
                                {{ $scan->qrCode->gift->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td style="padding: 8px 10px;">
                            <form action="{{ route('admin.scans.updateStatus', $scan) }}" method="POST" style="margin: 0;">
                                @csrf
                                <select name="gift_status" onchange="this.form.submit()" style="padding: 4px 8px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 11px; cursor: pointer; background: {{ 
                                    $scan->gift_status === 'delivered' ? '#d1fae5' : 
                                    ($scan->gift_status === 'sent' ? '#dbeafe' : 
                                    ($scan->gift_status === 'confirmed' ? '#fef3c7' : '#f3f4f6')) 
                                }}; color: {{ 
                                    $scan->gift_status === 'delivered' ? '#065f46' : 
                                    ($scan->gift_status === 'sent' ? '#1e40af' : 
                                    ($scan->gift_status === 'confirmed' ? '#92400e' : '#6b7280')) 
                                }};">
                                    <option value="pending" {{ $scan->gift_status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="confirmed" {{ $scan->gift_status === 'confirmed' ? 'selected' : '' }}>✓ Confirmed</option>
                                    <option value="sent" {{ $scan->gift_status === 'sent' ? 'selected' : '' }}>📦 Sent</option>
                                    <option value="delivered" {{ $scan->gift_status === 'delivered' ? 'selected' : '' }}>✅ Delivered</option>
                                </select>
                            </form>
                        </td>
                        <td style="padding: 8px 10px; font-size: 12px; white-space: nowrap;">
                            {{ $scan->created_at->format('M d, Y H:i:s') }}<br>
                            <small style="color: #6b7280; font-size: 10px;">{{ $scan->created_at->diffForHumans() }}</small>
                        </td>
                        <td style="padding: 8px 10px;">
                            <div style="display: flex; gap: 5px; white-space: nowrap;">
                                <a href="{{ route('admin.scans.show', $scan) }}" style="padding: 5px 10px; background: #dbeafe; color: #1e40af; text-decoration: none; border-radius: 4px; font-size: 11px;">
                                    View
                                </a>
                                <a href="{{ route('admin.scans.edit', $scan) }}" style="padding: 5px 10px; background: #f3f4f6; color: #374151; text-decoration: none; border-radius: 4px; font-size: 11px;">
                                    Edit
                                </a>
                                <form action="{{ route('admin.scans.destroy', $scan) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="padding: 5px 10px; background: #fee2e2; color: #991b1b; border: none; border-radius: 4px; font-size: 11px; cursor: pointer;">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="padding: 40px; text-align: center; color: #6b7280;">
                            No customer scans found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($scans->hasPages())
        <div style="padding: 20px; border-top: 1px solid #e5e7eb;">
            {{ $scans->links() }}
        </div>
    @endif
</div>

<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-top: 20px;">
    <div class="card" style="text-align: center; padding: 20px;">
        <div style="font-size: 32px; font-weight: 700; color: #2563eb;">{{ \App\Models\Scan::count() }}</div>
        <div style="color: #6b7280; margin-top: 5px;">Total Scans</div>
    </div>
    <div class="card" style="text-align: center; padding: 20px;">
        <div style="font-size: 32px; font-weight: 700; color: #10b981;">{{ \App\Models\Scan::whereDate('created_at', today())->count() }}</div>
        <div style="color: #6b7280; margin-top: 5px;">Today</div>
    </div>
    <div class="card" style="text-align: center; padding: 20px;">
        <div style="font-size: 32px; font-weight: 700; color: #f59e0b;">{{ \App\Models\Scan::whereMonth('created_at', now()->month)->count() }}</div>
        <div style="color: #6b7280; margin-top: 5px;">This Month</div>
    </div>
    <div class="card" style="text-align: center; padding: 20px;">
        <div style="font-size: 32px; font-weight: 700; color: #8b5cf6;">{{ \App\Models\Scan::distinct('email')->count('email') }}</div>
        <div style="color: #6b7280; margin-top: 5px;">Unique Customers</div>
    </div>
</div>

@push('scripts')
<script>
    function toggleFilters() {
        const panel = document.getElementById('filtersPanel');
        panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
    }

    // Show filters if any filter is active
    @if(request('search') || request('gift_status') || request('date_from') || request('date_to'))
        document.getElementById('filtersPanel').style.display = 'block';
    @endif
</script>
@endpush
@endsection

