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
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #374151; font-size: 14px;">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, email, or phone..."
                        style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
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
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">ID</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Customer Name</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Email</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Phone</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">QR Code</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Gift Won</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Scan Date</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($scans as $scan)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 12px;">{{ $scan->id }}</td>
                        <td style="padding: 12px;">
                            <strong style="color: #1f2937;">{{ $scan->name }}</strong>
                        </td>
                        <td style="padding: 12px;">
                            <a href="mailto:{{ $scan->email }}" style="color: #2563eb; text-decoration: none;">
                                {{ $scan->email }}
                            </a>
                        </td>
                        <td style="padding: 12px;">
                            <a href="tel:{{ $scan->phone }}" style="color: #2563eb; text-decoration: none;">
                                {{ $scan->phone }}
                            </a>
                        </td>
                        <td style="padding: 12px;">
                            <code style="padding: 4px 8px; background: #f3f4f6; color: #374151; border-radius: 4px; font-size: 12px;">
                                {{ $scan->qrCode->code ?? 'N/A' }}
                            </code>
                        </td>
                        <td style="padding: 12px;">
                            <span style="padding: 4px 12px; background: #dbeafe; color: #1e40af; border-radius: 12px; font-size: 12px;">
                                {{ $scan->qrCode->gift->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td style="padding: 12px;">
                            {{ $scan->created_at->format('M d, Y H:i') }}
                        </td>
                        <td style="padding: 12px;">
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('admin.scans.show', $scan) }}" style="padding: 6px 12px; background: #dbeafe; color: #1e40af; text-decoration: none; border-radius: 4px; font-size: 12px;">
                                    View
                                </a>
                                <a href="{{ route('admin.scans.edit', $scan) }}" style="padding: 6px 12px; background: #f3f4f6; color: #374151; text-decoration: none; border-radius: 4px; font-size: 12px;">
                                    Edit
                                </a>
                                <form action="{{ route('admin.scans.destroy', $scan) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this record?');">
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
                        <td colspan="8" style="padding: 40px; text-align: center; color: #6b7280;">
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
    @if(request('search') || request('date_from') || request('date_to'))
        document.getElementById('filtersPanel').style.display = 'block';
    @endif
</script>
@endpush
@endsection

