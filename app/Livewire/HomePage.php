<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Home - Daya Karya Sport')]
class HomePage extends Component
{
    protected $fillable = ['name', 'slug', 'image', 'is_active'];

    public function render()
    {
        $brands = Brand::where('is_active', 1)->get();
        $categories = Category::where('is_active', 1)->get();
        return view('livewire.home-page', [
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }
}
