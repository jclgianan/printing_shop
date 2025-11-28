<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_name',
        'user_email',
        'action',
        'description',
    ];

    public static function record($action, $description = null)
    {
        $user = auth()->user();

        self::create([
            'user_name'  => $user ? $user->name : 'Guest',
            'user_email' => $user ? $user->email : 'N/A',
            'action'     => $action,
            'description'=> $description,
        ]);
    }
}
