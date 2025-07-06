<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartManagement
{
    // Add item to cart
    static public function addItemToCart($productId)
    {
        $cartItems = self::getCartItemsFromCookie();

        $existingCartItem = null;

        foreach ($cartItems as $key => $cartItem) {
            if ($cartItem['productId'] == $productId) {
                $existingCartItem = $cartItem;
                break;
            }
        }

        if ($existingCartItem !== null) {
            $cartItems[$key]['quantity']++;
            $cartItems[$key]['subtotal'] = $cartItems[$key]['quantity'] * $cartItems[$key]['price'];
        } else {
            $product = Product::where('id', $productId)->first(['id', 'name', 'price', 'thumbnail']);
            if ($product) {
                $cartItems[] = [
                    'productId' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1,
                    'image' => $product->thumbnail,
                    'subtotal' => $product->price
                ];
            }
        }

        self::addCartItemsToCookie($cartItems);
        return count($cartItems);
    }


    static public function addItemToCartWithQty($productId, $qty = 1)
    {
        $cartItems = self::getCartItemsFromCookie();

        $existingCartItem = null;

        foreach ($cartItems as $key => $cartItem) {
            if ($cartItem['productId'] == $productId) {
                $existingCartItem = $cartItem;
                break;
            }
        }

        if ($existingCartItem !== null) {
            $cartItems[$key]['quantity'] = $qty;
            $cartItems[$key]['subtotal'] = $cartItems[$key]['quantity'] * $cartItems[$key]['price'];
        } else {
            $product = Product::where('id', $productId)->first(['id', 'name', 'price', 'thumbnail']);
            if ($product) {
                $cartItems[] = [
                    'productId' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $qty,
                    'image' => $product->thumbnail,
                    'subtotal' => $product->price * $qty
                ];
            }
        }

        self::addCartItemsToCookie($cartItems);
        return count($cartItems);
    }

    // Remove item from cart
    static public function removeItemFromCart($productId)
    {
        $cartItems = self::getCartItemsFromCookie();

        foreach ($cartItems as $key => $cartItem) {
            if ($cartItem['productId'] == $productId) {
                unset($cartItems[$key]);
            }
        }

        self::addCartItemsToCookie($cartItems);
        return count($cartItems);
    }

    // Add cart items to cookie
    static public function addCartItemsToCookie($cartItems)
    {
        Cookie::queue('cartItems', json_encode($cartItems), 60 * 24 * 30);
    }

    // Clear cart items from cookie
    static public function clearCartItemsFromCookie()
    {
        Cookie::queue(Cookie::forget('cartItems'));
    }

    // Get all cart items from cookie
    static public function getCartItemsFromCookie()
    {
        $cartItems = json_decode(Cookie::get('cartItems'), true);

        if (!$cartItems) {
            $cartItems = [];
        }

        return $cartItems;
    }

    // Increment cart quantity
    static public function incrementQuantityToCartItem($productId)
    {
        $cartItems = self::getCartItemsFromCookie();
        foreach ($cartItems as $key => $cartItem) {
            if ($cartItem['productId'] == $productId) {
                $cartItems[$key]['quantity']++;
                $cartItems[$key]['subtotal'] = $cartItems[$key]['quantity'] * $cartItems[$key]['price'];
            }
        }

        self::addCartItemsToCookie($cartItems);
        return $cartItems;
    }

    // Decrement cart quantity
    static public function decrementQuantityToCartItem($productId)
    {
        $cartItems = self::getCartItemsFromCookie();
        foreach ($cartItems as $key => $cartItem) {
            if ($cartItem['productId'] == $productId) {
                if ($cartItem['quantity'] > 1) {
                    $cartItems[$key]['quantity']--;
                    $cartItems[$key]['subtotal'] = $cartItems[$key]['quantity'] * $cartItems[$key]['price'];
                } else {
                    unset($cartItems[$key]);
                }
            }
        }

        self::addCartItemsToCookie($cartItems);
        return $cartItems;
    }

    // Calculate grant total
    static public function calculateGrantTotal($cartItems)
    {
        if (!is_array($cartItems) || empty($cartItems)) {
            return 0;
        }

        return array_sum(array_column($cartItems, 'subtotal'));
    }
}
