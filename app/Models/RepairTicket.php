<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairTicket extends Model
{
    use HasFactory;

    protected $table = 'repair_tickets';

    protected $fillable = [
        'process_id',
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
        'release_date' => 'date',
    ];

    public function getFormattedStatusAttribute()
    {
        return match($this->status) {
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'repaired' => 'Repaired',
            'unrepairable' => 'Unrepairable',
            default => ucfirst($this->status),
        };
    }

    public function process()
    {
        return $this->belongsTo(Process::class);
    }
}
