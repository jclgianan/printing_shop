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

class PrintingController extends Controller
{
    // Show printing page
    public function printing()
    {
        $type = 'printing';
        // Fetch print tickets for the printing dashboard
        $printTickets = PrintTicket::orderBy('created_at', 'desc')->get();

        return view('printing', compact('printTickets', 'type'));
    }

    // Show addPrinting Page
    public function printingForm(Request $request)
    {
        $type = $request->query('type');

        return view('modals.addPrinting', compact('type'));
    }

    // Printing search page fucntion

    public function receivingSearch(Request $request)
    {
        $type = 'printing';
        $query  = $request->input('query');

        $printTickets = PrintTicket::where('printTicket_id', 'like', '%' . $query . '%')
            ->orWhere('office_department', 'like', '%' . $query . '%')
            ->orWhere('itemname', 'like', '%' . $query . '%')
            ->get();

        return view('printing', compact('printTickets', 'type'));
    }

    // Printing Logs data view
    public function dashboard()
    {
        $printTickets = PrintTicket::latest()->get(); // Add filters as needed
        return view('printing', compact('printTickets'));
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

    // Filtering status in printing page
    public function statusFilter(Request $request)
    {
        $type = 'printing';
        $query = PrintTicket::query();

        if ($request->filled('filter')) {
            $query->where('status', 'like', '%' . $request->filter . '%');
        }
        
        $printTickets = $query->latest()->get();

        return view('printing', compact('printTickets', 'type'));
    }

    // Update the status of a print ticket
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,printed,released,cancelled'
        ]);

        try {
            $ticket = PrintTicket::findOrFail($id);
            $oldStatus = $ticket->formatted_status;
            
            // Update the status
            $ticket->status = $request->status;
            if ($request->status === 'released' && !$ticket->release_date) {
                $ticket->release_date = now();
            }
            $ticket->save();

            return response()->json([
                'success' => true,
                'message' => "Status updated from {$ticket->formatted_status} to {$ticket->formatted_status}",
                'new_status' => $ticket->formatted_status,
                'release_date' => $ticket->release_date 
                                ? $ticket->release_date->format('Y-m-d H:i')
                                : null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
            ], 500);
        }
    }

    public function printEdit($id)
    {
        $ticket = PrintTicket::findOrFail($id);
        return response()->json($ticket);
    }
    
    public function printUpdate(Request $request, $id)
    {
        $ticket = PrintTicket::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'office_department' => 'required|string|max:255',
            'itemname' => 'required|string|max:255',
            'size' => 'nullable|string|max:50',
            'quantity' => 'nullable|integer',
            'release_date' => 'nullable|date',
            'status' => 'nullable|in:pending,in_progress,printed,released,cancelled',
        ]);

        $ticket->update($request->only([
            'name', 'office_department', 'itemname', 'size', 'quantity', 'release_date', 'status'
        ]));

        return response()->json(['success' => 'Ticket updated successfully!', 'ticket' => $ticket]);
    }



}
