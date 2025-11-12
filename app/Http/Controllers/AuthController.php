<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Process;
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

        return view('modals.addPrinting', compact('type'));
    }
    // Show addRepair Page
    public function repairForm(Request $request)
    {
        $type = $request->query('type');

        return view('modals.addRepair', compact('type'));
    }

    // Printing search page fucntion

    public function receivingSearch(Request $request)
    {
        $query  = $request->input('query');

        $printTickets = PrintTicket::where('printTicket_id', 'like', '%' . $query . '%')->get();

        return view('printing', compact('printTickets'));
    }

    // Repair search page fucntion

    public function repairSearch(Request $request)
    {
        $query  = $request->input('query');

        $repairTickets = RepairTicket::where('repairTicket_id', 'like', '%' . $query . '%')->get();

        return view('repair', compact('repairTickets'));
    }

    // Printing Logs data view
    public function dashboard()
    {
        $printTickets = PrintTicket::latest()->get(); // Add filters as needed
        return view('printing.index', compact('printTickets'));
    }

    // Repair Logs data view
    public function repairDashboard()
    {
        $repairTickets = RepairTicket::latest()->get(); // Add filters as needed
        return view('repair.index', compact('repairTickets'));
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
            $ticket = PrintTicket::create([
                'printTicket_id' => $randomId,
                'receiving_date' => $request->receiving_date,
                'name' => $request->name,
                'office_department' => $request->office_department,
                'itemname' => $request->itemname,
                'size' => $request->size,
                'quantity' => $request->quantity,
                'status' => 'pending',
            ]);

             // If AJAX, return JSON
            if ($request->ajax()) {
                return response()->json([
                    'success' => 'Repair Ticket saved successfully!',
                    'ticket' => $ticket,
                ]);
            }
            
            // Redirect with success message
            return redirect(route("printing.form"))->with('success', 'Print Ticket saved successfully!');
        } catch (\Exception $e) {
            // Log exception details to help debug why saving failed
            Log::error('Failed to save Print Ticket: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to save Repair Ticket.',
                    'details' => config('app.debug') ? $e->getMessage() : null,
                ], 500);
            } 
            // Redirect with error message
            return redirect()->route('printing.form')->with('error', 'Failed to save Print Ticket. Please try again.');
        }
    }

    // Storing the input of the repair form
    public function repairTicketStore(Request $request)
    {
        // Validate inputs
        $request->validate([
            'receiving_date' => 'required|date',
            'name' => 'required|string|max:255',
            'office_department' => 'required|string|max:255',
            'itemname' => 'required|string|max:255',
            'issue' => 'required|string|max:100',
            'note' => 'nullable|string|max:100',
        ]);

        try {
            // If the client generated an ID (via the Generate button), use it if it's unique.
            $providedId = $request->input('repairTicket_id');

            if ($providedId && !RepairTicket::where('repairTicket_id', $providedId)->exists()) {
                $randomId = $providedId;
            } else {
                // Generate a unique server-side ID
                do {
                    $randomId = 'RPR-' . date('Ymd') . '-' . strtoupper(Str::random(4));
                } while (RepairTicket::where('repairTicket_id', $randomId)->exists());
            }

            // Create the print ticket record (process_id is optional)
            // Do NOT set release_date here; it will be set when status becomes 'released'.
            $ticket = RepairTicket::create([
                'repairTicket_id' => $randomId,
                'receiving_date' => $request->receiving_date,
                'name' => $request->name,
                'office_department' => $request->office_department,
                'itemname' => $request->itemname,
                'issue' => $request->issue,
                'note' => $request->note ?? null,
                'status' => 'pending',
            ]);

             // If AJAX, return JSON
            if ($request->ajax()) {
                $ticket = RepairTicket::latest()->first();
                return response()->json([
                    'success' => 'Repair Ticket saved successfully!',
                    'ticket' => $ticket
                ]);
            }


            // Redirect with success message
            return redirect(route("repair.form"))->with('success', 'Repair Ticket saved successfully!');
        } catch (\Exception $e) {
            // Log exception details to help debug why saving failed
            Log::error('Failed to save Repair Ticket: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to save Repair Ticket.',
                    'details' => config('app.debug') ? $e->getMessage() : null,
                    'debug' => $e->getMessage(), // 👈 Add this line for now
                ], 500);
            }                    
            // Redirect with error message
            return redirect()->route('repair.form')->with('error', 'Failed to save Repair Ticket. Please try again.');
        }
    }

    // Genrating the unique print ticket ID
    public function generatePrintTicketId()
    {   
        try {
            // Log the start of the process
            Log::info('Generating Ticket ID...');

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
            return response()->json(['error' => 'Error generating Ticket ID.'], 500);
        }
    }

    // Genrating the unique repair ticket ID
    public function generateRepairTicketId()
    {   
        try {
            // Log the start of the process
            Log::info('Generating Ticket ID...');

            do {
                // Create ticket ID with today's date and random characters (PRT prefix)
                $randomId = 'RPR-' . date('Ymd') . '-' . strtoupper(Str::random(4));

                // Log the generated ID
                Log::info("Generated ID: $randomId");

                // Check if this ID already exists in the database
            } while (RepairTicket::where('repairTicket_id', $randomId)->exists());

            // Return the generated ID as a response
            return response()->json(['repairTicket_id' => $randomId]);
        } catch (\Exception $e) {
            // Log the exception if something goes wrong
            Log::error("Error generating Repair Ticket ID: " . $e->getMessage());
            
            // Return an error response
            return response()->json(['error' => 'Error generating Ticket ID.'], 500);
        }
    }

    // Filtering status in printing page
    public function statusFilter(Request $request)
    {
        $type = 'printing';
        $query = PrintTicket::query();

        if ($request->filled('filter')) {
            $query->where('status', 'like', '%' . $request->filter . '%');
        }

        $printTickets = $query->get();

        return view('printing', compact('printTickets', 'type'));
    }

    // Filtering status in repair page
    public function statusRepairFilter(Request $request)
    {
        $type = 'repair';
        $query = RepairTicket::query();

        if ($request->filled('filter')) {
            $query->where('status', 'like', '%' . $request->filter . '%');
        }

        $repairTickets = $query->get();

        return view('repair', compact('repairTickets', 'type'));
    }

    // Update the status of a print ticket
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

    // Update the status of a print ticket
    public function updateRepairStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,repaired,released,unrepairable'
        ]);

        try {
            $ticket = RepairTicket::findOrFail($id);
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

    public function statusRepairEdit($id)
    {
        $ticket = RepairTicket::findOrFail($id);
        return view('status_repair_edit', compact('ticket'));
    }

}
