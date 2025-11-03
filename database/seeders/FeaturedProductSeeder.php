<?php

namespace Database\Seeders;

use App\Models\Shop\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FeaturedProductSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Setting up featured products...');

        // Get first 4 products and make them featured
        $products = Product::where('is_visible', true)
            ->orderBy('id')
            ->limit(4)
            ->get();

        foreach ($products as $index => $product) {
            // Set as featured
            $product->update(['featured' => true]);

            // Add sample images from local_images directory
            $imageFiles = [
                '1aa69e68-a504-4495-bc38-5c520d035d8b.jpg',
                '20d2e61e-3273-4521-9c47-e56a68c892fb.jpg',
                '248eadf6-5227-42f3-ad31-1c320febdb7b.jpg',
                '2f5c09b5-6268-47b2-8e0b-c4890850e727.jpg'
            ];

            $imagePath = database_path('seeders/local_images/200x200/' . $imageFiles[$index]);
            
            if (file_exists($imagePath)) {
                // Copy image to storage
                $fileName = 'products/featured_' . $product->id . '_' . $imageFiles[$index];
                Storage::disk('public')->put($fileName, file_get_contents($imagePath));
                
                // Add to media library
                $product->addMediaFromDisk($fileName, 'public')
                    ->toMediaCollection('product-images');
                
                $this->command->info("Added image for product: {$product->name}");
            }
        }

        $this->command->info('Featured products setup completed!');
        $this->command->info('Featured products count: ' . Product::where('featured', true)->count());
    }
}