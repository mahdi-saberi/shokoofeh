<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all products without images
        $products = Product::whereNull('image')->orWhere('image', '')->get();
        
        if ($products->isEmpty()) {
            echo "ℹ️ All products already have images!\n";
            return;
        }

        // Placeholder images using placehold.co with vibrant colors and different sizes
        $placeholderImages = [
            // Small product images (400x400) - Vibrant colors
            'https://placehold.co/400x400/FF6B6B/FFFFFF?text=Product',
            'https://placehold.co/400x400/4ECDC4/FFFFFF?text=Lego',
            'https://placehold.co/400x400/45B7D1/FFFFFF?text=Doll',
            'https://placehold.co/400x400/96CEB4/FFFFFF?text=Car',
            'https://placehold.co/400x400/FFEAA7/31343C?text=Puzzle',
            'https://placehold.co/400x400/DDA0DD/FFFFFF?text=Board+Game',
            'https://placehold.co/400x400/98D8C8/FFFFFF?text=Card',
            'https://placehold.co/400x400/F7DC6F/31343C?text=Art',
            'https://placehold.co/400x400/BB8FCE/FFFFFF?text=Music',
            'https://placehold.co/400x400/85C1E9/FFFFFF?text=Sport',
            
            // Medium product images (500x500) - More vibrant colors
            'https://placehold.co/500x500/FF9F43/FFFFFF?text=Kids+Toy',
            'https://placehold.co/500x500/00B894/FFFFFF?text=Creative+Lego',
            'https://placehold.co/500x500/74B9FF/FFFFFF?text=Beautiful+Doll',
            'https://placehold.co/500x500/FDCB6E/31343C?text=RC+Car',
            'https://placehold.co/500x500/E17055/FFFFFF?text=Smart+Puzzle',
            'https://placehold.co/500x500/6C5CE7/FFFFFF?text=Brain+Game',
            'https://placehold.co/500x500/A29BFE/FFFFFF?text=Educational+Card',
            'https://placehold.co/500x500/00CEC9/FFFFFF?text=Kids+Art',
            'https://placehold.co/500x500/FF7675/FFFFFF?text=Kids+Music',
            'https://placehold.co/500x500/55A3FF/FFFFFF?text=Kids+Sport',
            
            // Large product images (600x600) - Premium colors
            'https://placehold.co/600x600/FF6B6B/FFFFFF?text=Amazing+Toy',
            'https://placehold.co/600x600/4ECDC4/FFFFFF?text=Advanced+Lego',
            'https://placehold.co/600x600/45B7D1/FFFFFF?text=Popular+Doll',
            'https://placehold.co/600x600/96CEB4/FFFFFF?text=Fast+Car',
            'https://placehold.co/600x600/FFEAA7/31343C?text=Challenging+Puzzle',
            'https://placehold.co/600x600/DDA0DD/FFFFFF?text=Strategic+Game',
            'https://placehold.co/600x600/98D8C8/FFFFFF?text=Smart+Card',
            'https://placehold.co/600x600/F7DC6F/31343C?text=Creative+Art',
            'https://placehold.co/600x600/BB8FCE/FFFFFF?text=Educational+Music',
            'https://placehold.co/600x600/85C1E9/FFFFFF?text=Fun+Sport',
            
            // Extra vibrant colors for variety
            'https://placehold.co/400x400/FF9F43/FFFFFF?text=Toy',
            'https://placehold.co/400x400/00B894/FFFFFF?text=Game',
            'https://placehold.co/400x400/74B9FF/FFFFFF?text=Fun',
            'https://placehold.co/400x400/FDCB6E/31343C?text=Play',
            'https://placehold.co/400x400/E17055/FFFFFF?text=Learn',
            'https://placehold.co/400x400/6C5CE7/FFFFFF?text=Create',
            'https://placehold.co/400x400/A29BFE/FFFFFF?text=Explore',
            'https://placehold.co/400x400/00CEC9/FFFFFF?text=Discover',
            'https://placehold.co/400x400/FF7675/FFFFFF?text=Imagine',
            'https://placehold.co/400x400/55A3FF/FFFFFF?text=Grow'
        ];

        $updatedCount = 0;
        
        foreach ($products as $product) {
            // Select a random placeholder image
            $randomImage = $placeholderImages[array_rand($placeholderImages)];
            
            // Update product with image
            $product->update(['image' => $randomImage]);
            $updatedCount++;
        }

        echo "✅ Successfully updated {$updatedCount} products with vibrant placeholder images!\n";
        echo "🎨 Using placehold.co with random vibrant colors\n";
    }
} 