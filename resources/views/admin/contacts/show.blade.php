@extends('admin.layout')

@section('title', 'Contact Details')

@section('content')
<div class="admin-content">
    <div class="content-header">
        <div>
            <a href="{{ route('admin.contacts.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Contacts
            </a>
            <h1><i class="fas fa-envelope-open"></i> Contact Request #{{ $contact->id }}</h1>
            <p>View and manage customer inquiry</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        <!-- Contact Details -->
        <div>
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); color: white; padding: 25px; border-radius: 15px 15px 0 0;">
                    <h2 style="margin: 0; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-user-circle"></i> Customer Information
                    </h2>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <label><i class="fas fa-user"></i> Full Name</label>
                            <p>{{ $contact->name }}</p>
                        </div>
                        <div class="info-item">
                            <label><i class="fas fa-envelope"></i> Email Address</label>
                            <p><a href="mailto:{{ $contact->email }}" style="color: var(--primary-color);">{{ $contact->email }}</a></p>
                        </div>
                        <div class="info-item">
                            <label><i class="fas fa-phone"></i> Phone Number</label>
                            <p>
                                @if($contact->phone)
                                    <a href="tel:{{ $contact->phone }}" style="color: var(--primary-color);">{{ $contact->phone }}</a>
                                @else
                                    <span style="color: var(--text-gray);">Not provided</span>
                                @endif
                            </p>
                        </div>
                        <div class="info-item">
                            <label><i class="far fa-calendar-alt"></i> Submitted On</label>
                            <p>{{ $contact->created_at->format('F d, Y') }} at {{ $contact->created_at->format('h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top: 20px;">
                <div class="card-header" style="background: #f8f9fa; padding: 20px; border-radius: 15px 15px 0 0;">
                    <h3 style="margin: 0; display: flex; align-items: center; gap: 10px; color: var(--text-dark);">
                        <i class="fas fa-comment-dots"></i> Message
                    </h3>
                </div>
                <div class="card-body">
                    <div style="background: var(--bg-light-pink); padding: 25px; border-radius: 10px; border-left: 4px solid var(--primary-color);">
                        <p style="line-height: 1.8; color: var(--text-dark); margin: 0; white-space: pre-wrap;">{{ $contact->message }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status & Actions -->
        <div>
            <div class="card">
                <div class="card-header" style="background: #f8f9fa; padding: 20px; border-radius: 15px 15px 0 0;">
                    <h3 style="margin: 0; display: flex; align-items: center; gap: 10px; color: var(--text-dark);">
                        <i class="fas fa-tasks"></i> Status & Actions
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.contacts.update-status', $contact->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="form-group">
                            <label><i class="fas fa-flag"></i> Status</label>
                            <select name="status" class="form-control" required>
                                <option value="new" {{ $contact->status === 'new' ? 'selected' : '' }}>
                                    New
                                </option>
                                <option value="in_progress" {{ $contact->status === 'in_progress' ? 'selected' : '' }}>
                                    In Progress
                                </option>
                                <option value="resolved" {{ $contact->status === 'resolved' ? 'selected' : '' }}>
                                    Resolved
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-sticky-note"></i> Admin Notes</label>
                            <textarea name="admin_notes" class="form-control" rows="5" placeholder="Add internal notes about this inquiry...">{{ $contact->admin_notes }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </form>

                    <hr style="margin: 25px 0; border-color: var(--border-color);">

                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <a href="mailto:{{ $contact->email }}" class="btn btn-outline-primary" style="width: 100%;">
                            <i class="fas fa-reply"></i> Reply via Email
                        </a>
                        @if($contact->phone)
                        <a href="tel:{{ $contact->phone }}" class="btn btn-outline-primary" style="width: 100%;">
                            <i class="fas fa-phone"></i> Call Customer
                        </a>
                        @endif
                        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this contact request?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="width: 100%;">
                                <i class="fas fa-trash"></i> Delete Request
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top: 20px;">
                <div class="card-header" style="background: #f8f9fa; padding: 20px; border-radius: 15px 15px 0 0;">
                    <h3 style="margin: 0; display: flex; align-items: center; gap: 10px; color: var(--text-dark);">
                        <i class="fas fa-info-circle"></i> Quick Info
                    </h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div style="display: flex; justify-content: space-between; padding: 10px; background: var(--bg-light-pink); border-radius: 8px;">
                            <span style="color: var(--text-gray);">Status:</span>
                            @if($contact->status === 'new')
                                <strong style="color: #f59e0b;">New</strong>
                            @elseif($contact->status === 'in_progress')
                                <strong style="color: #3b82f6;">In Progress</strong>
                            @else
                                <strong style="color: #10b981;">Resolved</strong>
                            @endif
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 10px; background: var(--bg-light-pink); border-radius: 8px;">
                            <span style="color: var(--text-gray);">Submitted:</span>
                            <strong>{{ $contact->created_at->diffForHumans() }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 10px; background: var(--bg-light-pink); border-radius: 8px;">
                            <span style="color: var(--text-gray);">Last Updated:</span>
                            <strong>{{ $contact->updated_at->diffForHumans() }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 20px;
        transition: all 0.3s;
    }
    .back-link:hover {
        gap: 12px;
    }
    .card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .card-body {
        padding: 25px;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .info-item label {
        display: block;
        font-size: 0.85rem;
        color: var(--text-gray);
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-item p {
        font-size: 1.05rem;
        color: var(--text-dark);
        font-weight: 600;
        margin: 0;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 10px;
        font-weight: 600;
        color: var(--text-dark);
    }
    .form-control {
        width: 100%;
        padding: 12px;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(155, 93, 143, 0.1);
    }
    .btn-outline-primary {
        background: white;
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
    }
    .btn-outline-primary:hover {
        background: var(--primary-color);
        color: white;
    }
    @media (max-width: 1024px) {
        .admin-content > div {
            grid-template-columns: 1fr !important;
        }
        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
