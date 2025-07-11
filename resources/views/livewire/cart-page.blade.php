<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-semibold mb-4">Shopping Cart</h1>
        <div class="flex flex-col md:flex-row gap-4">
            <div class="md:w-3/4">
                <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="text-left font-semibold">Product</th>
                                <th class="text-left font-semibold">Price</th>
                                <th class="text-left font-semibold">Quantity</th>
                                <th class="text-left font-semibold">Total</th>
                                <th class="text-left font-semibold">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cartItems as $cartItem)
                                <tr wire:key="{{ $cartItem['productId'] }}">
                                    <td class="py-4">
                                        <div class="flex items-center">
                                            <img class="h-16 w-16 mr-4" src="{{ url('storage', $cartItem['image']) }}" alt="{{ $cartItem['name'] }}">
                                            <span class="font-semibold">{{ $cartItem['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4">{{ GeneralHelper::currencyFormatter($cartItem['price']) }}</td>
                                    <td class="py-4">
                                        <div class="flex items-center">
                                            <button wire:click="decrementQuantity('{{ $cartItem['productId'] }}')" class="border rounded-md py-2 px-4 mr-2 hover:bg-red-500">-</button>
                                            <span class="text-center w-8">{{ $cartItem['quantity'] }}</span>
                                            <button wire:click="incrementQuantity('{{ $cartItem['productId'] }}')" class="border rounded-md py-2 px-4 ml-2 hover:bg-red-500">+</button>
                                        </div>
                                    </td>
                                    <td class="py-4">{{ GeneralHelper::currencyFormatter($cartItem['subtotal']) }}</td>
                                    <td>
                                        <button wire:click="removeItem('{{ $cartItem['productId'] }}')" class="bg-slate-300 border-2 border-slate-400 rounded-lg px-3 py-1 hover:bg-red-500 hover:text-white hover:border-red-700"><span wire:loading.remove wire:target('removeItem('{{ $cartItem['productId'] }}')')>Remove</span><span wire:loading  wire:target('removeItem('{{ $cartItem['productId'] }}')')>Removing...</span></button> 
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-4xl font-semibold text-slate-500">No items in cart.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="md:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold mb-4">Summary</h2>
                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span>{{ GeneralHelper::currencyFormatter($grandTotal) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Taxes</span>
                        <span>{{ GeneralHelper::currencyFormatter(0) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Shipping</span>
                        <span>{{ GeneralHelper::currencyFormatter(0) }}</span>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">Total</span>
                        <span class="font-semibold">{{ GeneralHelper::currencyFormatter($grandTotal) }}</span>
                    </div>
                    @if($cartItems)
                        <a href="{{ route('checkout') }}" class="bg-blue-500 block text-center text-white py-2 px-4 rounded-lg mt-4 w-full">Checkout</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>