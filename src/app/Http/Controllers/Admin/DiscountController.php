<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Category;
use App\Models\AgeGroup;
use App\Models\GameType;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Discount::with('product');

        // فیلتر بر اساس نوع تخفیف
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // فیلتر بر اساس وضعیت
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->active();
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'expired':
                    $query->where('end_date', '<', now());
                    break;
                case 'upcoming':
                    $query->where('start_date', '>', now());
                    break;
            }
        }

        // مرتب‌سازی
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $discounts = $query->paginate(15);

        return view('admin.discounts.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $categories = Category::all();
        $ageGroups = AgeGroup::all();
        $gameTypes = GameType::all();

        return view('admin.discounts.create', compact('products', 'categories', 'ageGroups', 'gameTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'type' => 'required|in:product,campaign',
            'discount_type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'minimum_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ];

        // اعتبارسنجی بر اساس نوع تخفیف
        if ($request->type === 'product') {
            $rules['product_id'] = 'required|exists:products,id';
        } else {
            $rules['target_type'] = 'required|in:category,age_group,game_type';
            $rules['target_value'] = 'required|string';
        }

        // اعتبارسنجی مقدار تخفیف
        if ($request->discount_type === 'percentage') {
            $rules['value'] = 'required|numeric|min:0|max:100';
        }

        $request->validate($rules);

        $data = $request->only([
            'title', 'type', 'discount_type', 'value', 'start_date', 'end_date',
            'is_active', 'minimum_amount', 'maximum_discount', 'description'
        ]);

        if ($request->type === 'product') {
            $data['product_id'] = $request->product_id;
        } else {
            $data['target_type'] = $request->target_type;
            $data['target_value'] = $request->target_value;
        }

        $data['is_active'] = $request->boolean('is_active', true);

        $discount = Discount::create($data);

        ActivityLog::createLog('create', $discount, [], $discount->toArray());

        return redirect()->route('admin.discounts.index')
                        ->with('success', 'تخفیف با موفقیت ایجاد شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount)
    {
        $discount->load('product');

        // گرفتن محصولات قابل اعمال برای کمپین
        $applicableProducts = collect();
        if ($discount->type === 'campaign') {
            $query = Product::query();

            switch ($discount->target_type) {
                case 'category':
                    $query->where('category', $discount->target_value);
                    break;
                case 'game_type':
                    $query->where('game_type', $discount->target_value);
                    break;
                case 'age_group':
                    $query->whereJsonContains('age_group', $discount->target_value);
                    break;
            }

            $applicableProducts = $query->get();
        }

        return view('admin.discounts.show', compact('discount', 'applicableProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        $products = Product::all();
        $categories = Category::all();
        $ageGroups = AgeGroup::all();
        $gameTypes = GameType::all();

        return view('admin.discounts.edit', compact('discount', 'products', 'categories', 'ageGroups', 'gameTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $discount)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'type' => 'required|in:product,campaign',
            'discount_type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'minimum_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ];

        if ($request->type === 'product') {
            $rules['product_id'] = 'required|exists:products,id';
        } else {
            $rules['target_type'] = 'required|in:category,age_group,game_type';
            $rules['target_value'] = 'required|string';
        }

        if ($request->discount_type === 'percentage') {
            $rules['value'] = 'required|numeric|min:0|max:100';
        }

        $request->validate($rules);

        $oldValues = $discount->toArray();

        $data = $request->only([
            'title', 'type', 'discount_type', 'value', 'start_date', 'end_date',
            'is_active', 'minimum_amount', 'maximum_discount', 'description'
        ]);

        if ($request->type === 'product') {
            $data['product_id'] = $request->product_id;
            $data['target_type'] = null;
            $data['target_value'] = null;
        } else {
            $data['target_type'] = $request->target_type;
            $data['target_value'] = $request->target_value;
            $data['product_id'] = null;
        }

        $data['is_active'] = $request->boolean('is_active', true);

        $discount->update($data);

        ActivityLog::createLog('update', $discount, $oldValues, $discount->toArray());

        return redirect()->route('admin.discounts.index')
                        ->with('success', 'تخفیف با موفقیت بروزرسانی شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        $oldValues = $discount->toArray();

        $discount->delete();

        ActivityLog::createLog('delete', $discount, $oldValues, []);

        return redirect()->route('admin.discounts.index')
                        ->with('success', 'تخفیف با موفقیت حذف شد.');
    }

    /**
     * Toggle discount status
     */
    public function toggleStatus(Discount $discount)
    {
        $oldValues = $discount->toArray();

        $discount->update(['is_active' => !$discount->is_active]);

        ActivityLog::createLog('update', $discount, $oldValues, $discount->toArray());

        $status = $discount->is_active ? 'فعال' : 'غیرفعال';

        return redirect()->back()
                        ->with('success', "تخفیف با موفقیت {$status} شد.");
    }

    /**
     * Get target options based on target type for AJAX
     */
    public function getTargetOptions(Request $request)
    {
        $targetType = $request->get('target_type');
        $options = [];

        switch ($targetType) {
            case 'category':
                $options = Category::pluck('title', 'title')->toArray();
                break;
            case 'age_group':
                $options = AgeGroup::pluck('title', 'title')->toArray();
                break;
            case 'game_type':
                $options = GameType::pluck('title', 'title')->toArray();
                break;
        }

        return response()->json($options);
    }
}
