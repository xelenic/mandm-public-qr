@extends('admin.layouts.app')

@section('title', 'Edit QR Code')
@section('page-title', 'Edit QR Code')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Edit QR Code: {{ $qrcode->code }}</h3>
    </div>

    <!-- Critical Warning for QR Code Changes (Hidden by default, shown when editing enabled) -->
    <div id="criticalWarning" style="display: none; padding: 20px; background: #fef2f2; border: 3px solid #dc2626; border-radius: 8px; margin-bottom: 20px; animation: shake 0.5s;">
        <div style="display: flex; align-items: start; gap: 10px;">
            <span style="font-size: 32px;">🚨</span>
            <div>
                <strong style="color: #991b1b; display: block; margin-bottom: 5px; font-size: 18px;">CRITICAL: QR Code Editing Enabled</strong>
                <p style="color: #991b1b; margin: 0; font-size: 14px; line-height: 1.6;">
                    You have enabled editing of the <strong>QR code itself</strong>. Changing the code will:
                    <br>• Make old printed QR codes invalid
                    <br>• Require reprinting and redistributing new codes
                    <br>• Break existing stickers/labels
                    <br><strong>⚠️ Only change the code if absolutely necessary!</strong>
                </p>
            </div>
        </div>
    </div>

    <!-- Warning Alert -->
    @if($qrcode->is_scanned)
        <div style="padding: 20px; background: #fee2e2; border: 2px solid #fca5a5; border-radius: 8px; margin-bottom: 20px;">
            <div style="display: flex; align-items: start; gap: 10px;">
                <span style="font-size: 24px;">⚠️</span>
                <div>
                    <strong style="color: #991b1b; display: block; margin-bottom: 5px; font-size: 16px;">WARNING: This QR Code Has Been Scanned</strong>
                    <p style="color: #991b1b; margin: 0; font-size: 14px; line-height: 1.6;">
                        This QR code was already scanned @if($qrcode->scanned_at) on <strong>{{ $qrcode->scanned_at->format('M d, Y H:i') }}</strong> @endif by a customer.
                        Changing the code or gift assignment may cause confusion or issues with prize fulfillment.
                        <strong>Please proceed with extreme caution.</strong>
                    </p>
                </div>
            </div>
        </div>
    @else
        <div style="padding: 20px; background: #fef3c7; border: 2px solid #fbbf24; border-radius: 8px; margin-bottom: 20px;">
            <div style="display: flex; align-items: start; gap: 10px;">
                <span style="font-size: 24px;">⚠️</span>
                <div>
                    <strong style="color: #92400e; display: block; margin-bottom: 5px; font-size: 16px;">Warning: Editing QR Code</strong>
                    <p style="color: #92400e; margin: 0; font-size: 14px; line-height: 1.6;">
                        Changes to the code, gift assignment, or batch number will affect what customers receive when they scan this code.
                        Make sure this is the correct change before proceeding.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <form id="editQRCodeForm" action="{{ route('admin.qrcodes.update', $qrcode) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- QR Code Edit Toggle -->
        <div style="margin-bottom: 20px; padding: 15px; background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 8px;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <strong style="color: #374151; display: block; margin-bottom: 5px;">🔒 QR Code Editing</strong>
                    <small style="color: #6b7280; font-size: 12px;">Enable this to edit the QR code itself (requires reprinting)</small>
                </div>
                <label style="position: relative; display: inline-block; width: 60px; height: 34px; cursor: pointer;">
                    <input type="checkbox" id="enableCodeEdit" style="opacity: 0; width: 0; height: 0;">
                    <span id="toggleSlider" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 34px;">
                        <span style="position: absolute; content: ''; height: 26px; width: 26px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%;"></span>
                    </span>
                </label>
            </div>
        </div>

        <!-- QR Code Field -->
        <div style="margin-bottom: 20px;">
            <label for="code" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                QR Code <span id="requiredIndicator" style="color: #6b7280; display: none;">*</span>
                <span id="editStatusBadge" style="padding: 3px 8px; background: #fee2e2; color: #991b1b; border-radius: 4px; font-size: 11px; margin-left: 8px; display: none;">
                    🔓 EDITING ENABLED
                </span>
            </label>
            <input type="text" name="code" id="code" value="{{ old('code', $qrcode->code) }}" disabled
                style="width: 100%; padding: 10px 12px; border: 2px solid #d1d5db; border-radius: 6px; font-size: 14px; font-family: monospace; background: #f9fafb; cursor: not-allowed;"
                placeholder="e.g., MM-XXXXXXXXXX">
            <input type="hidden" id="original_code" value="{{ $qrcode->code }}">
            <input type="hidden" name="code_readonly" id="code_readonly" value="{{ $qrcode->code }}">
            <small id="codeHint" style="color: #6b7280; font-size: 12px; display: block; margin-top: 5px;">
                🔒 Enable "QR Code Editing" above to modify the code
            </small>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="gift_id" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                Assign Gift <span style="color: #dc2626;">*</span>
            </label>
            <select name="gift_id" id="gift_id" required
                style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;">
                <option value="">Select a gift...</option>
                @foreach($gifts as $gift)
                    <option value="{{ $gift->id }}" {{ old('gift_id', $qrcode->gift_id) == $gift->id ? 'selected' : '' }}>
                        {{ $gift->name }} ({{ $gift->type }})
                    </option>
                @endforeach
            </select>
            <input type="hidden" id="original_gift_id" value="{{ $qrcode->gift_id }}">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="batch_number" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                Batch Number (Optional)
            </label>
            <input type="text" name="batch_number" id="batch_number" value="{{ old('batch_number', $qrcode->batch_number) }}"
                style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;"
                placeholder="e.g., BATCH-001">
        </div>

        <div style="display: flex; gap: 10px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <button type="submit" id="submitBtn" style="padding: 10px 24px; background: #2563eb; color: white; border: none; border-radius: 6px; font-size: 14px; cursor: pointer;">
                Update QR Code
            </button>
            <a href="{{ route('admin.qrcodes.index') }}" style="padding: 10px 24px; background: #f3f4f6; color: #374151; text-decoration: none; border-radius: 6px; font-size: 14px; display: inline-block;">
                Cancel
            </a>
        </div>
    </form>

    @push('styles')
    <style>
        /* Toggle Switch Styles */
        #enableCodeEdit:checked + #toggleSlider {
            background-color: #dc2626;
        }

        #enableCodeEdit:checked + #toggleSlider span {
            transform: translateX(26px);
        }

        /* Shake animation for warning */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        /* Pulse animation for edit badge */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .pulse {
            animation: pulse 2s infinite;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Toggle QR Code editing
        const enableCodeEditCheckbox = document.getElementById('enableCodeEdit');
        const codeInput = document.getElementById('code');
        const codeHint = document.getElementById('codeHint');
        const editStatusBadge = document.getElementById('editStatusBadge');
        const criticalWarning = document.getElementById('criticalWarning');

        const requiredIndicator = document.getElementById('requiredIndicator');

        enableCodeEditCheckbox.addEventListener('change', function() {
            if (this.checked) {
                // Enable editing
                codeInput.disabled = false;
                codeInput.required = true;
                codeInput.style.background = '#fff';
                codeInput.style.cursor = 'text';
                codeInput.style.borderColor = '#dc2626';
                codeInput.style.borderWidth = '2px';
                codeInput.focus();
                
                // Show required indicator
                requiredIndicator.style.display = 'inline';
                requiredIndicator.style.color = '#dc2626';
                
                // Update hint
                codeHint.innerHTML = '⚠️ <strong>WARNING:</strong> Changing the QR code will require regenerating and reprinting the physical QR code';
                codeHint.style.color = '#dc2626';
                
                // Show badge
                editStatusBadge.style.display = 'inline';
                editStatusBadge.classList.add('pulse');
                
                // Show critical warning
                criticalWarning.style.display = 'block';
                
                // Confirm enable
                const confirmEnable = confirm(
                    '🔓 Enable QR Code Editing?\n\n' +
                    'This will allow you to change the QR code itself.\n' +
                    'Only enable this if you need to change the code.\n\n' +
                    'Click OK to enable editing.'
                );
                
                if (!confirmEnable) {
                    this.checked = false;
                    codeInput.disabled = true;
                    codeInput.required = false;
                    codeInput.style.background = '#f9fafb';
                    codeInput.style.cursor = 'not-allowed';
                    codeInput.style.borderColor = '#d1d5db';
                    codeInput.style.borderWidth = '2px';
                    requiredIndicator.style.display = 'none';
                    codeHint.innerHTML = '🔒 Enable "QR Code Editing" above to modify the code';
                    codeHint.style.color = '#6b7280';
                    editStatusBadge.style.display = 'none';
                    criticalWarning.style.display = 'none';
                }
            } else {
                // Disable editing
                codeInput.disabled = true;
                codeInput.required = false;
                codeInput.style.background = '#f9fafb';
                codeInput.style.cursor = 'not-allowed';
                codeInput.style.borderColor = '#d1d5db';
                codeInput.style.borderWidth = '2px';
                codeInput.value = document.getElementById('original_code').value; // Reset to original
                
                // Hide required indicator
                requiredIndicator.style.display = 'none';
                
                // Update hint
                codeHint.innerHTML = '🔒 Enable "QR Code Editing" above to modify the code';
                codeHint.style.color = '#6b7280';
                
                // Hide badge
                editStatusBadge.style.display = 'none';
                editStatusBadge.classList.remove('pulse');
                
                // Hide critical warning
                criticalWarning.style.display = 'none';
            }
        });

        // Form submission
        document.getElementById('editQRCodeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const isScanned = {{ $qrcode->is_scanned ? 'true' : 'false' }};
            const originalGiftId = document.getElementById('original_gift_id').value;
            const newGiftId = document.getElementById('gift_id').value;
            const giftChanged = originalGiftId !== newGiftId;
            
            const originalCode = document.getElementById('original_code').value;
            const newCode = document.getElementById('code').value;
            const codeChanged = originalCode !== newCode;
            
            let message = '';
            let title = '';
            
            // Critical warning if QR code itself is changed
            if (codeChanged) {
                title = '🚨 CRITICAL: QR Code Change Detected';
                message = '⚠️ YOU ARE ABOUT TO CHANGE THE QR CODE ITSELF!\n\n' +
                          'Original Code: ' + originalCode + '\n' +
                          'New Code: ' + newCode + '\n\n' +
                          'This is a CRITICAL change that will:\n' +
                          '• Make the old physical QR code INVALID\n' +
                          '• Require printing and redistributing NEW QR codes\n' +
                          '• Break any existing printed stickers\n';
                
                if (isScanned) {
                    message += '• INVALIDATE the customer scan record\n' +
                              '• Cause MAJOR confusion for customers\n\n' +
                              '🚨 THIS QR CODE WAS ALREADY SCANNED!\n' +
                              'Changing it now is EXTREMELY DANGEROUS!\n\n';
                } else {
                    message += '• Only the new code will work going forward\n\n';
                }
                
                message += 'Are you ABSOLUTELY CERTAIN you want to change the QR code?';
                
                if (!confirm(message)) {
                    return false;
                }
                
                // Extra confirmation for code change
                const codeConfirm = confirm('🚨 FINAL CONFIRMATION:\n\n' +
                    'You are changing:\n' +
                    originalCode + ' → ' + newCode + '\n\n' +
                    'This CANNOT be easily undone.\n' +
                    'Old printed codes will NOT work.\n\n' +
                    'Type-confirm by clicking OK if you understand the risks.');
                
                if (!codeConfirm) {
                    return false;
                }
            }
            
            // Regular gift/batch warnings
            if (isScanned) {
                title = '⚠️ WARNING: QR Code Already Scanned';
                const scanDate = '{{ $qrcode->scanned_at ? $qrcode->scanned_at->format("M d, Y H:i") : "unknown date" }}';
                if (giftChanged) {
                    message = 'This QR code has ALREADY been scanned by a customer on ' + scanDate + '.\n\n' +
                              'You are about to CHANGE the gift assignment. This may cause:\n' +
                              '• Confusion for the customer who already scanned it\n' +
                              '• Issues with prize fulfillment\n' +
                              '• Data inconsistency\n\n' +
                              'Are you absolutely sure you want to proceed with this change?';
                } else if (!codeChanged) {
                    message = 'This QR code has ALREADY been scanned by a customer on ' + scanDate + '.\n\n' +
                              'You are about to edit this QR code. Changes may affect:\n' +
                              '• Prize fulfillment records\n' +
                              '• Customer expectations\n\n' +
                              'Are you sure you want to proceed?';
                }
            } else {
                if (giftChanged && !codeChanged) {
                    title = '⚠️ Confirm QR Code Edit';
                    message = 'You are about to CHANGE the gift assignment for this QR code.\n\n' +
                              'Current gift will be replaced with the new selection.\n' +
                              'This will affect what customers receive when they scan this code.\n\n' +
                              'Are you sure you want to proceed?';
                } else if (!codeChanged) {
                    title = '⚠️ Confirm QR Code Edit';
                    message = 'You are about to edit this QR code.\n\n' +
                              'Changes will affect future scans of this code.\n\n' +
                              'Are you sure you want to proceed?';
                }
            }
            
            if (message && confirm(message)) {
                // Double confirmation for scanned codes with gift changes
                if (isScanned && giftChanged && !codeChanged) {
                    const doubleConfirm = confirm('⚠️ FINAL WARNING:\n\n' +
                        'This QR code was already scanned. Changing the gift now will:\n' +
                        '• Override the original gift assignment\n' +
                        '• Potentially confuse the customer\n' +
                        '• May require manual intervention\n\n' +
                        'Click OK only if you are CERTAIN this change is necessary.');
                    
                    if (doubleConfirm) {
                        form.submit();
                    }
                } else {
                    form.submit();
                }
            } else if (!message) {
                // If no message (only code changed and confirmed above)
                form.submit();
            }
        });
    </script>
    @endpush
</div>
@endsection

