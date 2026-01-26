@extends('layouts.guest')

@section('title', 'Track Ticket')

@section('content')
    <div class="track-ticket-container">
        <h2 class="track-ticket-heading"><i class="fa-solid fa-search"></i> Track Your Ticket</h2>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('guest.trackTicket') }}" method="GET" class="track-ticket-form">
            <label for="ticket_id" class="track-ticket-label">Enter your Ticket ID:</label>
            <input type="text" id="ticket_id" name="ticket_id" class="track-ticket-input"
                placeholder="e.g., PRT-20250101-MERW or RPR-20250101-MERW"
                value="{{ session('ticket_id') ?? (old('ticket_id') ?? request('ticket_id')) }}" required>
            <button type="submit" class="track-ticket-button">
                <i class="fa-solid fa-search"></i> Track Ticket
            </button>
        </form>

        @if (isset($ticket))
            <div class="ticket-status">
                <h3 class="ticket-status-heading">
                    <i class="fa-solid fa-ticket"></i>
                    {{ ucfirst($ticketType) }} Ticket Status
                </h3>

                <div class="ticket-details">
                    @if ($ticketType === 'print')
                        <div class="detail-row">
                            <span class="label">Ticket ID:</span>
                            <span class="value">{{ $ticket->printTicket_id }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Type:</span>
                            <span class="value">Print Request</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Name:</span>
                            <span class="value">{{ $ticket->name }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Office/Department:</span>
                            <span class="value">{{ $ticket->office_department }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Item:</span>
                            <span class="value">{{ $ticket->itemname }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Quantity:</span>
                            <span class="value">{{ $ticket->quantity }}</span>
                        </div>
                        <div class="detail-row status-row">
                            <span class="label">Status:</span>
                            <span class="status-badge status-{{ $ticket->status }}">
                                {{ $ticket->formatted_status }}
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Requested Date:</span>
                            <span class="value">{{ $ticket->receiving_date->format('F j, Y') }}</span>
                        </div>
                        @if ($ticket->deadline)
                            <div class="detail-row">
                                <span class="label">Deadline:</span>
                                <span
                                    class="value">{{ \Carbon\Carbon::parse($ticket->deadline)->format('F j, Y') }}</span>
                            </div>
                        @endif
                        @if ($ticket->release_date)
                            <div class="detail-row">
                                <span class="label">Completed Date:</span>
                                <span class="value">{{ $ticket->release_date->format('F j, Y, g:i a') }}</span>
                            </div>
                        @endif
                    @else
                        <div class="detail-row">
                            <span class="label">Ticket ID:</span>
                            <span class="value">{{ $ticket->repairTicket_id }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Type:</span>
                            <span class="value">Repair Request</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Name:</span>
                            <span class="value">{{ $ticket->name ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Device:</span>
                            <span class="value">{{ $ticket->device_name ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-row status-row">
                            <span class="label">Status:</span>
                            <span class="status-badge status-{{ $ticket->status }}">
                                {{ $ticket->formatted_status ?? ucfirst($ticket->status) }}
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Requested Date:</span>
                            <span class="value">{{ $ticket->created_at->format('F j, Y, g:i a') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Last Updated:</span>
                            <span class="value">{{ $ticket->updated_at->format('F j, Y, g:i a') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        @elseif(request()->has('ticket_id'))
            <div class="ticket-not-found">
                <i class="fa-solid fa-circle-exclamation"></i>
                <h3>No ticket found with ID: {{ request('ticket_id') }}</h3>
                <p>Please check your ticket ID and try again.</p>
            </div>
        @endif

        <div class="back-link">
            <a href="{{ route('guest.page') }}">
                <i class="fa-solid fa-arrow-left"></i> Back to Guest Portal
            </a>
        </div>
    </div>

    <style>
        .track-ticket-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
        }

        .track-ticket-heading {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 2rem;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .track-ticket-form {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .track-ticket-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #333;
        }

        .track-ticket-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            margin-bottom: 15px;
        }

        .track-ticket-input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        .track-ticket-button {
            width: 100%;
            padding: 12px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .track-ticket-button:hover {
            background: #1e7e34;
        }

        .ticket-status {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .ticket-status-heading {
            color: #007bff;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #007bff;
        }

        .ticket-details {
            display: grid;
            gap: 15px;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 15px;
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-row .label {
            font-weight: 600;
            color: #555;
        }

        .detail-row .value {
            color: #333;
        }

        .status-row {
            background: #f8f9fa;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .status-pending {
            background: #ffc107;
            color: #856404;
        }

        .status-in_progress {
            background: #17a2b8;
            color: white;
        }

        .status-printed,
        .status-completed {
            background: #28a745;
            color: white;
        }

        .status-released {
            background: #007bff;
            color: white;
        }

        .status-cancelled {
            background: #dc3545;
            color: white;
        }

        .ticket-not-found {
            background: #f8d7da;
            color: #721c24;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #f5c6cb;
        }

        .ticket-not-found i {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .back-link {
            text-align: center;
            margin-top: 30px;
        }

        .back-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .detail-row {
                grid-template-columns: 1fr;
                gap: 5px;
            }
        }
    </style>
@endsection
