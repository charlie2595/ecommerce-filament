<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function afterCreate(): void
{
    $images = $this->form->getState()['product_images'] ?? [];

    foreach ($images as $imagePath) {
        $this->record->images()->create([
            'image' => $imagePath,
        ]);
    }
}
}
