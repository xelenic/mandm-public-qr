@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="card" style="border-left: 4px solid #3b82f6;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 14px; color: #6b7280; margin-bottom: 8px;">Total Users</div>
                <div style="font-size: 32px; font-weight: 700; color: #1f2937;">{{ $totalUsers }}</div>
            </div>
            <div style="width: 60px; height: 60px; background: #eff6ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                👥
            </div>
        </div>
    </div>

    <div class="card" style="border-left: 4px solid #8b5cf6;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 14px; color: #6b7280; margin-bottom: 8px;">Total Admins</div>
                <div style="font-size: 32px; font-weight: 700; color: #1f2937;">{{ $totalAdmins }}</div>
            </div>
            <div style="width: 60px; height: 60px; background: #f5f3ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                👤
            </div>
        </div>
    </div>

    <div class="card" style="border-left: 4px solid #10b981;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <div style="font-size: 14px; color: #6b7280; margin-bottom: 8px;">Regular Users</div>
                <div style="font-size: 32px; font-weight: 700; color: #1f2937;">{{ $totalUsers - $totalAdmins }}</div>
            </div>
            <div style="width: 60px; height: 60px; background: #ecfdf5; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                📊
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Recent Users</h3>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; font-size: 14px;">Name</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; font-size: 14px;">Email</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; font-size: 14px;">Role</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; font-size: 14px;">Joined</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentUsers as $user)
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 12px; color: #1f2937;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 36px; height: 36px; border-radius: 50%; background: #e5e7eb; display: flex; align-items: center; justify-content: center; color: #4b5563; font-weight: 600; font-size: 14px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                {{ $user->name }}
                            </div>
                        </td>
                        <td style="padding: 12px; color: #6b7280;">{{ $user->email }}</td>
                        <td style="padding: 12px;">
                            @if($user->is_admin)
                                <span style="display: inline-block; padding: 4px 12px; background: #fef3c7; color: #92400e; border-radius: 12px; font-size: 12px; font-weight: 600;">Admin</span>
                            @else
                                <span style="display: inline-block; padding: 4px 12px; background: #dbeafe; color: #1e40af; border-radius: 12px; font-size: 12px; font-weight: 600;">User</span>
                            @endif
                        </td>
                        <td style="padding: 12px; color: #6b7280; font-size: 14px;">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 40px; text-align: center; color: #9ca3af;">
                            No users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Quick Actions</h3>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
        <a href="{{ route('admin.users.index') }}" style="display: block; padding: 20px; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; text-decoration: none; color: #1f2937; transition: all 0.3s; text-align: center;">
            <div style="font-size: 24px; margin-bottom: 8px;">👥</div>
            <div style="font-weight: 600;">Manage Users</div>
        </a>
        <a href="#" style="display: block; padding: 20px; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; text-decoration: none; color: #1f2937; transition: all 0.3s; text-align: center;">
            <div style="font-size: 24px; margin-bottom: 8px;">⚙️</div>
            <div style="font-weight: 600;">Settings</div>
        </a>
        <a href="#" style="display: block; padding: 20px; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; text-decoration: none; color: #1f2937; transition: all 0.3s; text-align: center;">
            <div style="font-size: 24px; margin-bottom: 8px;">📊</div>
            <div style="font-weight: 600;">Reports</div>
        </a>
    </div>
</div>
@endsection

