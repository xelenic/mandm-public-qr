@extends('admin.layouts.app')

@section('title', 'Create Gift')
@section('page-title', 'Create New Gift')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Add New Gift</h3>
    </div>

    <form action="{{ route('admin.gifts.store') }}" method="POST">
        @csrf

        <div style="margin-bottom: 20px;">
            <label for="name" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                Gift Name <span style="color: #dc2626;">*</span>
            </label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;"
                placeholder="e.g., Spa Ceylon Gift Voucher">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="type" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                Gift Type <span style="color: #dc2626;">*</span>
            </label>
            <input type="text" name="type" id="type" value="{{ old('type') }}" required
                style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;"
                placeholder="e.g., voucher, dinner">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="value" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                Gift Value (Optional)
            </label>
            <input type="number" name="value" id="value" value="{{ old('value') }}" step="0.01" min="0"
                style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;"
                placeholder="e.g., 50.00">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="description" style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">
                Description (Optional)
            </label>
            <textarea name="description" id="description" rows="4"
                style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px;"
                placeholder="Enter gift description...">{{ old('description') }}</textarea>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                    style="width: 18px; height: 18px; cursor: pointer;">
                <span style="font-weight: 500; color: #374151;">Active</span>
            </label>
        </div>

        <div style="display: flex; gap: 10px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <button type="submit" style="padding: 10px 24px; background: #2563eb; color: white; border: none; border-radius: 6px; font-size: 14px; cursor: pointer;">
                Create Gift
            </button>
            <a href="{{ route('admin.gifts.index') }}" style="padding: 10px 24px; background: #f3f4f6; color: #374151; text-decoration: none; border-radius: 6px; font-size: 14px; display: inline-block;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

