@extends('layouts.guest')

@section('title', 'Guest Portal')

@section('content')
    <div class="guest-portal-container">
        <div class="guest-header">
            <h1><i class="fa-solid fa-users"></i> Welcome to Our Service Portal</h1>
            <p>Request printing or repair services, or track your existing tickets</p>
        </div>

        <div class="guest-actions">
            <div class="action-card">
                <div class="action-icon">
                    <i class="fa-solid fa-plus-circle"></i>
                </div>
                <h2>Request a Ticket</h2>
                <p>Submit a new printing or repair request</p>
                <a href="" class="btn btn-request">
                    <i class="fa-solid fa-ticket"></i> Create New Request
                </a>
            </div>

            <div class="action-card">
                <div class="action-icon">
                    <i class="fa-solid fa-search"></i>
                </div>
                <h2>Track Your Ticket</h2>
                <p>Check the status of your existing request</p>
                <a href="{{ route('guest.trackTicketForm') }}" class="btn btn-track">
                    <i class="fa-solid fa-location-crosshairs"></i> Track Ticket
                </a>
            </div>
        </div>

        <div class="guest-footer">
            <p>Already a staff member? <a href="{{ route('login') }}">Login here</a></p>
        </div>
    </div>

    <style>
        .guest-portal-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
        }

        .guest-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .guest-header h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 10px;
        }

        .guest-header p {
            font-size: 1.2rem;
            color: #666;
        }

        .guest-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .action-card {
            background: white;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }

        .action-icon {
            font-size: 4rem;
            color: #007bff;
            margin-bottom: 20px;
        }

        .action-card h2 {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: #333;
        }

        .action-card p {
            color: #666;
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-request {
            background: #007bff;
            color: white;
        }

        .btn-request:hover {
            background: #0056b3;
            color: white;
        }

        .btn-track {
            background: #28a745;
            color: white;
        }

        .btn-track:hover {
            background: #1e7e34;
            color: white;
        }

        .guest-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #ddd;
        }

        .guest-footer a {
            color: #007bff;
            text-decoration: none;
        }

        .guest-footer a:hover {
            text-decoration: underline;
        }
    </style>
@endsection
