<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RepairTicket;


class InventoryItem extends Model
{
    use HasFactory;

    protected $table = 'inventory_items';

    protected $primaryKey = 'inventory_id'; // already exists
    public $incrementing = false;           // <--- tell Eloquent it's not auto-increment
    protected $keyType = 'string';          // <--- tell Eloquent it's a string


    protected $fillable = [
        'inventory_id',
        'device_name',
        'category',
        'serial_number',
        'processor',
        'quantity',
        'ram',
        'storage',
        'graphics_card',
        'other_specs',
        'status',
        'condition',
        'issued_to',
        'office',
        'date_acquired',
        'date_issued',
        'date_returned',
        'notes',
    ];

    protected $casts = [
        'date_acquired' => 'date',
        'date_issued' => 'date',
        'date_returned' => 'date',
    ];

    /**
     * Check if item is available
     */
    public function isAvailable()
    {
        return $this->status === 'available';
    }

    /**
     * Check if item is issued
     */
    public function isIssued()
    {
        return $this->status === 'issued';
    }

    /**
     * Scope for filtering by status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for filtering by condition
     */
    public function scopeCondition($query, $condition)
    {
        return $query->where('condition', $condition);
    }

    /**
     * Scope for filtering by category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get all unique device names grouped with counts
     */
    public static function getDeviceSummary()
    {
        return self::selectRaw('
                inventory_id,
                device_name,
                category,
                COUNT(*) as total_units,
                SUM(CASE WHEN status = "available" THEN 1 ELSE 0 END) as available,
                SUM(CASE WHEN status = "issued" THEN 1 ELSE 0 END) as issued,
                SUM(CASE WHEN status = "unusable" THEN 1 ELSE 0 END) as unusable
            ')
            ->groupBy('inventory_id', 'device_name', 'category')
            ->get();
    }

    /**
     * Scope for filtering by inventory_id
     */
    public function scopeInventoryId($query, $inventoryId)
    {
        return $query->where('inventory_id', $inventoryId);
    }

    // FOR Relationship of Repair Tickets and Inventorty Items
    // One inventory item can have many repair tickets
    public function repairTickets()
    {
        return $this->hasMany(RepairTicket::class, 'inventory_id', 'inventory_id');
    }

    // Use inventory_id for route model binding
    public function getRouteKeyName()
    {
        return 'inventory_id';
    }
}
