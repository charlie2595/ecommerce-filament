<?php

namespace App\Livewire;

use App\HasAlerts;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Title('Product Detail - Daya Karya Sport')]
class ProductDetailPage extends Component
{
    use HasAlerts;
    
    public $slug;
    public $quantity = 1;
    
    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function increaseQty() {
        $this->quantity++;
    }

    public function decreaseQty() {
        if($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart($productId) {
        $totalCount = CartManagement::addItemToCartWithQty($productId, $this->quantity);

        $this->dispatch('update-cart-count', ['total_count' => $totalCount])->to(Navbar::class);

        $this->toastSuccess('Produk berhasil ditambahkan!', 'Silakan cek keranjang Anda.');
    }

    public function render()
    {
        return view('livewire.product-detail-page', [
            'product' => Product::where('slug', $this->slug)->firstOrFail(),
        ]);
    }
}
