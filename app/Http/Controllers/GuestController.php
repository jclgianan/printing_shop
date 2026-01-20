<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ActivityLog;
use App\Models\RepairTicket;
use App\Models\PrintTicket;


class GuestController extends Controller
{
    // Display a guest page
    public function guestPage()
    {
        return view('guests.guestPage');
    }

    // Show request ticket form
    public function showRequestForm()
    {
        return view('guests.requestTicket');
    }

    // Display a guest ticket submission page
    public function guestTicket()
    {
        return view('guests.guestTicket');
    }

    // Show track ticket form
    public function showTrackTicketForm()
    {
        return view('guests.trackTicket');
    }

    // Track ticket
    public function trackTicket(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|string|max:50'
        ]);

        $ticketId = $request->input('ticket_id');
        $ticket = null;
        $ticketType = null;

        // Search in print tickets first
        $ticket = PrintTicket::where('printTicket_id', $ticketId)->first();

        if ($ticket) {
            $ticketType = 'print';
        } else {
            // If not found, search in repair tickets
            $ticket = RepairTicket::where('repairTicket_id', $ticketId)->first();
            if ($ticket) {
                $ticketType = 'repair';
            }
        }

        return view('guests.trackTicket', compact('ticket', 'ticketType'));
    }
}
