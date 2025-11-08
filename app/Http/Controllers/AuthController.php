<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Process;
use App\Models\PrintTicket;
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
        $type = 'printing';
        // Fetch print tickets for the printing dashboard
        $printTickets = PrintTicket::orderBy('created_at', 'desc')->get();

        return view('printing', compact('printTickets', 'type'));
    }

    // Show repairing page
    public function repair()
    {
        $type = 'repair';
        // Fetch data from the database
        $processes = PrintTicket::orderBy('created_at', 'desc')->get();

        return view('repair', compact('processes', 'type'));
    }

    // Show addPrinting Page
    public function printingForm(Request $request)
    {
        $type = $request->query('type');

        return view('addPrinting', compact('type'));
    }
    // Show addRepair Page
    public function repairForm(Request $request)
    {
        $type = $request->query('type');

        return view('addRepair', compact('type'));
    }

    // Printing search page fucntion

    public function receivingSearch(Request $request)
    {
        $query  = $request->input('query');

        $printTickets = PrintTicket::where('printTicket_id', 'like', '%' . $query . '%')->get();

        return view('printing', compact('printTickets'));
    }

    // Printing Logs data view
    public function dashboard()
    {
        $printTickets = PrintTicket::latest()->get(); // Add filters as needed
        return view('printing.index', compact('printTickets'));
    }

    // Storing the input of the print form
    public function printTicketStore(Request $request)
    {
        // Validate inputs
        $request->validate([
            'receiving_date' => 'required|date',
            'name' => 'required|string|max:255',
            'office_department' => 'required|string|max:255',
            'itemname' => 'required|string|max:255',
            'size' => 'required|string|max:100',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            // If the client generated an ID (via the Generate button), use it if it's unique.
            $providedId = $request->input('printTicket_id');

            if ($providedId && !PrintTicket::where('printTicket_id', $providedId)->exists()) {
                $randomId = $providedId;
            } else {
                // Generate a unique server-side ID
                do {
                    $randomId = 'PRT-' . date('Ymd') . '-' . strtoupper(Str::random(4));
                } while (PrintTicket::where('printTicket_id', $randomId)->exists());
            }

            // Create the print ticket record (process_id is optional)
            // Do NOT set release_date here; it will be set when status becomes 'released'.
            PrintTicket::create([
                'printTicket_id' => $randomId,
                'receiving_date' => $request->receiving_date,
                'name' => $request->name,
                'office_department' => $request->office_department,
                'itemname' => $request->itemname,
                'size' => $request->size,
                'quantity' => $request->quantity,
                'status' => 'pending',
            ]);

            // Redirect with success message
            return redirect(route("printing.form"))->with('success', 'Print Ticket saved successfully!');
        } catch (\Exception $e) {
            // Log exception details to help debug why saving failed
            Log::error('Failed to save Print Ticket: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            // Redirect with error message
            return redirect()->route('printing.form')->with('error', 'Failed to save Print Ticket. Please try again.');
        }
    }

    // Genrating the unique process ID
    public function generatePrintTicketId()
    {   
        try {
            // Log the start of the process
            Log::info('Generating Process ID...');

            do {
                // Create ticket ID with today's date and random characters (PRT prefix)
                $randomId = 'PRT-' . date('Ymd') . '-' . strtoupper(Str::random(4));

                // Log the generated ID
                Log::info("Generated ID: $randomId");

                // Check if this ID already exists in the database
            } while (PrintTicket::where('printTicket_id', $randomId)->exists());

            // Return the generated ID as a response
            return response()->json(['printTicket_id' => $randomId]);
        } catch (\Exception $e) {
            // Log the exception if something goes wrong
            Log::error("Error generating Print Ticket ID: " . $e->getMessage());
            
            // Return an error response
            return response()->json(['error' => 'Error generating process ID.'], 500);
        }
    }

    // Filtering status in printing page
    public function statusFilter(Request $request)
    {
        $query = PrintTicket::query();

        if ($request->filled('filter')) {
            $query->where('status', 'like', '%' . $request->filter . '%');
        }

        $printTickets = $query->get();

        return view('printing', compact('printTickets'));
    }

    /**
     * Update the status of a print ticket
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,printed,released,cancelled'
        ]);

        try {
            $ticket = PrintTicket::findOrFail($id);
            $oldStatus = $ticket->status;
            
            // Update the status
            $ticket->status = $request->status;
            if ($request->status === 'released' && !$ticket->release_date) {
                $ticket->release_date = now();
            }
            $ticket->save();

            return response()->json([
                'success' => true,
                'message' => "Status updated from {$ticket->formatted_status} to {$ticket->formatted_status}",
                'new_status' => $ticket->formatted_status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
            ], 500);
        }
    }
    public function statusEdit($id)
    {
        $ticket = PrintTicket::findOrFail($id);
        return view('status_edit', compact('ticket'));
    }

}
