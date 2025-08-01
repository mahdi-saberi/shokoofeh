<?php

namespace App\Http\Controllers;

use App\Models\AgeGroup;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgeGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ageGroups = AgeGroup::all();
        return view('admin.age-groups.index', compact('ageGroups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.age-groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:age_groups,title'
        ]);

        $ageGroup = AgeGroup::create($request->only('title'));

        // Log the activity
        ActivityLog::createLog('create', $ageGroup);

        return redirect()->route('admin.age-groups.index')->with('success', 'گروه سنی با موفقیت اضافه شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AgeGroup $ageGroup)
    {
        return view('admin.age-groups.show', compact('ageGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AgeGroup $ageGroup)
    {
        return view('admin.age-groups.edit', compact('ageGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AgeGroup $ageGroup)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:age_groups,title,' . $ageGroup->id
        ]);

        $oldValues = ['title' => $ageGroup->title];

        $ageGroup->update($request->only('title'));

        $newValues = ['title' => $ageGroup->title];

        // Log the activity
        ActivityLog::createLog('update', $ageGroup, $oldValues, $newValues);

        return redirect()->route('admin.age-groups.index')->with('success', 'گروه سنی با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AgeGroup $ageGroup)
    {
        // Log the activity before deletion
        ActivityLog::createLog('delete', $ageGroup);

        $ageGroup->delete();

        return redirect()->route('admin.age-groups.index')->with('success', 'گروه سنی با موفقیت حذف شد.');
    }
}
