<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InventoryItem;

class RepairTicket extends Model
{
    use HasFactory;

    protected $table = 'repair_tickets';

    protected $primaryKey = 'repairTicket_id';
    public $incrementing = false;   // string key
    protected $keyType = 'string';  // key type is string

    protected $fillable = [
        'process_id',
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

    // Relationship to InventoryItem
    public function inventory()
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_id', 'inventory_id');
    }

    // Relationship to Process (optional)
    public function process()
    {
        return $this->belongsTo(Process::class);
    }
}
