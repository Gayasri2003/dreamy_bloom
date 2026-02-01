<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;

class ProductSearch extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Applied filters (used by query)
    public $categoryId = null;
    public $search = '';
    public $sort = 'latest';

    // Draft inputs (used by UI)
    public $searchInput = '';
    public $sortInput = 'latest';

    public function mount()
    {
        // Initialize draft inputs from applied values
        $this->searchInput = $this->search;
        $this->sortInput = $this->sort;
    }

    // Reset pagination when category changes (category applies immediately)
    public function updatingCategoryId()
    {
        $this->resetPage();
    }

    public function setCategory($id = null)
    {
        $this->categoryId = $id;
        $this->resetPage();
    }

    // Apply button / Enter key triggers this
    public function applyFilters()
    {
        $this->search = trim((string) $this->searchInput);
        $this->sort = $this->sortInput;

        $this->resetPage();
    }

    public function render()
    {
        $search = trim((string) $this->search);

        $query = Product::query()->with('category');

        // Category filter (instant)
        if (!empty($this->categoryId)) {
            $query->where('category_id', $this->categoryId);
        }

        // Search filter (only after apply)
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort (only after apply)
        if ($this->sort === 'price_low') {
            $query->orderBy('price', 'asc');
        } elseif ($this->sort === 'price_high') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return view('livewire.product-search', [
            'products' => $query->paginate(8),
            'categories' => Category::select('id', 'name')->get(),
        ]);
    }
}
