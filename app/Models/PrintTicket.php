<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintTicket extends Model
{
    use HasFactory;

    protected $table = 'print_tickets';

    protected $fillable = [
        'process_id',
        'printTicket_id',
        'receiving_date',
        'name',
        'office_department',
        'itemname',
        'size',
        'quantity',
        'release_date',
        'status',
        'file_link',
        'deadline',
    ];

    protected $casts = [
        'receiving_date' => 'date',
        'release_date' => 'datetime',
        'quantity' => 'integer',
    ];

    /**
     * Get the formatted status for display.
     * 
     * @return string
     */
    public function getFormattedStatusAttribute()
    {
        return match($this->status) {
            'in_progress' => 'Ongoing',
            'pending' => 'Pending',
            'printed' => 'Printed',
            'released'      => 'Released', 
            'cancelled' => 'Cancelled',
            default => ucfirst($this->status),
        };
    }

    public function process()
    {
        return $this->belongsTo(Process::class);
    }
}
