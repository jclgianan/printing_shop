@extends('layouts.guest')

@section('title', 'Track Ticket')

@section('content')
    <div class="track-ticket-container-main">
        <div class="back-link">
            <a href="{{ route('guest.page') }}">
                <i class="fa-solid fa-arrow-left"></i> Back to Guest Portal
            </a>
        </div>
        <div class="track-ticket-container">
            <h2 class="track-ticket-heading"><i class="fa-solid fa-search"></i> Track Your Ticket</h2>

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="track-input-container">
                <form action="{{ route('guest.trackTicket') }}" method="GET" class="track-ticket-form">
                    {{-- <label for="ticket_id" class="track-ticket-label">Enter your Ticket ID:</label> --}}
                    <input type="text" id="ticket_id" name="ticket_id" class="track-ticket-input"
                        placeholder="Enter your Ticket ID e.g. PRT-20250101-MERW"
                        value="{{ session('ticket_id') ?? (old('ticket_id') ?? request('ticket_id')) }}" required>
                    <button type="submit" class="track-ticket-button">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </form>
            </div>
            @if (isset($ticket))
                <div class="ticket-status">
                    @php
                        $steps = [
                            'pending' => 'Pending',
                            'in_progress' => 'Ongoing',
                            'printed' => 'Printed',
                            'released' => 'Released',
                        ];

                        $dbStatus = strtolower(trim($ticket->status));
                        $keys = array_keys($steps);
                        $currentIndex = array_search($dbStatus, $keys);

                        if ($currentIndex === false) {
                            $currentIndex = 0;
                        }
                    @endphp

                    <div class="status-stepper">
                        @foreach ($steps as $key => $label)
                            @php
                                $loopIndex = array_search($key, $keys);
                                $isDone = $loopIndex < $currentIndex;
                                $isActive = $loopIndex === $currentIndex;
                            @endphp

                            <div class="step {{ $isDone ? 'done' : '' }} {{ $isActive ? 'active' : '' }}">
                                <div class="circle"></div>
                                <span class="status-label">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>


                    <div class="ticket-details">
                        <h3 class="ticket-status-heading">
                            {{-- <i class="fa-solid fa-ticket"></i> --}}
                            {{ ucfirst($ticketType) }} Ticket Status
                        </h3>
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
                            {{-- <div class="detail-row status-row">
                                <span class="label">Status:</span>
                                <span class="status-badge status-{{ $ticket->status }}">
                                    {{ $ticket->formatted_status }}
                                </span>
                            </div> --}}
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
                            {{-- <div class="detail-row status-row">
                                <span class="label">Status:</span>
                                <span class="status-badge status-{{ $ticket->status }}">
                                    {{ $ticket->formatted_status ?? ucfirst($ticket->status) }}
                                </span>
                            </div> --}}
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


        </div>
    </div>

@endsection
