<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Process;
use App\Models\ActivityLog;
use App\Models\PrintTicket;
use App\Models\InventoryItem;
use App\Events\ActivityUpdated;
use App\Models\RepairTicket;
use Illuminate\Support\Facades\Log;
use PHPUnit\TextUI\XmlConfiguration\Group;

use function PHPSTORM_META\type;

class AuthController extends Controller
{
    // Show main page after login
    public function index()
    {
        // RECENT ACTIVITIES
        $recentActivities = ActivityLog::latest()->take(5)->get();

        // PRINTING COUNTS
        $pending = PrintTicket::where('status', 'pending')->count();
        $in_progress = PrintTicket::where('status', 'in_progress')->count();
        $printed = PrintTicket::where('status', 'printed')->count();
        $released = PrintTicket::where('status', 'released')->count();
        $cancelled = PrintTicket::where('status', 'cancelled')->count();

        // REPAIR COUNTS
        $repair_pending = RepairTicket::where('status', 'pending')->count();
        $repair_in_progress = RepairTicket::where('status', 'in_progress')->count();
        $repair_repaired = RepairTicket::where('status', 'repaired')->count();
        $repair_released = RepairTicket::where('status', 'released')->count();
        $repair_unrepairable = RepairTicket::where('status', 'unrepairable')->count();

        return view('main', compact(
            'recentActivities',
            'pending',
            'in_progress',
            'printed',
            'released',
            'cancelled',
            'repair_pending',
            'repair_in_progress',
            'repair_repaired',
            'repair_released',
            'repair_unrepairable'
        ));
    }

    // API endpoint for dashboard stats
    public function getDashboardStats()
    {
        return response()->json([
            'printing' => [
                'pending' => PrintTicket::where('status', 'pending')->count(),
                'in_progress' => PrintTicket::where('status', 'in_progress')->count(),
                'printed' => PrintTicket::where('status', 'printed')->count(),
                'released' => PrintTicket::where('status', 'released')->count(),
                'cancelled' => PrintTicket::where('status', 'cancelled')->count(),
            ],
            'repair' => [
                'pending' => RepairTicket::where('status', 'pending')->count(),
                'in_progress' => RepairTicket::where('status', 'in_progress')->count(),
                'repaired' => RepairTicket::where('status', 'repaired')->count(),
                'released' => RepairTicket::where('status', 'released')->count(),
                'unrepairable' => RepairTicket::where('status', 'unrepairable')->count(),
            ]
        ]);
    }

    // API endpoint for recent activities
    public function getRecentActivities()
    {
        $activities = ActivityLog::orderBy('created_at', 'desc')->limit(10)->get();

        return response()->json([
            'activities' => $activities->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'user_name' => $activity->user_name,
                    'short_description' => $activity->short_description,
                    'type' => $activity->type,
                    'status' => $activity->status,
                    'created_at' => $activity->created_at->diffForHumans(),
                    'icon_class' => $this->getIconClass($activity->type, $activity->status),
                    'color_class' => $this->getColorClass($activity->type, $activity->status),
                ];
            })
        ]);
    }

    // Helper method to get icon class
    private function getIconClass($type, $status)
    {
        if ($type === 'update_status') {
            switch ($status) {
                case 'pending':
                    return 'fa-clock';
                case 'ongoing':
                case 'in_progress':
                    return 'fa-spinner';
                case 'printed':
                    return 'fa-print';
                case 'repaired':
                    return 'fa-screwdriver-wrench';
                case 'released':
                    return 'fa-circle-check';
                case 'cancelled':
                case 'unrepairable':
                    return 'fa-circle-xmark';
                default:
                    return 'fa-circle-info';
            }
        } elseif ($type === 'create_ticket' || $type === 'repair') {
            return 'fa-file-lines';
        } elseif ($type === 'update_ticket') {
            return 'fa-pen-to-square';
        } elseif ($type === 'update_user') {
            return 'fa-user';
        } elseif ($type === 'password_changed') {
            return 'fa-lock';
        } elseif ($type === 'delete_user') {
            return 'fa-user-slash';
        } elseif ($type === 'add_inventory') {
            return 'fa-boxes-packing';
        } elseif ($type === 'issue_inventory') {
            return 'fa-user-check';
        } elseif ($type === 'return_inventory') {
            return 'fa-share';
        } elseif ($type === 'edit_inventory') {
            return 'fa-pen-to-square';
        } elseif ($type === 'delete_inventory') {
            return 'fa-ban';
        }
        return 'fa-circle-info';
    }

    // Helper method to get color class
    private function getColorClass($type, $status)
    {
        if ($type === 'update_status') {
            switch ($status) {
                case 'pending':
                    return 'status-pending';
                case 'ongoing':
                case 'in_progress':
                    return 'status-ongoing';
                case 'printed':
                case 'repaired':
                    return 'status-printed';
                case 'released':
                    return 'status-released';
                case 'cancelled':
                case 'unrepairable':
                    return 'status-cancelled';
                default:
                    return 'status-default';
            }
        } elseif ($type === 'create_ticket' || $type === 'repair' || $type === 'update_ticket') {
            return 'activity-ticket';
        } elseif ($type === 'update_user') {
            return 'activity-user';
        } elseif ($type === 'password_changed') {
            return 'activity-password';
        } elseif ($type === 'delete_user') {
            return 'activity-delete';
        } elseif ($type === 'add_inventory') {
            return 'add-inventory';
        } elseif ($type === 'issue_inventory') {
            return 'issue-inventory';
        } elseif ($type === 'return_inventory') {
            return 'return-inventory';
        } elseif ($type === 'edit_inventory') {
            return 'edit-inventory';
        } elseif ($type === 'delete_inventory') {
            return 'delete-inventory';
        }
        return 'activity-default';
    }

    // Inventory graph 
    public function inventoryChart()
    {
        $categories = [
            'Computer System',
            'Components',
            'Peripherals',
            'Networking',
            'Cables & Adapters',
            'Others'
        ];

        $data = [];

        foreach ($categories as $category) {
            $data[] = [
                'category' => $category,
                'available' => InventoryItem::where('category', $category)
                    ->where('status', 'available')->count(),
                'issued' => InventoryItem::where('category', $category)
                    ->where('status', 'issued')->count(),
                'unusable' => InventoryItem::where('category', $category)
                    ->where('status', 'unusable')->count(),
            ];
        }

        return response()->json($data);
    }

    // Show login form
    public function login()
    {
        return view("auth.login");
    }

    // Handle login logic
    public function loginPost(Request $request)
    {
        // Validate login input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt to log in
        if (Auth::attempt($credentials)) {
            // Login successful
            return redirect()->route('main');
        }

        // Login failed
        return back()->with('error', 'Invalid credentials.')->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }

    public function addNewUser()
    {
        $type = 'addUser';

        $users = User::all();

        return view("addUser", compact('type', 'users'));
    }

    // Show register form
    public function register()
    {
        $type = $request->query('type');

        return view("auth.register", compact('type'));
    }

    // Handle registration logic
    public function registerPost(Request $request)
    {
        $request->validate([
            "fullname" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|confirmed|min:8|string",
            "role" => "required|in:admin,editor",
        ]);

        $user = new User();
        $user->name = $request->input('fullname');
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'editor';

        if ($user->save()) {
            return redirect(route("add-new-user"))
                ->with("success", "Registration successful.");
        }

        //Activity Logs
        ActivityLog::record(
            'Add User',
            "Created User {$user->name} ({$user->email})"
        );

        return back()
            ->withInput($request->only('fullname', 'email'))
            ->with("error", "Registration failed. Please try again.");
    }
    public function listUsers()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users,email,$id",
            "role" => "required|string|in:admin,editor",
            "password" => "nullable|min:6|confirmed"
        ]);

        $user = User::findOrFail($id);
        $changes = [];

        if ($user->name !== $request->name) {
            $changes[] = "Name: '{$user->name}' → '{$request->name}'";
            $user->name = $request->name;
        }

        if ($user->email !== $request->email) {
            $changes[] = "Email: '{$user->email}' → '{$request->email}'";
            $user->email = $request->email;
        }

        if ($user->role !== $request->role) {
            $changes[] = "Role: '{$user->role}' → '{$request->role}'";
            $user->role = $request->role;
        }

        if ($request->filled('password')) {
            $passwordChanged = true;
            $user->password = Hash::make($request->password);
        }

        $user->save();

        if ($passwordChanged) {
            ActivityLog::record(
                'Password Changed',  // ← Now it's in the action!
                "User {$user->name} changed their password"
            );
        }

        //Activity Logs
        if (!empty($changes)) {

            $description = implode("<br>", $changes);

            ActivityLog::record(
                'Update User',
                $description
            );
        }

        return back()->with("success", "User updated successfully.");
    }

    //Delete User
    public function Destroy($id)
    {
        $user = User::findOrFail($id);
        $name = $user->name;
        $user->delete();

        //Activity Logs
        ActivityLog::record(
            'Delete User',
            "Deleted User {$user->name} ({$user->email})"
        );

        return redirect()->back()->with('success', "User {$name} deleted successfuly!");
    }

    //Activity Logs Page Controller
    public function ActivityLogs()
    {
        $logs = ActivityLog::orderBy('created_at', 'desc')->get();

        return view('activity.logs', compact('logs'));
    }
}
