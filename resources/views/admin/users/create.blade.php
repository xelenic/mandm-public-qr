@extends('admin.layouts.app')

@section('title', 'Create User')
@section('page-title', 'Create New User')

@section('content')
<div class="card" style="max-width: 800px;">
    <div class="card-header">
        <h3>User Information</h3>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div style="margin-bottom: 20px;">
            <label for="name" style="display: block; margin-bottom: 8px; color: #374151; font-weight: 500; font-size: 14px;">Name *</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
                style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('name') ? '#ef4444' : '#e5e7eb' }}; border-radius: 6px; font-size: 15px; transition: all 0.3s; background: #ffffff;"
            >
            @error('name')
                <span style="color: #ef4444; font-size: 13px; margin-top: 5px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="email" style="display: block; margin-bottom: 8px; color: #374151; font-weight: 500; font-size: 14px;">Email Address *</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('email') ? '#ef4444' : '#e5e7eb' }}; border-radius: 6px; font-size: 15px; transition: all 0.3s; background: #ffffff;"
            >
            @error('email')
                <span style="color: #ef4444; font-size: 13px; margin-top: 5px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password" style="display: block; margin-bottom: 8px; color: #374151; font-weight: 500; font-size: 14px;">Password *</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('password') ? '#ef4444' : '#e5e7eb' }}; border-radius: 6px; font-size: 15px; transition: all 0.3s; background: #ffffff;"
            >
            @error('password')
                <span style="color: #ef4444; font-size: 13px; margin-top: 5px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password_confirmation" style="display: block; margin-bottom: 8px; color: #374151; font-weight: 500; font-size: 14px;">Confirm Password *</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                required
                style="width: 100%; padding: 10px 14px; border: 1px solid #e5e7eb; border-radius: 6px; font-size: 15px; transition: all 0.3s; background: #ffffff;"
            >
        </div>

        <div style="margin-bottom: 25px;">
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                <input
                    type="checkbox"
                    name="is_admin"
                    value="1"
                    {{ old('is_admin') ? 'checked' : '' }}
                    style="width: 18px; height: 18px; cursor: pointer;"
                >
                <span style="color: #374151; font-weight: 500; font-size: 14px;">Make this user an admin</span>
            </label>
        </div>

        <div style="display: flex; gap: 10px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <button
                type="submit"
                style="padding: 10px 24px; background: #3b82f6; color: white; border: none; border-radius: 6px; font-size: 15px; font-weight: 500; cursor: pointer; transition: all 0.3s;"
            >
                Create User
            </button>
            <a
                href="{{ route('admin.users.index') }}"
                style="padding: 10px 24px; background: #ffffff; color: #6b7280; border: 1px solid #e5e7eb; border-radius: 6px; text-decoration: none; font-size: 15px; font-weight: 500; display: inline-block; transition: all 0.3s;"
            >
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection



