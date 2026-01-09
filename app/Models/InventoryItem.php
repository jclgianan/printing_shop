<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

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
                device_id,
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
}
