<?php

namespace App\Http\Controllers;

use App\Models\GameType;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gameTypes = GameType::all();
        return view('admin.game-types.index', compact('gameTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.game-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:game_types,title'
        ]);

        $gameType = GameType::create($request->only('title'));

        // Log the activity
        ActivityLog::createLog('create', $gameType);

        return redirect()->route('admin.game-types.index')->with('success', 'نوع بازی با موفقیت اضافه شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GameType $gameType)
    {
        return view('admin.game-types.show', compact('gameType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GameType $gameType)
    {
        return view('admin.game-types.edit', compact('gameType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GameType $gameType)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:game_types,title,' . $gameType->id
        ]);

        $oldValues = ['title' => $gameType->title];

        $gameType->update($request->only('title'));

        $newValues = ['title' => $gameType->title];

        // Log the activity
        ActivityLog::createLog('update', $gameType, $oldValues, $newValues);

        return redirect()->route('admin.game-types.index')->with('success', 'نوع بازی با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GameType $gameType)
    {
        // Log the activity before deletion
        ActivityLog::createLog('delete', $gameType);

        $gameType->delete();

        return redirect()->route('admin.game-types.index')->with('success', 'نوع بازی با موفقیت حذف شد.');
    }
}
