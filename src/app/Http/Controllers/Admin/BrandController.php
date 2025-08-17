<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::withCount(['products', 'activeProducts'])->orderBy('created_at', 'desc')->get();
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:brands,title',
            'description' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'website' => 'nullable|url|max:255',
            'status' => 'boolean'
        ]);

        $data = $request->only(['title', 'description', 'website', 'status']);
        $data['status'] = $request->has('status');

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('brands', 'public');
            $data['logo'] = $logoPath;
        }

        $brand = Brand::create($data);

        // Log the activity
        ActivityLog::createLog('create', $brand);

        return redirect()->route('admin.brands.index')->with('success', 'برند با موفقیت اضافه شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        $brand->load('products');
        return view('admin.brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:brands,title,' . $brand->id,
            'description' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'website' => 'nullable|url|max:255',
            'status' => 'boolean'
        ]);

        $oldValues = $brand->toArray();

        $data = $request->only(['title', 'description', 'website', 'status']);
        $data['status'] = $request->has('status');

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
                Storage::disk('public')->delete($brand->logo);
            }

            $logoPath = $request->file('logo')->store('brands', 'public');
            $data['logo'] = $logoPath;
        }

        $brand->update($data);

        $newValues = $brand->fresh()->toArray();

        // Log the activity
        ActivityLog::createLog('update', $brand, $oldValues, $newValues);

        return redirect()->route('admin.brands.index')->with('success', 'برند با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        // Check if brand has products
        if ($brand->products()->count() > 0) {
            return redirect()->route('admin.brands.index')->with('error', 'این برند دارای محصول است و قابل حذف نیستlegitimate.');
        }

        // Delete logo if exists
        if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
            Storage::disk('public')->delete($brand->logo);
        }

        // Log the activity before deletion
        ActivityLog::createLog('delete', $brand);

        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'برند با موفقیت حذف شد.');
    }

    /**
     * Toggle brand status
     */
    public function toggleStatus(Brand $brand)
    {
        $brand->update(['status' => !$brand->status]);

        $status = $brand->status ? 'فعال' : 'غیرفعال';
        return redirect()->route('admin.brands.index')->with('success', "وضعیت برند به {$status} تغییر یافت.");
    }
}
