<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ActivityLog;

class InventoryController extends Controller
{
    /**
     * Display a listing of devices grouped by device_name
     */
    public function inventory(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $query = InventoryItem::query()
            ->orderBy('inventory_id', 'desc');


        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('inventory_id', 'like', "%{$search}%")
                    ->orWhere('device_name', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($category) {
            $query->where('category', $category);
        }

        $cacheKey = 'inventory-' . md5(json_encode($request->all()));

        $inventoryItems = cache()->remember($cacheKey, 15, function () use ($query) {
            return $query->paginate(10);
        });

        return view('inventory', compact('inventoryItems'));
    }


    /**
     * Show the form for creating a new inventory item
     */
    public function create()
    {
        return view('addInventory');
    }

    public function generateInventoryId(Request $request)
    {
        $request->validate([
            'category' => 'required|string'
        ]);

        // Category → prefix mapping
        $prefixMap = [
            'Computer System' => 'CS',
            'Components' => 'CMP',
            'Peripherals' => 'PER',
            'Networking' => 'NET',
            'Cables & Adapters' => 'CAB',
            'Others' => 'OTH',
        ];

        $category = $request->category;
        $prefix = $prefixMap[$category] ?? 'OTH';

        // Current date (YYYYMMDD)
        $date = now()->format('Ymd');

        // Find last inventory_id for SAME category & SAME date
        $lastItem = InventoryItem::where('inventory_id', 'like', "{$prefix}-{$date}-%")
            ->orderBy('inventory_id', 'desc')
            ->first();

        // Extract last 4-digit sequence
        if ($lastItem) {
            $lastNumber = intval(substr($lastItem->inventory_id, -4));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $inventoryId = sprintf(
            '%s-%s-%04d',
            $prefix,
            $date,
            $nextNumber
        );

        return response()->json([
            'inventory_id' => $inventoryId
        ]);
    }


    /**
     * Store a newly created inventory item
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventory_id' => 'required|string',
            'device_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1|max:500',
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


        // Extract prefix & date ONLY
        [$prefix, $date] = array_slice(explode('-', $validated['inventory_id']), 0, 2);

        DB::transaction(function () use ($validated, $prefix, $date) {

            // Get LAST USED number safely
            $lastItem = InventoryItem::where('inventory_id', 'like', "{$prefix}-{$date}-%")
                ->lockForUpdate()
                ->orderBy('inventory_id', 'desc')
                ->first();

            $startNumber = $lastItem
                ? intval(substr($lastItem->inventory_id, -4)) + 1
                : 1;

            for ($i = 0; $i < $validated['quantity']; $i++) {

                $inventoryId = sprintf(
                    '%s-%s-%04d',
                    $prefix,
                    $date,
                    $startNumber + $i
                );

                InventoryItem::create([
                    'inventory_id' => $inventoryId,
                    'device_name' => $validated['device_name'],
                    'category' => $validated['category'],
                    'processor' => $validated['processor'],
                    'ram' => $validated['ram'],
                    'storage' => $validated['storage'],
                    'graphics_card' => $validated['graphics_card'],
                    'other_specs' => $validated['other_specs'],
                    'status' => $validated['status'],
                    'condition' => $validated['condition'],
                    'issued_to' => $validated['issued_to'],
                    'office' => $validated['office'],
                    'date_acquired' => $validated['date_acquired'],
                    'date_issued' => $validated['date_issued'],
                    'notes' => $validated['notes'],
                ]);
            }
        });
        $quantity = $validated['quantity'];
        $baseInventoryId = sprintf(
            '%s-%s-%04d',
            $prefix,
            $date,
            intval(substr($validated['inventory_id'], -4))  // Starting number
        );

        try {
            ActivityLog::record(
                'Add Inventory Item',
                "$quantity inventory items added starting from $baseInventoryId"
            );
        } catch (\Exception $e) {
            Log::error('Failed to log Inventory Item Activity: ' . $e->getMessage());
        }

        $message = $quantity > 1
            ? "$quantity devices added successfully."
            : "Device added successfully.";

        return redirect()->route('inventory')
            ->with('success', $message);
    }

    /**
     * Display all units of a specific device name
     */
    // public function view($deviceId)
    // {
    //     $items = InventoryItem::where('device_id', $deviceId)
    //         ->orderBy('individual_id')
    //         ->paginate(10);

    //     if ($items->isEmpty()) {
    //         abort(404);
    //     }

    //     $category = $items->first()->category;

    //     // Get all existing individual numbers for this device (to fill gaps)
    //     $allIds = InventoryItem::where('device_id', $deviceId)
    //         ->pluck('individual_id')
    //         ->map(function ($id) {
    //             preg_match('/\((\d+)\)$/', $id, $matches);
    //             return isset($matches[1]) ? (int) $matches[1] : 0;
    //         })
    //         ->sort()
    //         ->values()
    //         ->all();

    //     return view('viewInventory', compact('items', 'deviceId', 'category', 'allIds'));
    // }

    /**
     * Show the form for editing a specific inventory item
     */
    public function edit($id)
    {
        $item = InventoryItem::findOrFail($id);

        return view('inventory.edit', compact('item'));
    }

    /**
     * Update the specified inventory item
     */
    public function update(Request $request, $id)
    {
        $item = InventoryItem::findOrFail($id);

        $validated = $request->validate([
            'serial_number' => 'nullable|string',
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
            'warranty_expiration' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        // Clear assignment fields if status is not 'issued'
        if ($validated['status'] !== 'issued') {
            $validated['issued_to'] = null;
            $validated['office'] = null;
            $validated['date_issued'] = null;
        }

        // Always poor condition if status is unusable
        if ($request->status === 'unusable') {
            $request->merge(['condition' => 'poor']);
        }

        $item->update($validated);

        try {
            ActivityLog::record(
                'Edit Inventory Item',
                "Inventory Item {$item->individual_id} was edited"
            );
        } catch (\Exception $e) {
            Log::error('Failed to log Inventory Item Activity: ' . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', "Unit {$item->individual_id} successfully updated.");
    }

    /**
     * Delete all items with a specific inventory id
     */
    public function destroyDevice($inventoryId)
    {

        InventoryItem::where('inventory_id', $inventoryId)->delete();

        try {
            ActivityLog::record(
                'Delete Inventory Item',
                "Inventory Item {$inventoryId} was deleted"
            );
        } catch (\Exception $e) {
            Log::error('Failed to log Inventory Item Activity: ' . $e->getMessage());
        }

        return redirect()->route('inventory')
            ->with('success', "Device Item {$inventoryId} has been deleted successfully.");
    }

    /**
     * Add new units to an existing device
     */
    public function addUnits(Request $request, $deviceId)
    {
        $validated = $request->validate([
            'device_id' => 'required|string',
            'quantity' => 'required|integer|min:1|max:50',
            'status' => 'required|in:available,issued,unusable',
            'condition' => 'required|in:new,good,fair,poor',
            'issued_to' => 'nullable|string',
            'office' => 'nullable|string',
            'date_acquired' => 'nullable|date',
            'date_issued' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        // Always poor condition if status is unusable
        if ($request->status === 'unusable') {
            $request->merge(['condition' => 'poor']);
        }

        // Get the existing device info
        $existingDevice = InventoryItem::where('device_id', $deviceId)->firstOrFail();

        // Get all existing individual numbers
        $existingNumbers = InventoryItem::where('device_id', $deviceId)
            ->pluck('individual_id')
            ->map(function ($id) {
                preg_match('/\((\d+)\)/', $id, $matches);
                return isset($matches[1]) ? intval($matches[1]) : 0;
            })
            ->sort()
            ->values()
            ->toArray();

        $quantity = $validated['quantity'];
        $newIds = [];

        $current = 1; // Start from 1
        $added = 0;

        while ($added < $quantity) {
            if (!in_array($current, $existingNumbers)) {
                $individualId = $deviceId . '(' . str_pad($current, 2, '0', STR_PAD_LEFT) . ')';
                $item = InventoryItem::create([
                    'device_id' => $deviceId,
                    'individual_id' => $individualId,
                    'device_name' => $existingDevice->device_name,
                    'category' => $existingDevice->category,
                    'processor' => $existingDevice->processor,
                    'ram' => $existingDevice->ram,
                    'storage' => $existingDevice->storage,
                    'graphics_card' => $existingDevice->graphics_card,
                    'other_specs' => $existingDevice->other_specs,
                    'status' => $validated['status'],
                    'condition' => $validated['condition'],
                    'issued_to' => $validated['issued_to'],
                    'office' => $validated['office'],
                    'date_acquired' => $validated['date_acquired'],
                    'date_issued' => $validated['date_issued'],
                    'notes' => $validated['notes'],
                ]);

                $added++;
            }
            $current++;

            try {
                ActivityLog::record(
                    'Add Inventory Item',
                    "Inventory Unit {$item->individual_id} was added"
                );
            } catch (\Exception $e) {
                Log::error('Failed to log Inventory Item Activity: ' . $e->getMessage());
            }
        }

        $message = $quantity > 1
            ? "$quantity units added successfully."
            : "1 unit added successfully.";

        return redirect()->route('inventory.view', $deviceId)
            ->with('success', $message);
    }


    public function issue(Request $request, $id)
    {
        $item = InventoryItem::findOrFail($id);

        $request->validate([
            'issued_to' => 'required|string',
            'office' => 'required|string',
            'date_issued' => 'required|date',
        ]);

        $item->update([
            'status' => 'issued',
            'issued_to' => $request->issued_to,
            'office' => $request->office,
            'date_issued' => $request->date_issued,
        ]);

        try {
            ActivityLog::record(
                'Issue Inventory Item',
                "Inventory Item {$item->individual_id} was issued to {$item->issued_to}"
            );
        } catch (\Exception $e) {
            Log::error('Failed to log Inventory Item Activity: ' . $e->getMessage());
        }

        return back()->with('success', 'Device issued successfully.');
    }

    public function return(Request $request, $id)
    {
        $item = InventoryItem::findOrFail($id);

        $request->validate([
            'condition' => 'required|in:new,good,fair,poor',
            'date_returned' => 'required|date',
        ]);

        $item->update([
            'status' => 'available',
            'condition' => $request->condition,
            'date_returned' => $request->date_returned,

            // Clear assignment fields
            'issued_to' => null,
            'office' => null,
            'date_issued' => null,
        ]);

        try {
            ActivityLog::record(
                'Return Inventory Item',
                "Inventory Item {$item->individual_id} was returned"
            );
        } catch (\Exception $e) {
            Log::error('Failed to log Inventory Item Activity: ' . $e->getMessage());
        }

        return back()->with('success', 'Device returned successfully.');
    }
}
