<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Process;
use Illuminate\Support\Facades\Log;
use PHPUnit\TextUI\XmlConfiguration\Group;

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

    // Show register form
    public function register()
    {
        // Return a full page view that loads the layout (so CSS/JS are included)
        return view("auth.register_page");
    }

    // Handle registration logic
    public function registerPost(Request $request)
    {
        $request->validate([
            "fullname" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|confirmed|min:8|string",
        ]);

        $user = new User();
        $user->name = $request->input('fullname');
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            return redirect(route("login"))
                ->with("success", "Registration successful.");
        }

        return back()
            ->withInput($request->only('fullname', 'email'))
            ->with("error", "Registration failed. Please try again.");
    }
    // Show printing page
    public function printing()
    {
        // Fetch data from the database
        $processes = Process::orderBy('created_at', 'desc')->get();

        return view('printing', compact('processes'));
    }

    // Show receiving page
    public function receiving()
    {
        // Fetch data from the database
        $processes = Process::orderBy('created_at', 'desc')->get();

        return view('receiving', compact('processes'));
    }

    // Show Disbursement and liquidation page
    public function createForm(Request $request)
    {
        $type = $request->query('type');
        return view('disbursement', compact('type'));  // Will only show the disbursement page
    }

    // Receiving search page fucntion

    public function receivingSearch(Request $request)
    {
        $query  = $request->input('query');

        $processes = Process::where('process_id', 'like', '%' . $query . '%')->get();

        return view('receiving', compact('processes'));
    }

    // Process Logs data view
    public function dashboard()
    {
        $processes = Process::latest()->get(); // Add filters as needed
        return view('receiving.index', compact('processes'));
    }

    // Storing the input of the disbursement form
    public function store(Request $request)
    {
        // Validate inputs
        $request->validate([
            'receiving_date' => 'required|date',
            'category' => 'required|string|in:category1,category2,category3',
            'type' => 'required|in:disbursement,liquidation',
        ]);

        try {
            // Generate a unique process ID
            do {
                $randomId = 'PRC-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            } while (Process::where('process_id', $randomId)->exists());

            // Create the new process
            Process::create([
                'process_id' => $randomId, 
                'receiving_date' => $request->receiving_date,
                'category' => $request->category,
                'type' => $request->type,
            ]);

            // Redirect with success message
            return redirect()->route('disbursement.form')->with('success', 'Process saved successfully!');
        } catch (\Exception $e) {
            // Redirect with error message
            return redirect()->route('disbursement.form')->with('error', 'Failed to save process. Please try again.');
        }
    }

    // Genrating the unique process ID
    public function generateProcessId()
    {   
        try {
            // Log the start of the process
            Log::info('Generating Process ID...');

            do {
                // Create process ID with today's date and random characters
                $randomId = 'PRC-' . date('Ymd') . '-' . strtoupper(Str::random(4));

                // Log the generated ID
                Log::info("Generated ID: $randomId");

                // Check if this ID already exists in the database
            } while (Process::where('process_id', $randomId)->exists());

            // Return the generated ID as a response
            return response()->json(['process_id' => $randomId]);
        } catch (\Exception $e) {
            // Log the exception if something goes wrong
            Log::error("Error generating process ID: " . $e->getMessage());
            
            // Return an error response
            return response()->json(['error' => 'Error generating process ID.'], 500);
        }
    }

    // Filtering Categories in receving page
    public function categoryFilter(Request $request)
    {
        $query = Process::query();

        if ($request->filled('filter')) {
            $query->where('category', 'like', '%' .$request->filter . '%');
        }

        $processes = $query->get();

        return view('receiving', compact('processes'));
    }

}
