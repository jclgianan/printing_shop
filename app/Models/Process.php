<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $fillable = [
        'process_id',
        'receiving_date',
        'category',
        'type',
        // Add other columns here if needed
    ];
}
