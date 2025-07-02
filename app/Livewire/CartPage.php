<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cart Page')]
class CartPage extends Component
{
    public $cartItems = [];
    public $grandTotal;

    public function mount() {
        $this->cartItems = CartManagement::getCartItemsFromCookie();
        $this->grandTotal = CartManagement::calculateGrantTotal($this->cartItems);
    }

    public function removeItem($productId) {
        $this->cartItems = CartManagement::removeItemFromCart($productId);
        $this->grandTotal = CartManagement::calculateGrantTotal($this->cartItems);

        $totalCount = is_array($this->cartItems) ? count($this->cartItems) : (int) $this->cartItems;
        $this->dispatch('update-cart-count', ['total_count' => $totalCount])->to(Navbar::class);
    }

    public function render() {
        return view('livewire.cart-page');
    }
}
