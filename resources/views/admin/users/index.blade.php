@extends('admin.layout')

@section('title', 'Users')
@section('page-title', 'Users Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-users"></i>
            All Users
        </h2>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Contact</th>
                        <th>Role</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <span style="font-weight: 600; color: var(--admin-primary);">#{{ $user->id }}</span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #7c3aed, #ec4899); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: var(--text-primary);">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 0.875rem;">
                                    <div style="color: var(--text-primary);"><i class="fas fa-envelope" style="color: var(--admin-primary); margin-right: 0.5rem;"></i>{{ $user->email }}</div>
                                    <div style="color: var(--text-secondary); margin-top: 0.25rem;"><i class="fas fa-phone" style="color: var(--admin-primary); margin-right: 0.5rem;"></i>{{ $user->phone ?? 'N/A' }}</div>
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('admin.users.update', $user) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" class="form-control" style="width: 130px; padding: 0.5rem; font-size: 0.8rem; font-weight: 600; background: {{ $user->role === 'admin' ? '#fee2e2' : '#dcfce7' }}; color: {{ $user->role === 'admin' ? '#991b1b' : '#166534' }}; border: 2px solid {{ $user->role === 'admin' ? '#fca5a5' : '#86efac' }};" onchange="this.form.submit()">
                                        <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <div style="font-size: 0.875rem;">
                                    <div style="font-weight: 600; color: var(--text-primary);">{{ $user->created_at->format('M d, Y') }}</div>
                                    <div style="color: var(--text-secondary); font-size: 0.75rem;">{{ $user->created_at->format('h:i A') }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.users.show', $user) }}" class="action-btn action-btn-view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $users->links() }}
    </div>
</div>
@endsection
