@extends('layouts.default')

@section('title', 'Inventory Management')

@section('content')
<div class="receiving-container">
    <div class="layout-wrapper-printing">
        <main class="receiving-main-panel">
            <div class="content-placeholder header-row">
                <div class="header-top">
                    <div class="header-text">
                        <h2 class="section-heading"><i class="fa-solid fa-boxes-packing"></i> Inventory Management</h2>
                    </div>
                    <!-- New Device Button on the right -->
                    <a href=" {{ route('inventory.create')}}" class="receiving_newEntry">
                        + Add Device
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div id="flash-success" class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search Bar on the right -->
            <form action="{{ route('inventory-search') }}" method="GET" class="search-form">
                <div class="search-group">
                    <input type="text" name="query" class="search-input" placeholder="Search"
                        aria-label="Search">
                    <button class="btn btn-primary" type="submit"><i
                            class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
            <div class="process-log">
                <table class="process-table">
                    <thead>
                        <tr class="table-header">
                            <th style="width: 60px;">ID</th>
                            <th>Device Name</th>
                            <th>Category</th>
                            <th>Total Units</th>
                            <th>Available</th>
                            <th>Issued</th>
                            <th>Unusable</th>
                            <th style="width: 200px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($devices as $device)
                            <tr>
                                <td>{{ $device->device_id }}</td>
                                <td>{{ $device->device_name }}</td>
                                <td>{{ $device->category }}</td>
                                <td>{{ $device->total_units }}</td>
                                <td>{{ $device->available }}</td>
                                <td>{{ $device->issued }}</td>
                                <td>{{ $device->unusable }}</td>
                                <td>
                                    <a href="{{ route('inventory.view', $device->device_id) }}" class="btn btn-sm btn-info">
                                        View Units
                                    </a>
                                    
                                    <form action="{{ route('destroy-device', $device->device_id) }}" method="POST" 
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete all units of this device?')">
                                            Delete All
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
            
        </main>

        
    </div>
</div>
@endsection
