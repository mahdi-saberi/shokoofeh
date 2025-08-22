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

        // Placeholder images using placehold.co with different sizes and colors
        $placeholderImages = [
            // Small product images (400x400)
            'https://placehold.co/400x400/FF6B6B/FFFFFF?text=اسباب+بازی',
            'https://placehold.co/400x400/4ECDC4/FFFFFF?text=لگو',
            'https://placehold.co/400x400/45B7D1/FFFFFF?text=عروسک',
            'https://placehold.co/400x400/96CEB4/FFFFFF?text=ماشین',
            'https://placehold.co/400x400/FFEAA7/31343C?text=پازل',
            'https://placehold.co/400x400/DDA0DD/FFFFFF?text=بازی+رومیزی',
            'https://placehold.co/400x400/98D8C8/FFFFFF?text=کارت',
            'https://placehold.co/400x400/F7DC6F/31343C?text=هنری',
            'https://placehold.co/400x400/BB8FCE/FFFFFF?text=موسیقی',
            'https://placehold.co/400x400/85C1E9/FFFFFF?text=ورزشی',

            // Medium product images (500x500)
            'https://placehold.co/500x500/FF9F43/FFFFFF?text=Kids+Toy',
            'https://placehold.co/500x500/00B894/FFFFFF?text=لگو+خلاقانه',
            'https://placehold.co/500x500/74B9FF/FFFFFF?text=عروسک+زیبا',
            'https://placehold.co/500x500/FDCB6E/31343C?text=ماشین+کنترلی',
            'https://placehold.co/500x500/E17055/FFFFFF?text=پازل+هوشمند',
            'https://placehold.co/500x500/6C5CE7/FFFFFF?text=بازی+فکری',
            'https://placehold.co/500x500/A29BFE/FFFFFF?text=کارت+آموزشی',
            'https://placehold.co/500x500/00CEC9/FFFFFF?text=هنر+کودکانه',
            'https://placehold.co/500x500/FF7675/FFFFFF?text=موسیقی+کودک',
            'https://placehold.co/500x500/55A3FF/FFFFFF?text=ورزش+کودکانه',

            // Large product images (600x600)
            'https://placehold.co/600x600/FF6B6B/FFFFFF?text=اسباب+بازی+عالی',
            'https://placehold.co/600x600/4ECDC4/FFFFFF?text=لگو+پیشرفته',
            'https://placehold.co/600x600/45B7D1/FFFFFF?text=عروسک+محبوب',
            'https://placehold.co/600x600/96CEB4/FFFFFF?text=ماشین+سریع',
            'https://placehold.co/600x600/FFEAA7/31343C?text=پازل+چالش‌برانگیز',
            'https://placehold.co/600x600/DDA0DD/FFFFFF?text=بازی+استراتژیک',
            'https://placehold.co/600x600/98D8C8/FFFFFF?text=کارت+هوشمند',
            'https://placehold.co/600x600/F7DC6F/31343C?text=هنر+خلاقانه',
            'https://placehold.co/600x600/BB8FCE/FFFFFF?text=موسیقی+آموزشی',
            'https://placehold.co/600x600/85C1E9/FFFFFF?text=ورزش+مفرح'
        ];

        $updatedCount = 0;

        foreach ($products as $product) {
            // Select a random placeholder image
            $randomImage = $placeholderImages[array_rand($placeholderImages)];

            // Update product with image
            $product->update(['image' => $randomImage]);
            $updatedCount++;
        }

        echo "✅ Successfully updated {$updatedCount} products with placeholder images!\n";
        echo "🖼️ Using placehold.co for high-quality placeholder images\n";
    }
}
