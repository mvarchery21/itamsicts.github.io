<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetAssignment;
use App\Models\User;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::withCount('assignments')
            ->with('currentAssignment.user')
            ->latest()
            ->paginate(15);

        return view('admin.assets.index', compact('assets'));
    }

    public function create()
    {
        return view('admin.assets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'asset_tag' => 'required|string|unique:assets,asset_tag|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'serial_number' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'status' => 'required|in:available,assigned,maintenance,retired',
        ]);

        Asset::create($validated);

        return redirect()->route('admin.assets.index')
            ->with('success', 'Asset created successfully.');
    }

    public function show(Asset $asset)
    {
        $asset->load(['assignments.user']);
        return view('admin.assets.show', compact('asset'));
    }

    public function edit(Asset $asset)
    {
        return view('admin.assets.edit', compact('asset'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'asset_tag' => 'required|string|max:255|unique:assets,asset_tag,' . $asset->id,
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'serial_number' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'status' => 'required|in:available,assigned,maintenance,retired',
        ]);

        $asset->update($validated);

        return redirect()->route('admin.assets.index')
            ->with('success', 'Asset updated successfully.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        return redirect()->route('admin.assets.index')
            ->with('success', 'Asset deleted successfully.');
    }

    public function assign(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'assigned_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        AssetAssignment::create([
            'asset_id' => $asset->id,
            'user_id' => $validated['user_id'],
            'assigned_date' => $validated['assigned_date'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'active',
        ]);

        $asset->update(['status' => 'assigned']);

        return redirect()->route('admin.assets.show', $asset)
            ->with('success', 'Asset assigned successfully.');
    }

    public function returnAsset(AssetAssignment $assignment)
    {
        $assignment->update([
            'return_date' => now(),
            'status' => 'returned',
        ]);

        $assignment->asset->update(['status' => 'available']);

        return redirect()->back()
            ->with('success', 'Asset returned successfully.');
    }
}
