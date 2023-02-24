<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Products2 extends Component
{
    use WithPagination;

    public $search;
    public $pagination;

    public $columns = ['Nombre', 'Categoría', 'Estado', 'Precio', 'Marca', 'Stock disponible', 'Nº de ventas', 'Creado el'];
    public $activeColumns = [];
    public $showColumn = true;

    public function mount()
    {
        $this->activeColumns = ['Nombre', 'Categoría', 'Estado', 'Precio', 'Marca', 'Stock disponible', 'Nº de ventas', 'Creado el'];
    }

    public function activateColumn($column)
    {
        return in_array($column, $this->activeColumns);
    }

    public function render()
    {
        $products = Product::query()
            ->applyFilters([
                'search' => $this->search,
            ])
            ->paginate($this->pagination ? $this->pagination : 10);

        return view('livewire.admin.products2', compact('products'))
            ->layout('layouts.admin');
    }
}
