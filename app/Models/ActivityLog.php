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

    protected $casts = [
        'created_at' => 'datetime',
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

   // Get the activity type for icon mapping
    public function getTypeAttribute()
    {
        $action = strtolower($this->action);
        $description = strtolower($this->description);
        
        // Check password in BOTH action and description
        if (str_contains($action, 'password') || str_contains($description, 'password')) {
            return 'password_changed';
        } elseif (str_contains($action, 'status')) {
            return 'update_status';
        } elseif (str_contains($action, 'update') && (str_contains($action, 'ticket') || str_contains($action, 'print') || str_contains($action, 'repair'))) {
            return 'update_ticket';
        } elseif (str_contains($action, 'add') && str_contains($action, 'inventory') || str_contains($description, 'added')) {
            return 'add_inventory'; 
        } elseif (str_contains($action, 'issue') && str_contains($action, 'inventory') || str_contains($description, 'issued')) {
            return 'issue_inventory'; 
        } elseif (str_contains($action, 'return') && str_contains($action, 'inventory') || str_contains($description, 'returned')) {
            return 'return_inventory'; 
        } elseif (str_contains($action, 'edit') && str_contains($action, 'inventory') || str_contains($description, 'edited')) {
            return 'edit_inventory'; 
        } elseif (str_contains($action, 'delete') && str_contains($action, 'inventory') || str_contains($description, 'deleted')) {
            return 'delete_inventory'; 
        } elseif (str_contains($action, 'add') || str_contains($action, 'create')) {
            return 'create_ticket';
        } elseif (str_contains($action, 'update') && str_contains($action, 'user')) {
            return 'update_user';
        } elseif (str_contains($action, 'repair')) {
            return 'repair';
        } elseif (str_contains($action, 'delete')) {
            return 'delete_user';
        }
        
        return 'default';
    }

    // Extract status from description
    public function getStatusAttribute()
    {
        $description = $this->description;
        
        // Extract final status from "status changed from X to Y"
        if (preg_match('/status changed from .* to (.*)$/i', $description, $matches)) {
            return strtolower(trim($matches[1]));
        }
        
        return null;
    }

    public function getShortDescriptionAttribute()
    {
        $message = strip_tags($this->description);

        // Status change for Repair or Print
        if (preg_match('/(Repair|Print) Ticket (.*?) status changed from (.*?) to (.*)/', $message, $m)) {
            return "updated {$m[2]} status to {$m[4]}";
        }

        // Ticket creation for Repair or Print
        if (preg_match('/(Repair|Print) Ticket (.*?) was created/', $message, $m)) {
            return "created {$m[1]} Ticket {$m[2]}";
        }
        // Ticket updates (general) - ADD THIS
        if (preg_match('/(Repair|Print) Ticket (.*?) updated:?/', $message, $m)) {
            // Extract what was updated if possible
            if (preg_match('/updated:(.+)/', $message, $details)) {
                $updates = strip_tags($details[1]);
                // Get first change only for brevity
                $firstChange = explode('<br>', $updates)[0];
                $firstChange = explode('→', $firstChange)[0] ?? '';
                $field = trim(explode(':', $firstChange)[0] ?? '');
                
                if ($field) {
                    return "updated {$m[1]} Ticket {$m[2]} ({$field})";
                }
            }
            return "updated {$m[1]} Ticket {$m[2]}";
        }

        // Ticket updates
        if (preg_match('/(Repair|Print) Ticket (.*?) updated/', $message, $m)) {
            return "updated {$m[1]} Ticket {$m[2]}";
        }

        // Password change
        if (preg_match('/Password changed/', $message)) {
            return "changed their password";
        }

        // User deletion
        if (preg_match('/Deleted User (.*?) \((.*?)\)/', $message, $m)) {
            return "deleted user {$m[1]}";
        }

        return $message; // fallback
    }
}