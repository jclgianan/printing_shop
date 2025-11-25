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
use App\Models\RepairTicket;
use Illuminate\Support\Facades\Log;
use PHPUnit\TextUI\XmlConfiguration\Group;

use function PHPSTORM_META\type;

class AuthController extends Controller
{
    // Show main page after login
    public function index()
    {
        return view("main");
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
            $changes[] = "Password changed";
            $user->password = Hash::make($request->password);
        }

        $user->save();

        //Activity Logs
        if(!empty($changes)) {

            $description = implode("<br>", $changes);

            ActivityLog::record(
                'Update User',
                $description
            );
        }

        return back()->with("success", "User updated successfully.");
    }

    //Delete User
    public function Destroy($id) {
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
    public function ActivityLogs(){
        $logs = ActivityLog::orderBy('created_at', 'desc')->get();

        return view('activity.logs', compact('logs'));
    }
     
}
