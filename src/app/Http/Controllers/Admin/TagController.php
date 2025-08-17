<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * نمایش لیست تگ‌ها
     */
    public function index()
    {
        $tags = Tag::orderBy('name')->paginate(20);
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * نمایش فرم ایجاد تگ جدید
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * ذخیره تگ جدید
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags',
            'color' => 'nullable|string|max:7',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'color' => $request->color ?: '#95a5a6',
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.tags.index')
            ->with('success', 'تگ با موفقیت ایجاد شد.');
    }

    /**
     * نمایش جزئیات تگ
     */
    public function show(Tag $tag)
    {
        $tag->load('products');
        return view('admin.tags.show', compact('tag'));
    }

    /**
     * نمایش فرم ویرایش تگ
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * بروزرسانی تگ
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'color' => 'nullable|string|max:7',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'color' => $request->color ?: '#95a5a6',
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.tags.index')
            ->with('success', 'تگ با موفقیت بروزرسانی شد.');
    }

    /**
     * حذف تگ
     */
    public function destroy(Tag $tag)
    {
        // بررسی اینکه آیا تگ در محصولی استفاده شده یا نه
        if ($tag->products()->count() > 0) {
            return redirect()->route('admin.tags.index')
                ->with('error', 'این تگ در محصولات استفاده شده و قابل حذف نیست.');
        }

        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'تگ با موفقیت حذف شد.');
    }

    /**
     * تغییر وضعیت فعال/غیرفعال تگ
     */
    public function toggleStatus(Tag $tag)
    {
        $tag->update(['is_active' => !$tag->is_active]);

        $status = $tag->is_active ? 'فعال' : 'غیرفعال';
        return redirect()->route('admin.tags.index')
            ->with('success', "وضعیت تگ به {$status} تغییر یافت.");
    }
}
