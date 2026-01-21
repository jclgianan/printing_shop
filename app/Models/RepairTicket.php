<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InventoryItem;

class RepairTicket extends Model
{
    use HasFactory;

    protected $table = 'repair_tickets';

    // Primary key is string
    protected $primaryKey = 'repairTicket_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'process_id',
        'inventory_item_id',
        'inventory_id',
        'repairTicket_id',
        'receiving_date',
        'name',
        'office_department',
        'itemname',
        'issue',
        'solution',
        'note',
        'status',
        'release_date',
    ];

    protected $casts = [
        'receiving_date' => 'date',
        'release_date' => 'datetime',
    ];

    public function getFormattedStatusAttribute()
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'in_progress' => 'Ongoing',
            'repaired' => 'Repaired',
            'released' => 'Released',
            'unrepairable' => 'Unrepairable',
            default => ucfirst($this->status),
        };
    }

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id', 'id');
    }

    // Relationship to Process (optional)
    public function process()
    {
        return $this->belongsTo(Process::class);
    }
}
