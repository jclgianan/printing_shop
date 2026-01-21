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
use Illuminate\Support\Facades\Log;
use Illuminate\Types\Relations\Car;
use PHPUnit\TextUI\XmlConfiguration\Group;

class PrintingController extends Controller
{
    // Show printing page
    public function printing()
    {
        $type = 'printing';
        // Fetch print tickets for the printing dashboard
        $printTickets = PrintTicket::orderBy('receiving_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);

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
            ->orWhere('name', 'like', '%' . $query . '%')
            ->orderBy('receiving_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('printing', compact('printTickets', 'type'));
    }

    // Printing Logs data view
    public function dashboard()
    {
        $printTickets = PrintTicket::orderBy('receiving_date', 'desc')->paginate(10);  // Add filters as needed
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
            'deadline' => 'nullable|date',
            'file_link' => 'nullable|string|max:255',
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
                'deadline' => $request->deadline,
                'file_link' => $request->file_link,
                'status' => 'pending',
            ]);

            $user = auth()->user();

            try {
                ActivityLog::record(
                    'Add Print Ticket',
                    "Print Ticket {$ticket->printTicket_id} was created"
                );
            } catch (\Exception $e) {
                Log::error('Failed to log Print Ticket activity: ' . $e->getMessage());
                // don't throw, let ticket submission succeed
            }


            // If AJAX, return JSON
            if ($request->ajax()) {
                return response()->json([
                    'success' => 'Print Ticket saved successfully!',
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
                    'error' => 'Failed to save Print Ticket.',
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

        // Check if the filter is 'released' to sort by release_date
        if ($request->filter === 'released') {
            $query->orderBy('release_date', 'desc')
                ->orderBy('id', 'desc');
        } else {
            $query->orderBy('receiving_date', 'desc')
                ->orderBy('id', 'desc');
        }

        $printTickets = $query->paginate(10);

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

            $user = auth()->user();

            //Activity Logs
            try {
                ActivityLog::record(
                    'Update Print Status',
                    "Print Ticket {$ticket->printTicket_id} status changed from {$oldStatus} to {$ticket->formatted_status}"
                );
            } catch (\Exception $e) {
                Log::error('Failed to record activity log: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => "Status updated from {$ticket->formatted_status} to {$ticket->formatted_status}",
                'new_status' => $ticket->formatted_status,
                'release_date' => $ticket->release_date
                    ? \Carbon\Carbon::parse($ticket->release_date)->format('m-d-Y H:i')
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
            'deadline' => 'nullable|date',
            'file_link' => 'nullable|string|max:255',
            'release_date' => 'nullable',
            'status' => 'nullable|in:pending,in_progress,printed,released,cancelled',
        ]);

        $changes = [];

        // Update fields except release_date (handle separately)
        foreach ($request->only(['name', 'office_department', 'itemname', 'size', 'quantity', 'deadline', 'file_link', 'status']) as $field => $value) {
            if ($ticket->$field != $value) {
                $changes[] = ucfirst($field) . ": '{$ticket->$field}' → '{$value}'";
                $ticket->$field = $value;
            }
        }

        // Handle release_date separately to preserve time component
        if ($request->has('release_date') && $request->release_date) {
            $newReleaseDate = $request->release_date;
            $oldReleaseDate = $ticket->release_date;

            // Check if the incoming date has time component
            if (strpos($newReleaseDate, ':') !== false || strpos($newReleaseDate, 'T') !== false) {
                // Full datetime provided (e.g., "2024-12-15 14:30:00" or "2024-12-15T14:30")
                $formattedDate = str_replace('T', ' ', $newReleaseDate);

                // Ensure no seconds in the time
                $carbonDate = \Carbon\Carbon::parse($formattedDate);
                $formattedDate = $carbonDate->format('Y-m-d H:i:00');

                if ($oldReleaseDate != $formattedDate) {
                    $changes[] = "Release Date: '{$oldReleaseDate}' → '{$formattedDate}'";
                    $ticket->release_date = $formattedDate;
                }
            } else {
                // Only date provided (e.g., "2024-12-15")
                // Preserve existing time if available
                if ($oldReleaseDate) {
                    $existingTime = \Carbon\Carbon::parse($oldReleaseDate)->format('H:i:00');
                    $newDateTime = $newReleaseDate . ' ' . $existingTime;

                    // Only log change if the DATE part actually changed
                    $oldDateOnly = \Carbon\Carbon::parse($oldReleaseDate)->format('Y-m-d');
                    if ($oldDateOnly != $newReleaseDate) {
                        $changes[] = "Release Date: '{$oldReleaseDate}' → '{$newDateTime}'";
                    }

                    $ticket->release_date = $newDateTime;
                } else {
                    // No existing time, use current time
                    $newDateTime = $newReleaseDate . ' 00:00:00';
                    $changes[] = "Release Date: 'null' → '{$newDateTime}'";
                    $ticket->release_date = $newDateTime;
                }
            }
        }

        $ticket->save();

        // Record activity log
        if (!empty($changes)) {
            try {
                ActivityLog::record(
                    'Update Print Ticket',
                    "Print Ticket {$ticket->printTicket_id} updated:<br>" . implode('<br>', $changes)
                );
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to record activity log: ' . $e->getMessage());
            }
        }

        return response()->json(['success' => 'Ticket updated successfully!', 'ticket' => $ticket]);
    }
}
