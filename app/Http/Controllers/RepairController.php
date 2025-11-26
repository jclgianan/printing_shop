<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Process;
use App\Models\ActivityLog;
use App\Models\RepairTicket;
use Illuminate\Support\Facades\Log;
use PHPUnit\TextUI\XmlConfiguration\Group;

class RepairController extends Controller
{
    // Show repairing page
    public function repair()
    {
        $type = 'repair';
        // Fetch data from the database
        $repairTickets = RepairTicket::orderBy('receiving_date', 'desc')->get();

        return view('repair', compact('repairTickets', 'type'));
    }

    // Show addRepair Page
    public function repairForm(Request $request)
    {
        $type = $request->query('type');

        return view('modals.addRepair', compact('type'));
    }

    // Repair search page fucntion

    public function repairSearch(Request $request)
    {
        $type = 'repair';
        $query  = $request->input('query');

        $repairTickets = RepairTicket::where('repairTicket_id', 'like', '%' . $query . '%')
            ->orWhere('office_department', 'like', '%' . $query . '%')
            ->orWhere('itemname', 'like', '%' . $query . '%')
            ->get();

        return view('repair', compact('repairTickets'));
    }

    // Repair Logs data view
    public function repairDashboard()
    {
        $repairTickets = RepairTicket::orderBy('receiving_date')->get(); // Add filters as needed
        return view('repair', compact('repairTickets'));
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
            'solution' => 'nullable|string|max:100',
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

            $hasId = $request->input('has_id'); // 'yes' or 'no'
            $deviceId = $request->input('repairDevice_id');

            if (!$hasId) {
                return response()->json([
                    'error' => 'Please select whether you have an existing Device ID.'
                ], 422);
            }

            if ($hasId === 'yes') {
                if (!$deviceId || !RepairTicket::where('repairDevice_id', $deviceId)->exists()) {
                    return response()->json([
                        'error' => 'The device ID you entered does not exist.'
                    ], 422);
                }
                $finalDeviceId = $deviceId;
            } elseif ($hasId === 'no') {
                if (!$deviceId) {
                    return response()->json([
                        'error' => 'Please click "Generate" to create a Device ID.'
                    ], 422);
                }
                $finalDeviceId = $deviceId;
            }

            else {
                // No device input → generate a unique ID
                do {
                    $finalDeviceId = random_int(100000, 999999);
                } while (RepairTicket::where('repairDevice_id', $finalDeviceId)->exists());
            }

            // Create the print ticket record (process_id is optional)
            // Do NOT set release_date here; it will be set when status becomes 'released'.
            $ticket = RepairTicket::create([
                'repairDevice_id' => $finalDeviceId,
                'repairTicket_id' => $randomId,
                'receiving_date' => $request->receiving_date,
                'name' => $request->name,
                'office_department' => $request->office_department,
                'itemname' => $request->itemname,
                'issue' => $request->issue,
                'solution' => $request->solution,
                'note' => $request->note ?: null,
                'status' => 'pending',
            ]);

            $user = auth()->user();

            try {
                ActivityLog::record(
                    'Add Repair Ticket',
                    "Repair Ticket {$ticket->repairTicket_id} was created"
                );
            } catch (\Exception $e) {
                Log::error('Failed to log Repair Ticket activity: ' . $e->getMessage());
                // don't throw, let ticket submission succeed
            }


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
                ], 500);
            }

            // Redirect with error message
            return redirect()->route('repair.form')->with('error', 'Failed to save Repair Ticket. Please try again.');
        }
    }

    // Genrating the unique repair Device ID
    public function generateRepairDeviceId()
    {   
        try {
            // Log the start of the process
            Log::info('Generating Device ID...');

            do {
                // Create ticket ID with today's date and random characters (PRT prefix)
                $device_id = random_int(100000, 999999);

                // Log the generated ID
                Log::info("Generated ID: $device_id");

                // Check if this ID already exists in the database
            } while (RepairTicket::where('repairDevice_id', $device_id)->exists());

            // Return the generated ID as a response
            return response()->json(['repairDevice_id' => $device_id]);
        } catch (\Exception $e) {
            // Log the exception if something goes wrong
            Log::error("Error generating Repair Ticket ID: " . $e->getMessage());
            
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

    // Filtering status in repair page
    public function statusRepairFilter(Request $request)
    {
        $type = 'repair';
        $query = RepairTicket::query();

        if ($request->filled('filter')) {
            $query->where('status', 'like', '%' . $request->filter . '%');
        }

        $repairTickets = $query->orderBy('receiving_date', 'desc')->get();

        return view('repair', compact('repairTickets', 'type'));
    }

    // Update the status of a print ticket
    public function updateRepairStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,repaired,released,unrepairable'
        ]);

        try {
            $ticket = RepairTicket::findOrFail($id);
            $oldStatus = $ticket->formatted_status;
            
            // Update the status
            $ticket->status = $request->status;
            if ($request->status === 'released' && !$ticket->release_date) {
                $ticket->release_date = now();
            }
            $ticket->save();

            $user = auth()->user(); // current user

            try {
                ActivityLog::record(
                    'Update Repair Status',
                    "Repair Ticket {$ticket->repairTicket_id} status changed from {$oldStatus} to {$ticket->formatted_status}"

                );
            } catch (\Exception $e) {
                Log::error('Failed to record activity log: ' . $e->getMessage());
            }
 

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

     public function repairEdit($id)
    {
        $ticket = RepairTicket::findOrFail($id);
        return response()->json($ticket);
    }

    public function repairUpdate(Request $request, $id)
    {
        $ticket = RepairTicket::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'office_department' => 'required|string|max:255',
            'itemname' => 'required|string|max:255',
            'issue' => 'nullable|string|max:50',
            'solution' => 'nullable|string|max:50',
            'note' => 'nullable|string|max:100',
            'release_date' => 'nullable|date',
            'status' => 'nullable|in:pending,in_progress,printed,released,cancelled',
        ]);

        $deviceId = $request->input('repairDevice_id');
        if (!$deviceId) {
            do {
                $deviceId = random_int(100000, 999999);
            } while (RepairTicket::where('repairDevice_id', $deviceId)->exists());
        }
        
        $changes = [];
        // Update including repairDevice_id
        foreach ($request->only(['name','office_department','itemname','issue','solution','note','release_date','status']) as $field => $value) {
            if ($ticket->$field != $value) {
                $changes[] = ucfirst($field) .": '{$ticket->$field}' → '{$value}'";
                $ticket->$field = $value;
            }
        }
        $ticket->repairDevice_id = $deviceId;
        $ticket->save();

         // Record activity log
        if (!empty($changes)) {
            try {
                ActivityLog::record(
                    'Update Repair Ticket',
                    "Repair Ticket {$ticket->repairTicket_id} updated:<br>" . implode('<br>', $changes)
                );
            } catch (\Exception $e) {
                Log::error('Failed to record activity log: ' . $e->getMessage());
            }
        }

        return response()->json(['success' => 'Ticket updated successfully!', 'ticket' => $ticket]);
    }

    // Dashboard counting
    public function repairMain()
    {
        $pending = RepairTicket::where('status', 'pending')->count();
        $in_progress = RepairTicket::where('status', 'in_progress')->count();
        $completed = RepairTicket::where('status', 'completed')->count();
        $released = RepairTicket::where('status', 'released')->count();
        $unrepairable = RepairTicket::where('status', 'unrepairable')->count();

        return view('main', compact('pending', 'in_progress', 'completed', 'released', 'unrepairable'));
    }


}
