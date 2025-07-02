<?php

namespace App\Livewire;

use App\HasAlerts;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products - Daya Karya Sport')]
class ProductsPage extends Component
{
    use WithPagination;
    use HasAlerts;

    #[Url()]
    public $selectedCategory = [];
    
    #[Url()]
    public $selectedBrand = [];

    #[Url()]
    public $popular;

    #[Url()]
    public $onSale;

    #[Url()]
    public $priceRange = 100000000;

    #[Url()]
    public $sort = 'latest';

    public function addToCart($productId) {
        $totalCount = CartManagement::addItemToCart($productId);

        $this->dispatch('update-cart-count', ['total_count' => $totalCount])->to(Navbar::class);

        $this->toastSuccess('Produk berhasil ditambahkan!', 'Silakan cek keranjang Anda.');
    }

    public function render()
    {
        $productQuery = Product::query()->where('is_active', 1);

        if(!empty($this->selectedBrand)) {
            $productQuery = $productQuery->whereIn('brand_id', $this->selectedBrand);
        }

        if(!empty($this->selectedCategory)) {
            $productQuery = $productQuery->whereIn('category_id', $this->selectedCategory);
        }

        if($this->popular) {
            $productQuery = $productQuery->where('is_popular', 1);
        }

        if($this->onSale) {
            $productQuery = $productQuery->where('on_sale', 1);
        }

        if($this->priceRange) {
            $productQuery = $productQuery->where('price', '<=', $this->priceRange);
        }

        if($this->sort == 'latest') {
            $productQuery->latest();
        }

        if($this->sort == 'price') {
            $productQuery->orderBy('price');
        }

        return view('livewire.products-page', [
            'products'  => $productQuery->paginate(10),
            'brands'    => Brand::where('is_active', 1)->get(['id', 'name', 'slug']),
            'categories'=> Category::where('is_active', 1)->get(['id', 'name', 'slug']),
        ]);
    }
}
