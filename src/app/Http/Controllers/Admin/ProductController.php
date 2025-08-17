<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Models\AgeGroup;
use App\Models\GameType;
use App\Models\Category;
use App\Models\Tag;
use App\Models\ProductMedia;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereJsonContains('category', $request->category);
        }

        // Filter by game type
        if ($request->filled('game_type')) {
            $query->whereJsonContains('game_type', $request->game_type);
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->byGender($request->gender);
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'in_stock':
                    $query->where('stock', '>', 10);
                    break;
                case 'low_stock':
                    $query->where('stock', '>', 0)->where('stock', '<=', 10);
                    break;
                case 'out_of_stock':
                    $query->where('stock', 0);
                    break;
            }
        }

        // Sorting
        $sort = $request->get('sort', 'created_at_desc');
        switch ($sort) {
            case 'created_at_asc':
                $query->oldest();
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'stock_asc':
                $query->orderBy('stock', 'asc');
                break;
            case 'stock_desc':
                $query->orderBy('stock', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(15)->withQueryString();

        // Get filter options
        $categories = Category::all();
        $gameTypes = GameType::all();

        return view('admin.products.index', compact('products', 'categories', 'gameTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ageGroups = AgeGroup::all();
        $gameTypes = GameType::all();
        $categories = Category::all();
        $tags = Tag::active()->get();

        return view('admin.products.create', compact('ageGroups', 'gameTypes', 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Generate unique product code if not provided
        if (empty($validated['product_code'])) {
            $validated['product_code'] = Product::generateProductCode();
        }

        $product = Product::create($validated);

        // Handle multiple images
        if ($request->hasFile('images')) {
            $this->handleProductMedia($product, $request->file('images'), 'image');
        }

        // Handle videos
        if ($request->hasFile('videos')) {
            $this->handleProductMedia($product, $request->file('videos'), 'video');
        }

        // Handle tags
        if ($request->filled('tags')) {
            $tagData = array_filter(explode(',', $request->tags));
            $tagIds = [];

            foreach ($tagData as $tagItem) {
                if (str_starts_with($tagItem, 'new:')) {
                    // Create new tag
                    $tagName = substr($tagItem, 4); // Remove 'new:' prefix
                    $tag = Tag::create([
                        'name' => $tagName,
                        'slug' => \Illuminate\Support\Str::slug($tagName),
                        'color' => '#6c757d', // Default color for new tags
                        'is_active' => true
                    ]);
                    $tagIds[] = $tag->id;
                } else {
                    // Existing tag
                    $tagIds[] = $tagItem;
                }
            }

            if (!empty($tagIds)) {
                $product->tags()->attach($tagIds);
            }
        }

        // Log the activity
        ActivityLog::createLog('create', $product);

        return redirect()->route('admin.products.index')->with('success', 'محصول با موفقیت ایجاد شد.');
    }

    /**
     * Handle product media uploads
     */
    private function handleProductMedia($product, $files, $type)
    {
        $sortOrder = 0;
        $isMain = false;

        foreach ($files as $file) {
            if ($file->isValid()) {
                $filePath = $file->store('products/' . $type . 's', 'public');

                // Set first image as main image
                if ($type === 'image' && !$isMain) {
                    $isMain = true;
                }

                ProductMedia::create([
                    'product_id' => $product->id,
                    'file_path' => $filePath,
                    'file_type' => $type,
                    'mime_type' => $file->getMimeType(),
                    'original_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                    'is_main' => $isMain,
                    'sort_order' => $sortOrder++
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['media', 'tags', 'brand']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $ageGroups = AgeGroup::all();
        $gameTypes = GameType::all();
        $categories = Category::all();
        $tags = Tag::active()->get();

        return view('admin.products.edit', compact('product', 'ageGroups', 'gameTypes', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        // Capture old values for logging
        $oldValues = $product->toArray();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        // Handle multiple images
        if ($request->hasFile('images')) {
            $this->handleProductMedia($product, $request->file('images'), 'image');
        }

        // Handle videos
        if ($request->hasFile('videos')) {
            $this->handleProductMedia($product, $request->file('videos'), 'video');
        }

        // Handle tags
        if ($request->filled('tags')) {
            $tagData = array_filter(explode(',', $request->tags));
            $tagIds = [];

            foreach ($tagData as $tagItem) {
                if (str_starts_with($tagItem, 'new:')) {
                    // Create new tag
                    $tagName = substr($tagItem, 4); // Remove 'new:' prefix
                    $tag = Tag::create([
                        'name' => $tagName,
                        'slug' => \Illuminate\Support\Str::slug($tagName),
                        'color' => '#6c757d', // Default color for new tags
                        'is_active' => true
                    ]);
                    $tagIds[] = $tag->id;
                } else {
                    // Existing tag
                    $tagIds[] = $tagItem;
                }
            }

            $product->tags()->sync($tagIds);
        } else {
            $product->tags()->detach();
        }

        // Log the activity
        ActivityLog::createLog('update', $product, $oldValues, $product->fresh()->toArray());

        return redirect()->route('admin.products.index')->with('success', 'محصول با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Log the activity before deletion
        ActivityLog::createLog('delete', $product);

        // Delete all media files
        foreach ($product->media as $media) {
            $media->deleteFile();
        }

        // Delete image
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'محصول با موفقیت حذف شد.');
    }

    /**
     * Delete a media item
     */
    public function deleteMedia(ProductMedia $media)
    {
        try {
            // Check if user is authenticated
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'دسترسی غیرمجاز'], 403);
            }

            // Delete the file from storage
            $media->deleteFile();

            // Delete the media record
            $media->delete();

            return response()->json(['success' => true, 'message' => 'رسانه با موفقیت حذف شد']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در حذف رسانه'], 500);
        }
    }

    /**
     * Set a media item as main image
     */
    public function setMainImage(ProductMedia $media)
    {
        try {
            // Check if user is authenticated
            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'دسترسی غیرمجاز'], 403);
            }

            // Check if media is an image
            if (!$media->isImage()) {
                return response()->json(['success' => false, 'message' => 'فقط تصاویر می‌توانند تصویر اصلی باشند'], 400);
            }

            // Remove main flag from all other images of this product
            ProductMedia::where('product_id', $media->product_id)
                       ->where('file_type', 'image')
                       ->update(['is_main' => false]);

            // Set this media as main
            $media->update(['is_main' => true]);

            return response()->json(['success' => true, 'message' => 'تصویر اصلی با موفقیت تنظیم شد']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'خطا در تنظیم تصویر اصلی'], 500);
        }
    }
}
