<div>
    {{-- Filters bar (same UI feel as old page) --}}
    <div style="
        display:flex; gap:12px; flex-wrap:wrap; align-items:center;
        margin: 18px 0 18px; padding: 18px;
        background: #fff; border-radius: 16px;
        box-shadow: 0 6px 22px rgba(0,0,0,0.06);
    ">
        <input
            type="text"
            wire:model.defer="search"
            placeholder="Search contacts..."
            class="sort-dropdown"
            style="min-width:260px; max-width: 360px; padding-right: 18px; background-image:none;"
        />

        <select wire:model.defer="status" class="sort-dropdown" style="min-width: 200px;">
            <option value="all">All</option>
            <option value="{{ \App\Models\Contact::STATUS_NEW }}">New</option>
            <option value="{{ \App\Models\Contact::STATUS_IN_PROGRESS }}">In Progress</option>
            <option value="{{ \App\Models\Contact::STATUS_RESOLVED }}">Resolved</option>
        </select>

        <button
            type="button"
            wire:click="applyFilters"
            style="
                padding: 12px 18px; border-radius: 12px; border: none; cursor: pointer;
                background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
                color: #fff; font-weight: 800;
                box-shadow: 0 8px 18px rgba(155, 93, 143, 0.25);
                display:flex; align-items:center; gap:10px;
            "
        >
            <i class="fas fa-search"></i> Apply
        </button>

        <div wire:loading wire:target="applyFilters,delete,updateStatus"
             style="font-weight:800; color: var(--primary-color); margin-left: 6px;">
            Loading...
        </div>
    </div>

    {{-- Flash message --}}
    @if (session('success'))
        <div class="alert alert-success" style="margin-bottom: 16px;">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Table container (use your existing admin CSS classes) --}}
    <div class="data-table-container"
         style="background: white; border-radius: 20px; box-shadow: 0 4px 25px rgba(0,0,0,0.08); overflow: hidden;">

        <table class="data-table" style="margin: 0; width:100%;">
            <thead>
                <tr style="background: linear-gradient(135deg, var(--bg-pink), var(--bg-light-pink));">
                    <th style="padding: 20px 15px; color: var(--primary-color); font-weight: 800; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">ID</th>
                    <th style="padding: 20px 15px; color: var(--primary-color); font-weight: 800; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Customer</th>
                    <th style="padding: 20px 15px; color: var(--primary-color); font-weight: 800; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Contact Info</th>
                    <th style="padding: 20px 15px; color: var(--primary-color); font-weight: 800; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Message Preview</th>
                    <th style="padding: 20px 15px; color: var(--primary-color); font-weight: 800; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Status</th>
                    <th style="padding: 20px 15px; color: var(--primary-color); font-weight: 800; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Date</th>
                    <th style="padding: 20px 15px; color: var(--primary-color); font-weight: 800; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($contacts as $c)
                    <tr style="border-bottom: 1px solid #f3f4f6; transition: all 0.25s;">
                        {{-- ID --}}
                        <td style="padding: 20px 15px;">
                            <div style="
                                background: linear-gradient(135deg, #e9d5ff, #d8b4fe);
                                color: #6b21a8; font-weight: 900; padding: 8px 15px;
                                border-radius: 10px; display: inline-block; font-size: 0.9rem;">
                                #{{ $c->id }}
                            </div>
                        </td>

                        {{-- Customer --}}
                        <td style="padding: 20px 15px;">
                            <div style="display:flex; align-items:center; gap: 15px;">
                                <div style="
                                    width: 50px; height: 50px;
                                    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
                                    border-radius: 15px;
                                    display:flex; align-items:center; justify-content:center;
                                    color:#fff; font-weight: 900; font-size: 1.1rem;
                                    box-shadow: 0 4px 15px rgba(155, 93, 143, 0.25);
                                ">
                                    {{ strtoupper(substr($c->name, 0, 1)) }}
                                </div>

                                <div>
                                    <strong style="display:block; color: var(--text-dark); font-size: 1.05rem;">
                                        {{ $c->name }}
                                    </strong>
                                    <small style="color: var(--text-gray); font-size: 0.85rem;">
                                        <i class="far fa-clock"></i> {{ $c->created_at?->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </td>

                        {{-- Contact Info --}}
                        <td style="padding: 20px 15px;">
                            <div style="display:flex; flex-direction:column; gap: 8px;">
                                <a href="mailto:{{ $c->email }}"
                                   style="
                                        color:#3b82f6; text-decoration:none;
                                        display:inline-flex; align-items:center; gap:8px;
                                        padding: 6px 10px; background:#eff6ff;
                                        border-radius: 8px; width: fit-content;
                                   ">
                                    <i class="fas fa-envelope"></i>
                                    <span style="font-size: 0.9rem;">{{ \Illuminate\Support\Str::limit($c->email, 28) }}</span>
                                </a>

                                @if($c->phone)
                                    <a href="tel:{{ $c->phone }}"
                                       style="
                                            color:#10b981; text-decoration:none;
                                            display:inline-flex; align-items:center; gap:8px;
                                            padding: 6px 10px; background:#ecfdf5;
                                            border-radius: 8px; width: fit-content;
                                       ">
                                        <i class="fas fa-phone"></i>
                                        <span style="font-size: 0.9rem;">{{ $c->phone }}</span>
                                    </a>
                                @else
                                    <span style="color: var(--text-gray); font-size: 0.85rem; font-style: italic;">No phone</span>
                                @endif
                            </div>
                        </td>

                        {{-- Message Preview --}}
                        <td style="padding: 20px 15px;">
                            <div style="max-width: 350px; background: var(--bg-light-pink); padding: 12px 15px; border-radius: 10px; border-left: 3px solid var(--primary-color);">
                                <span style="color: var(--text-dark); line-height: 1.5; font-size: 0.95rem;">
                                    {{ \Illuminate\Support\Str::limit($c->message, 60) }}
                                </span>
                            </div>
                        </td>

                        {{-- Status (live update) --}}
                        <td style="padding: 20px 15px;">
                            <select
                                wire:change="updateStatus({{ $c->id }}, $event.target.value)"
                                style="
                                    padding: 10px 14px; border-radius: 12px;
                                    border: 2px solid #e5e7eb; background: #fff;
                                    font-weight: 700; cursor: pointer;
                                "
                            >
                                <option value="{{ \App\Models\Contact::STATUS_NEW }}"
                                    @selected($c->status === \App\Models\Contact::STATUS_NEW)>
                                    New
                                </option>

                                <option value="{{ \App\Models\Contact::STATUS_IN_PROGRESS }}"
                                    @selected($c->status === \App\Models\Contact::STATUS_IN_PROGRESS)>
                                    In Progress
                                </option>

                                <option value="{{ \App\Models\Contact::STATUS_RESOLVED }}"
                                    @selected($c->status === \App\Models\Contact::STATUS_RESOLVED)>
                                    Resolved
                                </option>
                            </select>
                        </td>

                        {{-- Date --}}
                        <td style="padding: 20px 15px;">
                            <div style="display:flex; flex-direction:column; gap:5px;">
                                <div style="display:flex; align-items:center; gap:8px; color: var(--text-dark); font-weight:700;">
                                    <i class="far fa-calendar-alt" style="color: var(--primary-color);"></i>
                                    {{ $c->created_at?->format('M d, Y') }}
                                </div>
                                <div style="display:flex; align-items:center; gap:8px; color: var(--text-gray); font-size: 0.9rem;">
                                    <i class="far fa-clock" style="color: var(--primary-color);"></i>
                                    {{ $c->created_at?->format('h:i A') }}
                                </div>
                            </div>
                        </td>

                        {{-- Actions --}}
                        <td style="padding: 20px 15px;">
                            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                                <a href="{{ route('admin.contacts.show', $c->id) }}"
                                   style="
                                        padding: 10px 14px;
                                        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
                                        color:#fff; border-radius: 10px; text-decoration:none;
                                        font-weight: 800; display:inline-flex; align-items:center; gap:8px;
                                        box-shadow: 0 4px 12px rgba(155, 93, 143, 0.25);
                                   ">
                                    <i class="fas fa-eye"></i> View
                                </a>

                                <button type="button"
                                        wire:click="delete({{ $c->id }})"
                                        onclick="return confirm('Delete this message?')"
                                        style="
                                            padding: 10px 14px; border: none;
                                            background: linear-gradient(135deg, #ef4444, #dc2626);
                                            color:#fff; border-radius: 10px; cursor:pointer;
                                            font-weight: 900; display:inline-flex; align-items:center; gap:8px;
                                            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
                                        ">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 60px 20px; color: var(--text-gray);">
                            No messages found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($contacts->hasPages())
            <div style="padding: 18px; display:flex; justify-content:center;">
                {{ $contacts->links() }}
            </div>
        @endif
    </div>
</div>
