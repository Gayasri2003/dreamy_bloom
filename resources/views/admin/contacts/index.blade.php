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

            {{-- NOTE:
                We removed JS filter buttons from here.
                Filtering now happens inside the Livewire component (search + status dropdown).
                This avoids conflicts and makes filtering "real" (server-side).
            --}}
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); border-left: 5px solid #10b981; padding: 20px 25px; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);">
            <i class="fas fa-check-circle" style="color: #059669; font-size: 1.2rem;"></i>
            <strong style="color: #065f46;">{{ session('success') }}</strong>
        </div>
    @endif

    {{-- Stats cards
         IMPORTANT: If $contacts is paginated, these counts will not be accurate.
         Recommended: pass $totalCount, $newCount, $inProgressCount, $resolvedCount from controller.
         If you already do that, use those vars below.
    --}}
    <div class="stats-grid" style="margin-bottom: 30px; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div class="stat-card" style="background: linear-gradient(135deg, #fef3c7, #fde68a); padding: 25px; border-radius: 20px; box-shadow: 0 8px 25px rgba(245, 158, 11, 0.2); transition: all 0.3s; cursor: default; border: 2px solid transparent;">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706); width: 70px; height: 70px; border-radius: 18px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(245, 158, 11, 0.4);">
                    <i class="fas fa-envelope" style="font-size: 2rem; color: white;"></i>
                </div>
                <div class="stat-info">
                    <h3 style="font-size: 2.5rem; margin: 0 0 5px 0; color: #78350f; font-weight: 800;">
                        {{ $newCount ?? 0 }}
                    </h3>
                    <p style="margin: 0; color: #92400e; font-weight: 600; font-size: 0.95rem;">New Messages</p>
                </div>
            </div>
        </div>

        <div class="stat-card" style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); padding: 25px; border-radius: 20px; box-shadow: 0 8px 25px rgba(59, 130, 246, 0.2); transition: all 0.3s; cursor: default; border: 2px solid transparent;">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb); width: 70px; height: 70px; border-radius: 18px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);">
                    <i class="fas fa-hourglass-half" style="font-size: 2rem; color: white;"></i>
                </div>
                <div class="stat-info">
                    <h3 style="font-size: 2.5rem; margin: 0 0 5px 0; color: #1e3a8a; font-weight: 800;">
                        {{ $inProgressCount ?? 0 }}
                    </h3>
                    <p style="margin: 0; color: #1e40af; font-weight: 600; font-size: 0.95rem;">In Progress</p>
                </div>
            </div>
        </div>

        <div class="stat-card" style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); padding: 25px; border-radius: 20px; box-shadow: 0 8px 25px rgba(16, 185, 129, 0.2); transition: all 0.3s; cursor: default; border: 2px solid transparent;">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669); width: 70px; height: 70px; border-radius: 18px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);">
                    <i class="fas fa-check-circle" style="font-size: 2rem; color: white;"></i>
                </div>
                <div class="stat-info">
                    <h3 style="font-size: 2.5rem; margin: 0 0 5px 0; color: #064e3b; font-weight: 800;">
                        {{ $resolvedCount ?? 0 }}
                    </h3>
                    <p style="margin: 0; color: #065f46; font-weight: 600; font-size: 0.95rem;">Resolved</p>
                </div>
            </div>
        </div>

        <div class="stat-card" style="background: linear-gradient(135deg, #f3e8ff, #e9d5ff); padding: 25px; border-radius: 20px; box-shadow: 0 8px 25px rgba(168, 85, 247, 0.2); transition: all 0.3s; cursor: default; border: 2px solid transparent;">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #a855f7, #7c3aed); width: 70px; height: 70px; border-radius: 18px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(168, 85, 247, 0.4);">
                    <i class="fas fa-inbox" style="font-size: 2rem; color: white;"></i>
                </div>
                <div class="stat-info">
                    <h3 style="font-size: 2.5rem; margin: 0 0 5px 0; color: #581c87; font-weight: 800;">
                        {{ $totalCount ?? 0 }}
                    </h3>
                    <p style="margin: 0; color: #6b21a8; font-weight: 600; font-size: 0.95rem;">Total Messages</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Livewire Contact Table Container -->
    <div class="data-table-container" style="background: white; border-radius: 20px; box-shadow: 0 4px 25px rgba(0,0,0,0.08); overflow: hidden;">
        <div style="padding: 25px 30px; background: linear-gradient(135deg, #fafafa, #f5f5f5); border-bottom: 2px solid #e5e7eb;">
            <h2 style="margin: 0; color: var(--text-dark); font-size: 1.3rem; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-list"></i> All Contact Requests
            </h2>
        </div>

        <div style="padding: 20px;">
            <livewire:admin.contact-table />
        </div>
    </div>
</div>

<style>
    .stat-card {
        transition: all 0.3s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0,0,0,0.15) !important;
        border-color: var(--primary-color) !important;
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
@endsection
