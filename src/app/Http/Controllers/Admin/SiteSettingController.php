<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    /**
     * Show the site settings form
     */
    public function edit(): View
    {
        $settings = SiteSetting::current();
        return view('admin.site-settings.edit', compact('settings'));
    }

    /**
     * Update the site settings
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:1000',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'contact_address' => 'nullable|string|max:500',
            'working_hours' => 'nullable|string|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_telegram' => 'nullable|url|max:255',
            'social_whatsapp' => 'nullable|url|max:255',
            'footer_text' => 'nullable|string|max:1000',
            'copyright_text' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:1000',
            'meta_description' => 'nullable|string|max:500'
        ]);

        $settings = SiteSetting::current();

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            // Delete old logo (only if it's a local file)
            if ($settings->site_logo && !str_starts_with($settings->site_logo, 'http') && Storage::disk('public')->exists($settings->site_logo)) {
                Storage::disk('public')->delete($settings->site_logo);
            }

            $logoPath = $request->file('site_logo')->store('site', 'public');
            $validated['site_logo'] = $logoPath;
        }

        $settings->update($validated);

        return redirect()->back()->with('success', 'تنظیمات سایت با موفقیت بروزرسانی شد.');
    }

    /**
     * Show current settings (for preview)
     */
    public function show(): View
    {
        $settings = SiteSetting::current();
        return view('admin.site-settings.show', compact('settings'));
    }
}
