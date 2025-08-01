<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $query = Slider::query();

        // Search functionality
        if ($search = request('search')) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if (request('status') !== null && request('status') !== '') {
            $query->where('is_active', (bool) request('status'));
        }

        $sliders = $query->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sliders', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['is_active'] = (bool) $request->get('is_active', 0);
        $validated['order'] = $validated['order'] ?? 0;

        Slider::create($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'اسلایدر با موفقیت ایجاد شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider): View
    {
        return view('admin.sliders.show', compact('slider'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider): View
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0'
        ]);

                        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image (only if it's a local file, not an external URL)
            if ($slider->image && !str_starts_with($slider->image, 'http') && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }

            $imagePath = $request->file('image')->store('sliders', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['is_active'] = (bool) $request->get('is_active', 0);
        $validated['order'] = $validated['order'] ?? 0;

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'اسلایدر با موفقیت بروزرسانی شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider): RedirectResponse
    {
        // Delete image file (only if it's a local file, not an external URL)
        if ($slider->image && !str_starts_with($slider->image, 'http') && Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'اسلایدر با موفقیت حذف شد.');
    }

    /**
     * Toggle slider status
     */
    public function toggleStatus(Slider $slider): RedirectResponse
    {
        $slider->update(['is_active' => !$slider->is_active]);

        $status = $slider->is_active ? 'فعال' : 'غیرفعال';
        return redirect()->back()
            ->with('success', "وضعیت اسلایدر به $status تغییر یافت.");
    }
}
