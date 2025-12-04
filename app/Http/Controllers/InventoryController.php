<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Display a listing of devices grouped by device_name
     */
    public function inventory(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        // Get grouped summary of devices
        $query = InventoryItem::selectRaw('
                device_id,
                device_name,
                category,
                COUNT(*) as total_units,
                SUM(CASE WHEN status = "available" THEN 1 ELSE 0 END) as available,
                SUM(CASE WHEN status = "issued" THEN 1 ELSE 0 END) as issued,
                SUM(CASE WHEN status = "unusable" THEN 1 ELSE 0 END) as unusable
            ')
            ->groupBy('device_id', 'device_name', 'category');

        if ($search) {
            $query->where('device_id', 'device_name', 'like', "%{$search}%");
        }

        if ($category) {
            $query->where('category', $category);
        }

        $devices = $query->paginate(10);

        return view('inventory', compact('devices'));
    }

    /**
     * Show the form for creating a new inventory item
     */
    public function create()
    {
        return view('addInventory');
    }

    // Inventory search page fucntion
    public function inventorySearch(Request $request)
    {
        $query = $request->input('query');

        // Aggregate devices by device_id and device_name
        $devices = InventoryItem::select(
                    'device_id',
                    'device_name',
                    DB::raw('COUNT(*) as total_units'),
                    DB::raw("SUM(CASE WHEN status = 'available' THEN 1 ELSE 0 END) as available"),
                    DB::raw("SUM(CASE WHEN status = 'issued' THEN 1 ELSE 0 END) as issued"),
                    DB::raw("SUM(CASE WHEN status = 'damaged' OR status = 'unusable' THEN 1 ELSE 0 END) as unusable")
                )
                ->where('device_id', 'LIKE', "%{$query}%")
                ->orWhere('device_name', 'LIKE', "%{$query}%")
                ->groupBy('device_id', 'device_name')
                ->get();

        return view('inventory', compact('devices'));
    }


    /**
     * Store a newly created inventory item
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|string',
            'individual_id' => 'required|string|unique:inventory_items,individual_id',
            'device_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'processor' => 'nullable|string',
            'ram' => 'nullable|string',
            'storage' => 'nullable|string',
            'graphics_card' => 'nullable|string',
            'other_specs' => 'nullable|string',
            'status' => 'required|in:available,issued,unusable',
            'condition' => 'required|in:new,good,fair,poor',
            'issued_to' => 'nullable|string',
            'office' => 'nullable|string',
            'date_acquired' => 'nullable|date',
            'date_issued' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        InventoryItem::create($validated);

        return redirect()->route('inventory')
            ->with('success', 'Inventory item added successfully.');
    }

    /**
     * Display all units of a specific device name
     */
    public function view($deviceId)
    {
        $items = InventoryItem::where('device_id', $deviceId)
            ->orderBy('individual_id')
            ->get();

        if ($items->isEmpty()) {
            abort(404);
        }

        $category = $items->first()->category;

        return view('viewInventory', compact('items', 'deviceId', 'category'));
    }

    /**
     * Show the form for editing a specific inventory item
     */
    public function edit($id)
    {
        $item = InventoryItem::findOrFail($id);
        
        return view('inventory.edit', compact('item'));
    }

    /**
     * Update a specific inventory item
     */
    public function update(Request $request, $id)
    {
        $item = InventoryItem::findOrFail($id);

        $validated = $request->validate([
            'device_id' => 'required|string',
            'individual_id' => 'required|string|unique:inventory_items,device_id,' . $id,
            'device_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'processor' => 'nullable|string',
            'ram' => 'nullable|string',
            'storage' => 'nullable|string',
            'graphics_card' => 'nullable|string',
            'other_specs' => 'nullable|string',
            'status' => 'required|in:available,issued,unusable',
            'condition' => 'required|in:new,good,fair,poor',
            'issued_to' => 'nullable|string',
            'office' => 'nullable|string',
            'date_acquired' => 'nullable|date',
            'date_issued' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $item->update($validated);

        return redirect()->route('inventory.view', $item->device_id)
            ->with('success', 'Inventory item updated successfully.');
    }

    /**
     * Remove a specific inventory item
     */
    public function destroy($id)
    {
        $item = InventoryItem::findOrFail($id);
        $deviceId = $item->device_id;
        
        // Check if this is the last item with this device name
        $remainingCount = InventoryItem::where('device_id', $deviceId)->count();
        
        $item->delete();

        // If no more items with this device name, redirect to index
        if ($remainingCount <= 1) {
            return redirect()->route('inventory')
                ->with('success', 'Inventory item deleted successfully.');
        }

        // Otherwise, stay on the device view page
        return redirect()->route('inventory.view', $deviceId)
            ->with('success', 'Inventory item deleted successfully.');
    }

    /**
     * Delete all items with a specific device id
     */
    public function destroyDevice($deviceId)
    {
        InventoryItem::where('device_id', $deviceId)->delete();

        return redirect()->route('inventory')
            ->with('success', 'All items for this device have been deleted.');
    }
}