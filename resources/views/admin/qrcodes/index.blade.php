@extends('admin.layouts.app')

@section('title', 'QR Codes')
@section('page-title', 'QR Codes Management')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>All QR Codes</h3>
        <div style="display: flex; gap: 10px; align-items: center;">
            <button id="bulkDeleteBtn" onclick="bulkDelete()" style="display: none; padding: 10px 20px; background: #dc2626; color: white; border: none; border-radius: 6px; font-size: 14px; cursor: pointer;">
                🗑️ Delete Selected (<span id="selectedCount">0</span>)
            </button>
            <button onclick="truncateQRCodes()" style="padding: 10px 20px; background: #991b1b; color: white; border: none; border-radius: 6px; display: inline-block; font-size: 14px; cursor: pointer;">
                ⚠️ Truncate All QR Codes
            </button>
            <button onclick="openPrintModal()" style="padding: 10px 20px; background: #8b5cf6; color: white; border: none; border-radius: 6px; display: inline-block; font-size: 14px; cursor: pointer;">
                🖨️ Print QR Codes
            </button>
            <button onclick="openBulkModal()" style="padding: 10px 20px; background: #10b981; color: white; border: none; border-radius: 6px; display: inline-block; font-size: 14px; cursor: pointer;">
                ⚡ Generate Bulk QR Codes
            </button>
            <a href="{{ route('admin.qrcodes.create') }}" style="padding: 10px 20px; background: #2563eb; color: white; text-decoration: none; border-radius: 6px; display: inline-block; font-size: 14px;">
                + Generate QR Codes
            </a>
        </div>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; width: 50px;">
                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)" style="cursor: pointer; width: 18px; height: 18px;">
                    </th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">ID</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Code</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Gift</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Batch</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Status</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Scanned At</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($qrCodes as $qrCode)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 12px; text-align: center;">
                            <input type="checkbox" class="qr-checkbox" value="{{ $qrCode->id }}" onchange="updateBulkDeleteButton()" style="cursor: pointer; width: 18px; height: 18px;">
                        </td>
                        <td style="padding: 12px;">{{ $qrCode->id }}</td>
                        <td style="padding: 12px;">
                            <code style="padding: 4px 8px; background: #f3f4f6; color: #374151; border-radius: 4px; font-size: 12px;">
                                {{ $qrCode->code }}
                            </code>
                        </td>
                        <td style="padding: 12px;">{{ $qrCode->gift->name ?? 'N/A' }}</td>
                        <td style="padding: 12px;">{{ $qrCode->batch_number ?? 'N/A' }}</td>
                        <td style="padding: 12px;">
                            <span style="padding: 4px 12px; background: {{ $qrCode->is_scanned ? '#fef3c7' : '#d1fae5' }}; color: {{ $qrCode->is_scanned ? '#92400e' : '#065f46' }}; border-radius: 12px; font-size: 12px;">
                                {{ $qrCode->is_scanned ? 'Scanned' : 'Available' }}
                            </span>
                        </td>
                        <td style="padding: 12px;">
                            {{ $qrCode->scanned_at ? $qrCode->scanned_at->format('M d, Y H:i') : '-' }}
                        </td>
                        <td style="padding: 12px;">
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('admin.qrcodes.download', $qrCode) }}" style="padding: 6px 12px; background: #dbeafe; color: #1e40af; text-decoration: none; border-radius: 4px; font-size: 12px;">
                                    📥 PNG
                                </a>
                                <a href="{{ route('admin.qrcodes.downloadSvg', $qrCode) }}" style="padding: 6px 12px; background: #ecfdf5; color: #065f46; text-decoration: none; border-radius: 4px; font-size: 12px;">
                                    🎨 SVG
                                </a>
                                <a href="{{ route('admin.qrcodes.edit', $qrCode) }}" style="padding: 6px 12px; background: #f3f4f6; color: #374151; text-decoration: none; border-radius: 4px; font-size: 12px;">
                                    Edit
                                </a>
                                <form action="{{ route('admin.qrcodes.destroy', $qrCode) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this QR code?');">
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
                            No QR codes found. <a href="{{ route('admin.qrcodes.create') }}" style="color: #2563eb; text-decoration: none;">Generate your first QR codes</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($qrCodes->hasPages())
        <div style="padding: 20px; border-top: 1px solid #e5e7eb;">
            {{ $qrCodes->links() }}
        </div>
    @endif
</div>

<!-- Bulk Generation Modal -->
<div id="bulkModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 12px; padding: 30px; max-width: 500px; width: 90%; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h3 style="font-size: 24px; color: #1f2937; margin: 0;">⚡ Generate Bulk QR Codes</h3>
            <button onclick="closeBulkModal()" style="background: none; border: none; font-size: 28px; color: #6b7280; cursor: pointer; padding: 0; line-height: 1;">×</button>
        </div>

        <form action="{{ route('admin.qrcodes.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 20px;">
                <label for="bulk_gift_id" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                    Select Gift <span style="color: #dc2626;">*</span>
                </label>
                <select name="gift_id" id="bulk_gift_id" required
                    style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                    <option value="">Choose a gift...</option>
                    @php
                        $gifts = \App\Models\Gift::where('is_active', true)->get();
                    @endphp
                    @foreach($gifts as $gift)
                        <option value="{{ $gift->id }}">{{ $gift->name }} ({{ $gift->type }})</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label for="bulk_quantity" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                    Quantity <span style="color: #dc2626;">*</span>
                </label>
                <input type="number" name="quantity" id="bulk_quantity" required min="1" max="200" value="200"
                    style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                    placeholder="Enter quantity (Max: 200)">
                <small style="color: #6b7280; font-size: 12px; display: block; margin-top: 5px;">
                    💡 Recommended: 200 QR codes per M&M packet batch
                </small>
            </div>

            <div style="margin-bottom: 20px;">
                <label for="bulk_batch_number" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                    Batch Number (Optional)
                </label>
                <input type="text" name="batch_number" id="bulk_batch_number"
                    style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                    placeholder="e.g., BATCH-001">
            </div>

            <div style="padding: 15px; background: #ecfdf5; border: 2px solid #6ee7b7; border-radius: 8px; margin-bottom: 25px;">
                <p style="color: #065f46; margin: 0; font-size: 14px; line-height: 1.5;">
                    <strong>⚡ Quick Tip:</strong> Bulk generation will create all QR codes instantly. You can download them individually or use batch operations later.
                </p>
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closeBulkModal()" style="padding: 12px 24px; background: #f3f4f6; color: #374151; border: none; border-radius: 8px; font-size: 14px; cursor: pointer; font-weight: 500;">
                    Cancel
                </button>
                <button type="submit" style="padding: 12px 24px; background: #10b981; color: white; border: none; border-radius: 8px; font-size: 14px; cursor: pointer; font-weight: 500;">
                    🚀 Generate Now
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Print QR Codes Modal -->
<div id="printModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 12px; padding: 30px; max-width: 550px; width: 90%; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3); max-height: 90vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h3 style="font-size: 24px; color: #1f2937; margin: 0;">🖨️ Print QR Codes</h3>
            <button onclick="closePrintModal()" style="background: none; border: none; font-size: 28px; color: #6b7280; cursor: pointer; padding: 0; line-height: 1;">×</button>
        </div>

        <form action="{{ route('admin.qrcodes.print') }}" method="GET" target="_blank">
            <!-- Scan Status Filter -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                    QR Code Status <span style="color: #dc2626;">*</span>
                </label>
                <select name="status" id="print_status" required
                    style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                    <option value="all">All QR Codes</option>
                    <option value="scanned">Scanned Only</option>
                    <option value="not_scanned">Not Scanned Only</option>
                </select>
            </div>

            <!-- Gift Filter -->
            <div style="margin-bottom: 20px;">
                <label for="print_gift_id" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                    Filter by Gift (Optional)
                </label>
                <select name="gift_id" id="print_gift_id"
                    style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                    <option value="">All Gifts</option>
                    @php
                        $gifts = \App\Models\Gift::all();
                    @endphp
                    @foreach($gifts as $gift)
                        <option value="{{ $gift->id }}">{{ $gift->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Batch Filter -->
            <div style="margin-bottom: 20px;">
                <label for="print_batch" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                    Filter by Batch (Optional)
                </label>
                <input type="text" name="batch_number" id="print_batch"
                    style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                    placeholder="e.g., BATCH-001">
            </div>

            <!-- Limit -->
            <div style="margin-bottom: 20px;">
                <label for="print_limit" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                    Number of QR Codes (Optional)
                </label>
                <input type="number" name="limit" id="print_limit" min="1" max="500"
                    style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;"
                    placeholder="Leave empty for all matching codes">
                <small style="color: #6b7280; font-size: 12px; display: block; margin-top: 5px;">
                    Max: 500 codes per sheet
                </small>
            </div>

            <!-- Page Size -->
            <div style="margin-bottom: 20px;">
                <label for="print_size" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                    QR Code Size
                </label>
                <select name="size" id="print_size"
                    style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px;">
                    <option value="small">Small (6 per row)</option>
                    <option value="medium" selected>Medium (4 per row)</option>
                    <option value="large">Large (3 per row)</option>
                </select>
            </div>

            <div style="padding: 15px; background: #fef3c7; border: 2px solid #fbbf24; border-radius: 8px; margin-bottom: 25px;">
                <p style="color: #92400e; margin: 0; font-size: 14px; line-height: 1.5;">
                    <strong>💡 Printing Tips:</strong><br>
                    • Use A4 paper for best results<br>
                    • Set printer margins to minimal<br>
                    • Print in high quality mode
                </p>
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closePrintModal()" style="padding: 12px 24px; background: #f3f4f6; color: #374151; border: none; border-radius: 8px; font-size: 14px; cursor: pointer; font-weight: 500;">
                    Cancel
                </button>
                <button type="submit" style="padding: 12px 24px; background: #8b5cf6; color: white; border: none; border-radius: 8px; font-size: 14px; cursor: pointer; font-weight: 500;">
                    🖨️ Open Print Preview
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openBulkModal() {
        document.getElementById('bulkModal').style.display = 'flex';
    }

    function closeBulkModal() {
        document.getElementById('bulkModal').style.display = 'none';
    }

    function openPrintModal() {
        document.getElementById('printModal').style.display = 'flex';
    }

    function closePrintModal() {
        document.getElementById('printModal').style.display = 'none';
    }

    // Toggle select all checkboxes
    function toggleSelectAll(selectAllCheckbox) {
        const checkboxes = document.querySelectorAll('.qr-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
        updateBulkDeleteButton();
    }

    // Update bulk delete button visibility and count
    function updateBulkDeleteButton() {
        const checkboxes = document.querySelectorAll('.qr-checkbox:checked');
        const count = checkboxes.length;
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        const selectedCount = document.getElementById('selectedCount');
        
        if (count > 0) {
            bulkDeleteBtn.style.display = 'inline-block';
            selectedCount.textContent = count;
        } else {
            bulkDeleteBtn.style.display = 'none';
        }

        // Update select all checkbox state
        const allCheckboxes = document.querySelectorAll('.qr-checkbox');
        const selectAllCheckbox = document.getElementById('selectAll');
        if (allCheckboxes.length > 0) {
            selectAllCheckbox.checked = count === allCheckboxes.length;
        }
    }

    // Bulk delete function
    function bulkDelete() {
        const checkboxes = document.querySelectorAll('.qr-checkbox:checked');
        const ids = Array.from(checkboxes).map(cb => cb.value);
        
        if (ids.length === 0) {
            alert('Please select at least one QR code to delete.');
            return;
        }

        if (!confirm(`Are you sure you want to delete ${ids.length} QR code(s)? This action cannot be undone.`)) {
            return;
        }

        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.qrcodes.bulkDelete") }}';
        
        // Add CSRF token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        // Add method spoofing
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        // Add selected IDs
        ids.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = id;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    }

    // Close modals when clicking outside
    document.getElementById('bulkModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeBulkModal();
        }
    });

    document.getElementById('printModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePrintModal();
        }
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeBulkModal();
            closePrintModal();
        }
    });

    // Truncate all QR codes
    function truncateQRCodes() {
        if (!confirm('⚠️ WARNING: This will DELETE ALL QR CODES permanently!\n\nThis action cannot be undone. Are you absolutely sure?')) {
            return;
        }

        // Double confirmation
        if (!confirm('This is your last chance! All QR codes will be permanently deleted. Continue?')) {
            return;
        }

        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.qrcodes.truncate") }}';
        
        // Add CSRF token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        // Add method spoofing
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
    }
</script>
@endpush
@endsection

