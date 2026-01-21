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
                            <label for="category-filter"><i class="fa-solid fa-filter"></i> Filter by:</label>
                            <select name="category" id="category-filter" class="form-select" onchange="this.form.submit()">
                                <option value="" {{ request('category') == '' ? 'selected' : '' }}>
                                    All Categories
                                </option>
                                <option value="Computer System"
                                    {{ request('category') == 'Computer System' ? 'selected' : '' }}> Computer System
                                </option>
                                <option value="Components" {{ request('category') == 'Components' ? 'selected' : '' }}>
                                    Components</option>
                                <option value="Peripherals" {{ request('category') == 'Peripherals' ? 'selected' : '' }}>
                                    Peripherals</option>
                                <option value="Networking" {{ request('category') == 'Networking' ? 'selected' : '' }}>
                                    Networking</option>
                                <option value="Cables & Adapters"
                                    {{ request('category') == 'Cables & Adapters' ? 'selected' : '' }}>Cables &
                                    Adapters
                                </option>
                                <option value="Others" {{ request('category') == 'Others' ? 'selected' : '' }}>
                                    Others
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

                <div class="process-log">
                    <table class="process-table">
                        <thead>
                            <tr class="table-header">
                                <th>Inventory Id</th>
                                <th>Category</th>
                                <th>Device Name</th>
                                <th>Status</th>
                                <th>Condition</th>
                                <th style="width: 200px;">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($inventoryItems as $items)
                                <tr>
                                    <td>{{ $items->inventory_id }}</td>
                                    <td>{{ $items->category }}</td>
                                    <td>{{ $items->device_name }}</td>
                                    <td>
                                        @if ($items->status === 'available')
                                            <span class="inv-badge inv-status-available">Available</span>
                                        @elseif($items->status === 'issued')
                                            <span class="inv-badge inv-status-issued">Issued</span>
                                        @elseif($items->status === 'unusable')
                                            <span class="inv-badge inv-status-unusable">Unusable</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($items->condition === 'new')
                                            <span class="inv-badge inv-new">New</span>
                                        @elseif($items->condition === 'good')
                                            <span class="inv-badge inv-good">Good</span>
                                        @elseif($items->condition === 'fair')
                                            <span class="inv-badge inv-fair">Fair</span>
                                        @elseif($items->condition === 'poor')
                                            <span class="inv-badge inv-poor">Poor</span>
                                        @endif
                                    </td>
                                    <td class="action-buttons">
                                        <!-- View Units Modal Trigger -->
                                        <button type="button" class="view-btn" data-bs-toggle="modal"
                                            data-bs-target="#viewModal{{ $items->inventory_id }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <form action="{{ route('destroy-device', $items->inventory_id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-btn confirm-delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @include('modals.viewDetails', ['item' => $items])
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="custom-pagination">
                    {{ $inventoryItems->appends(request()->input())->links('pagination::bootstrap-5') }}
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
