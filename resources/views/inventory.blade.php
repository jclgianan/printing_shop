@extends('layouts.default')

@section('title', 'Inventory Management')

@section('content')
<div class="receiving-container">
    <div class="layout-wrapper">
        <main class="receiving-main-panel">
            <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                <h1 class="mb-0">Inventory Management</h1>
                <a href=" {{ route('inventory.create')}}" class="btn btn-primary">
                    + Add Device
                </a>
            </div>

            <!-- Search Bar -->
            <form method="GET" action="" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" 
                        placeholder="Search device..." 
                        value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                    @if(request('search'))
                        <a href="" class="btn btn-outline-danger">Clear</a>
                    @endif
                </div>
            </form>

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Device Name</th>
                        <th>Total Units</th>
                        <th>Available</th>
                        <th>Issued</th>
                        <th>Unusable</th>
                        <th style="width: 180px;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($devices as $device)
                        <tr>
                            <td>{{ $device->device_id }}</td>
                            <td>{{ $device->device_name }}</td>
                            <td>{{ $device->total_units }}</td>
                            <td>{{ $device->available }}</td>
                            <td>{{ $device->issued }}</td>
                            <td>{{ $device->unusable }}</td>
                            <td>
                                <a href="{{ route('inventory.view', $device->device_id) }}" class="btn btn-sm btn-info">
                                    View Units
                                </a>
                                
                                <form action="" method="POST" 
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
        </main>

        
    </div>
</div>
@endsection
