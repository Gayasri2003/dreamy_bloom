<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Contact;

class ContactTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $status = 'all';

   
    public function applyFilters(): void
    {
        $this->resetPage();
    }

    public function updateStatus(int $id, string $newStatus): void
    {
        if (!auth()->check()) abort(403);

        $allowed = [
            Contact::STATUS_NEW,
            Contact::STATUS_IN_PROGRESS,
            Contact::STATUS_RESOLVED,
        ];

        if (!in_array($newStatus, $allowed, true)) {
            $newStatus = Contact::STATUS_NEW;
        }

        Contact::where('id', $id)->update(['status' => $newStatus]);

        session()->flash('success', 'Status updated successfully.');
    }

    public function delete(int $id): void
    {
        if (!auth()->check()) abort(403);

        Contact::where('id', $id)->delete();

        session()->flash('success', 'Message deleted.');
        $this->resetPage();
    }

    public function render()
    {
        $search = trim((string) $this->search);

        $query = Contact::query();

        if ($this->status !== 'all') {
            $query->where('status', $this->status);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        return view('livewire.admin.contact-table', [
            'contacts' => $query->latest()->paginate(10),
        ]);
    }
}
