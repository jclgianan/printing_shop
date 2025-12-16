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
                        <a href=" {{ route('inventory.create') }}" class="receiving_newEntry">
                            + Add Device
                        </a>
                    </div>
                </div>



                <div class="category-filter">
                    <!-- Filter By Category on the left -->
                    <form action="{{ route('inventory') }}" method="GET" class="filter-form">
                        <div class="filter-category-group">
                            <label for="category-filter">Filter by:</label>
                            <select name="category" id="category-filter" class="form-select" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                <option value="Computer System"
                                    {{ request('category') == 'Computer System' ? 'selected' : '' }}>Computer System
                                </option>
                                <option value="Components" {{ request('category') == 'Components' ? 'selected' : '' }}>
                                    Components</option>
                                <option value="Peripherals" {{ request('category') == 'Peripherals' ? 'selected' : '' }}>
                                    Peripherals</option>
                                <option value="Networking" {{ request('category') == 'Networking' ? 'selected' : '' }}>
                                    Networking</option>
                                <option value="Cables & Adapters"
                                    {{ request('category') == 'Cables & Adapters' ? 'selected' : '' }}>Cables & Adapters
                                </option>
                                <option value="Others" {{ request('category') == 'Others' ? 'selected' : '' }}>Others
                                </option>
                            </select>
                        </div>
                    </form>
                    <!-- Search Bar on the right -->
                    <form action="{{ route('inventory') }}" method="GET" class="search-form">
                        <div class="search-group">
                            <input type="text" name="search" class="search-input" placeholder="Search"
                                aria-label="Search">
                            <button class="btn btn-primary" type="submit"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                </div>
            @endif
            
            <div class="category-filter">
                <!-- Filter By Category on the left -->
                <form action="{{ route('inventory') }}" method="GET" class="filter-form">
                    <div class="filter-category-group">
                        <label for="category-filter"><i class="fa-solid fa-filter"></i> Filter by:</label>
                        <select name="category" id="category-filter" class="form-select" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            <option value="Computer System" {{ request('category') == 'Computer System' ? 'selected' : '' }}>Computer System</option>
                            <option value="Components" {{ request('category') == 'Components' ? 'selected' : '' }}>Components</option>
                            <option value="Peripherals" {{ request('category') == 'Peripherals' ? 'selected' : '' }}>Peripherals</option>
                            <option value="Networking" {{ request('category') == 'Networking' ? 'selected' : '' }}>Networking</option>
                            <option value="Cables & Adapters" {{ request('category') == 'Cables & Adapters' ? 'selected' : '' }}>Cables & Adapters</option>
                            <option value="Others" {{ request('category') == 'Others' ? 'selected' : '' }}>Others</option>
                        </select>
                    </div>
                </form>
                <!-- Search Bar on the right -->
                <form action="{{ route('inventory') }}" method="GET" class="search-form">
                    <div class="search-group">
                        <input type="text" name="search" class="search-input" placeholder="Search"
                            aria-label="Search">
                        <button class="btn btn-primary" type="submit"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
            
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
                            @foreach ($devices as $device)
                                <tr>
                                    <td>{{ $device->device_id }}</td>
                                    <td>{{ $device->device_name }}</td>
                                    <td>{{ $device->category }}</td>
                                    <td>{{ $device->total_units }}</td>
                                    <td>{{ $device->available }}</td>
                                    <td>{{ $device->issued }}</td>
                                    <td>{{ $device->unusable }}</td>
                                    <td class="action-buttons">
                                        <a href="{{ route('inventory.view', $device->device_id) }}"
                                            class="btn btn-sm btn-info">
                                            View
                                        </a>

                                        <form action="{{ route('destroy-device', $device->device_id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger confirm-delete">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="custom-pagination">
                    {{ $devices->appends(request()->input())->links('pagination::bootstrap-5') }}
                </div>
            </main>


        </div>
    </div>

    @if (session('success'))
        <script>
            window.onload = () => {

                const successMessage = `{{ session('success') }}`;


                Swal.fire({
                    title: successMessage || 'Device added successfully.',
                    icon: 'success',
                    customClass: {
                        container: "pop-up-success-container",
                        popup: "pop-up-success",
                        title: "pop-up-success-title",
                        htmlContainer: "pop-up-success-text",
                        confirmButton: "btn-success",
                        icon: "pop-up-icon",
                    },
                    timer: 3000,
                    showConfirmButton: true
                }).then((result) => {
                    window.location.reload();
                });
            };
        </script>
    @endif
@endsection
