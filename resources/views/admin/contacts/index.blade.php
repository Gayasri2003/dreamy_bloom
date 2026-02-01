@extends('admin.layout')

@section('title', 'Contact Requests')

@section('content')
<div class="admin-content">
    <div class="content-header" style="background: linear-gradient(135deg, #f3e8ff, #e9d5ff); padding: 30px; border-radius: 20px; margin-bottom: 30px; box-shadow: 0 4px 20px rgba(168, 85, 247, 0.15);">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
            <div>
                <h1 style="display: flex; align-items: center; gap: 15px; color: #7c3aed; margin-bottom: 10px;">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #a855f7, #7c3aed); border-radius: 15px; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 8px 20px rgba(168, 85, 247, 0.3);">
                        <i class="fas fa-envelope-open-text" style="font-size: 1.8rem;"></i>
                    </div>
                    Contact Requests
                </h1>
                <p style="color: #6b21a8; font-size: 1.05rem; margin: 0;">Manage customer inquiries and messages efficiently</p>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <button onclick="filterByStatus('all')" class="filter-btn active" data-status="all">
                    <i class="fas fa-inbox"></i> All
                </button>
                <button onclick="filterByStatus('new')" class="filter-btn" data-status="new">
                    <i class="fas fa-star"></i> New
                </button>
                <button onclick="filterByStatus('in_progress')" class="filter-btn" data-status="in_progress">
                    <i class="fas fa-hourglass-half"></i> In Progress
                </button>
                <button onclick="filterByStatus('resolved')" class="filter-btn" data-status="resolved">
                    <i class="fas fa-check-circle"></i> Resolved
                </button>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); border-left: 5px solid #10b981; padding: 20px 25px; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);">
            <i class="fas fa-check-circle" style="color: #059669; font-size: 1.2rem;"></i> 
            <strong style="color: #065f46;">{{ session('success') }}</strong>
        </div>
    @endif

    <div class="stats-grid" style="margin-bottom: 30px; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div class="stat-card" style="background: linear-gradient(135deg, #fef3c7, #fde68a); padding: 25px; border-radius: 20px; box-shadow: 0 8px 25px rgba(245, 158, 11, 0.2); transition: all 0.3s; cursor: pointer; border: 2px solid transparent;" onclick="filterByStatus('new')">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706); width: 70px; height: 70px; border-radius: 18px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(245, 158, 11, 0.4);">
                    <i class="fas fa-envelope" style="font-size: 2rem; color: white;"></i>
                </div>
                <div class="stat-info">
                    <h3 style="font-size: 2.5rem; margin: 0 0 5px 0; color: #78350f; font-weight: 800;">{{ $contacts->where('status', 'new')->count() }}</h3>
                    <p style="margin: 0; color: #92400e; font-weight: 600; font-size: 0.95rem;">New Messages</p>
                </div>
            </div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); padding: 25px; border-radius: 20px; box-shadow: 0 8px 25px rgba(59, 130, 246, 0.2); transition: all 0.3s; cursor: pointer; border: 2px solid transparent;" onclick="filterByStatus('in_progress')">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb); width: 70px; height: 70px; border-radius: 18px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);">
                    <i class="fas fa-hourglass-half" style="font-size: 2rem; color: white;"></i>
                </div>
                <div class="stat-info">
                    <h3 style="font-size: 2.5rem; margin: 0 0 5px 0; color: #1e3a8a; font-weight: 800;">{{ $contacts->where('status', 'in_progress')->count() }}</h3>
                    <p style="margin: 0; color: #1e40af; font-weight: 600; font-size: 0.95rem;">In Progress</p>
                </div>
            </div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); padding: 25px; border-radius: 20px; box-shadow: 0 8px 25px rgba(16, 185, 129, 0.2); transition: all 0.3s; cursor: pointer; border: 2px solid transparent;" onclick="filterByStatus('resolved')">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669); width: 70px; height: 70px; border-radius: 18px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);">
                    <i class="fas fa-check-circle" style="font-size: 2rem; color: white;"></i>
                </div>
                <div class="stat-info">
                    <h3 style="font-size: 2.5rem; margin: 0 0 5px 0; color: #064e3b; font-weight: 800;">{{ $contacts->where('status', 'resolved')->count() }}</h3>
                    <p style="margin: 0; color: #065f46; font-weight: 600; font-size: 0.95rem;">Resolved</p>
                </div>
            </div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #f3e8ff, #e9d5ff); padding: 25px; border-radius: 20px; box-shadow: 0 8px 25px rgba(168, 85, 247, 0.2); transition: all 0.3s; cursor: pointer; border: 2px solid transparent;" onclick="filterByStatus('all')">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #a855f7, #7c3aed); width: 70px; height: 70px; border-radius: 18px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(168, 85, 247, 0.4);">
                    <i class="fas fa-inbox" style="font-size: 2rem; color: white;"></i>
                </div>
                <div class="stat-info">
                    <h3 style="font-size: 2.5rem; margin: 0 0 5px 0; color: #581c87; font-weight: 800;">{{ $contacts->total() }}</h3>
                    <p style="margin: 0; color: #6b21a8; font-weight: 600; font-size: 0.95rem;">Total Messages</p>
                </div>
            </div>
        </div>
    </div>

    <div class="data-table-container" style="background: white; border-radius: 20px; box-shadow: 0 4px 25px rgba(0,0,0,0.08); overflow: hidden;">
        <div style="padding: 25px 30px; background: linear-gradient(135deg, #fafafa, #f5f5f5); border-bottom: 2px solid #e5e7eb;">
            <h2 style="margin: 0; color: var(--text-dark); font-size: 1.3rem; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-list"></i> All Contact Requests
            </h2>
        </div>
        <table class="data-table" style="margin: 0;">
            <thead>
                <tr style="background: linear-gradient(135deg, var(--bg-pink), var(--bg-light-pink));">
                    <th style="padding: 20px 15px; color: var(--primary-color); font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">ID</th>
                    <th style="padding: 20px 15px; color: var(--primary-color); font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Customer</th>
                    <th style="padding: 20px 15px; color: var(--primary-color); font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Contact Info</th>
                    <th style="padding: 20px 15px; color: var(--primary-color); font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Message Preview</th>
                    <th style="padding: 20px 15px; color: var(--primary-color); font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Status</th>
                    <th style="padding: 20px 15px; color: var(--primary-color); font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Date</th>
                    <th style="padding: 20px 15px; color: var(--primary-color); font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                <tr class="contact-row" data-status="{{ $contact->status }}" style="border-bottom: 1px solid #f3f4f6; transition: all 0.3s;">
                    <td style="padding: 20px 15px;">
                        <div style="background: linear-gradient(135deg, #e9d5ff, #d8b4fe); color: #6b21a8; font-weight: 800; padding: 8px 15px; border-radius: 10px; display: inline-block; font-size: 0.9rem;">
                            #{{ $contact->id }}
                        </div>
                    </td>
                    <td style="padding: 20px 15px;">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); border-radius: 15px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.3rem; box-shadow: 0 4px 15px rgba(155, 93, 143, 0.3);">
                                {{ strtoupper(substr($contact->name, 0, 1)) }}
                            </div>
                            <div>
                                <strong style="display: block; color: var(--text-dark); font-size: 1.05rem;">{{ $contact->name }}</strong>
                                <small style="color: var(--text-gray); font-size: 0.85rem;">
                                    <i class="far fa-clock"></i> {{ $contact->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 20px 15px;">
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <a href="mailto:{{ $contact->email }}" style="color: #3b82f6; text-decoration: none; display: flex; align-items: center; gap: 8px; transition: all 0.3s; padding: 6px 10px; background: #eff6ff; border-radius: 6px; width: fit-content;">
                                <i class="fas fa-envelope" style="font-size: 0.9rem;"></i> 
                                <span style="font-size: 0.9rem;">{{ Str::limit($contact->email, 25) }}</span>
                            </a>
                            @if($contact->phone)
                                <a href="tel:{{ $contact->phone }}" style="color: #10b981; text-decoration: none; display: flex; align-items: center; gap: 8px; transition: all 0.3s; padding: 6px 10px; background: #ecfdf5; border-radius: 6px; width: fit-content;">
                                    <i class="fas fa-phone" style="font-size: 0.9rem;"></i> 
                                    <span style="font-size: 0.9rem;">{{ $contact->phone }}</span>
                                </a>
                            @else
                                <span style="color: var(--text-gray); font-size: 0.85rem; font-style: italic;">No phone</span>
                            @endif
                        </div>
                    </td>
                    <td style="padding: 20px 15px;">
                        <div style="max-width: 350px; background: var(--bg-light-pink); padding: 12px 15px; border-radius: 10px; border-left: 3px solid var(--primary-color);">
                            <p style="margin: 0; color: var(--text-dark); line-height: 1.5; font-size: 0.95rem; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                {{ $contact->message }}
                            </p>
                        </div>
                    </td>
                    <td style="padding: 20px 15px;">
                        @if($contact->status === 'new')
                            <span class="badge badge-warning" style="background: linear-gradient(135deg, #fef3c7, #fde68a); color: #78350f; padding: 10px 20px; border-radius: 25px; font-weight: 700; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);">
                                <i class="fas fa-star" style="font-size: 0.9rem;"></i> New
                            </span>
                        @elseif($contact->status === 'in_progress')
                            <span class="badge badge-info" style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1e3a8a; padding: 10px 20px; border-radius: 25px; font-weight: 700; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);">
                                <i class="fas fa-hourglass-half" style="font-size: 0.9rem;"></i> In Progress
                            </span>
                        @else
                            <span class="badge badge-success" style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #064e3b; padding: 10px 20px; border-radius: 25px; font-weight: 700; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);">
                                <i class="fas fa-check-circle" style="font-size: 0.9rem;"></i> Resolved
                            </span>
                        @endif
                    </td>
                    <td style="padding: 20px 15px;">
                        <div style="display: flex; flex-direction: column; gap: 5px;">
                            <div style="display: flex; align-items: center; gap: 8px; color: var(--text-dark); font-weight: 600;">
                                <i class="far fa-calendar-alt" style="color: var(--primary-color);"></i> 
                                {{ $contact->created_at->format('M d, Y') }}
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px; color: var(--text-gray); font-size: 0.9rem;">
                                <i class="far fa-clock" style="color: var(--primary-color);"></i> 
                                {{ $contact->created_at->format('h:i A') }}
                            </div>
                        </div>
                    </td>
                    <td style="padding: 20px 15px;">
                        <div class="action-buttons" style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-sm btn-primary" title="View Details" style="padding: 10px 15px; background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); color: white; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.3s; box-shadow: 0 4px 12px rgba(155, 93, 143, 0.3);">
                                <i class="fas fa-eye"></i>
                                <span style="font-weight: 600; font-size: 0.85rem;">View</span>
                            </a>
                            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this contact?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete" style="padding: 10px 15px; background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border: none; border-radius: 10px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.3s; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);">
                                    <i class="fas fa-trash"></i>
                                    <span style="font-weight: 600; font-size: 0.85rem;">Delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 80px 20px;">
                        <div style="color: var(--text-gray);">
                            <div style="width: 100px; height: 100px; margin: 0 auto 20px; background: linear-gradient(135deg, var(--bg-pink), var(--bg-light-pink)); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-inbox" style="font-size: 3rem; color: var(--primary-color); opacity: 0.4;"></i>
                            </div>
                            <h3 style="color: var(--text-dark); margin-bottom: 10px;">No contact requests yet</h3>
                            <p style="font-size: 1.05rem; color: var(--text-gray);">Contact submissions will appear here</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($contacts->hasPages())
    <div class="pagination-container" style="margin-top: 30px;">
        {{ $contacts->links() }}
    </div>
    @endif
</div>

<style>
    .filter-btn {
        padding: 10px 20px;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 600;
        color: var(--text-dark);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
    }
    .filter-btn:hover {
        border-color: var(--primary-color);
        background: var(--bg-light-pink);
        color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(155, 93, 143, 0.2);
    }
    .filter-btn.active {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        border-color: var(--primary-color);
        color: white;
        box-shadow: 0 4px 15px rgba(155, 93, 143, 0.3);
    }
    .stat-card {
        transition: all 0.3s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0,0,0,0.15) !important;
        border-color: var(--primary-color) !important;
    }
    .contact-row {
        transition: all 0.3s;
    }
    .contact-row:hover {
        background: var(--bg-light-pink);
        transform: scale(1.01);
    }
    .action-buttons a:hover,
    .action-buttons button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.2) !important;
    }
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .data-table-container {
            overflow-x: auto;
        }
    }
</style>

<script>
    function filterByStatus(status) {
        const rows = document.querySelectorAll('.contact-row');
        const buttons = document.querySelectorAll('.filter-btn');
        
        // Update active button
        buttons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.status === status) {
                btn.classList.add('active');
            }
        });
        
        // Filter rows
        rows.forEach(row => {
            if (status === 'all' || row.dataset.status === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endsection
