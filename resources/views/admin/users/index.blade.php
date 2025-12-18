@extends('admin.layouts.app')

@section('title', 'Users')
@section('page-title', 'Users Management')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3 style="margin: 0;">All Users</h3>
        <a href="{{ route('admin.users.create') }}" style="padding: 10px 20px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 500; transition: all 0.3s;">
            + Add New User
        </a>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; font-size: 14px;">Name</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; font-size: 14px;">Email</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; font-size: 14px;">Role</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #374151; font-size: 14px;">Joined</th>
                    <th style="padding: 12px; text-align: center; font-weight: 600; color: #374151; font-size: 14px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
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
                        <td style="padding: 12px;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <a href="{{ route('admin.users.edit', $user) }}" style="padding: 6px 12px; background: #ffffff; color: #3b82f6; border: 1px solid #3b82f6; border-radius: 4px; text-decoration: none; font-size: 13px; transition: all 0.3s;">
                                    Edit
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="padding: 6px 12px; background: #ffffff; color: #ef4444; border: 1px solid #ef4444; border-radius: 4px; cursor: pointer; font-size: 13px; transition: all 0.3s;">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 40px; text-align: center; color: #9ca3af;">
                            No users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div style="padding: 20px; border-top: 1px solid #e5e7eb;">
            <div style="display: flex; justify-content: center; gap: 5px;">
                {{-- Previous Page Link --}}
                @if ($users->onFirstPage())
                    <span style="padding: 8px 12px; background: #f3f4f6; color: #9ca3af; border-radius: 4px; font-size: 14px;">Previous</span>
                @else
                    <a href="{{ $users->previousPageUrl() }}" style="padding: 8px 12px; background: #ffffff; color: #3b82f6; border: 1px solid #e5e7eb; border-radius: 4px; text-decoration: none; font-size: 14px; transition: all 0.3s;">Previous</a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                    @if ($page == $users->currentPage())
                        <span style="padding: 8px 12px; background: #3b82f6; color: white; border-radius: 4px; font-size: 14px; font-weight: 600;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="padding: 8px 12px; background: #ffffff; color: #6b7280; border: 1px solid #e5e7eb; border-radius: 4px; text-decoration: none; font-size: 14px; transition: all 0.3s;">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" style="padding: 8px 12px; background: #ffffff; color: #3b82f6; border: 1px solid #e5e7eb; border-radius: 4px; text-decoration: none; font-size: 14px; transition: all 0.3s;">Next</a>
                @else
                    <span style="padding: 8px 12px; background: #f3f4f6; color: #9ca3af; border-radius: 4px; font-size: 14px;">Next</span>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection








