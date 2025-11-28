@extends('layouts.default')

@section('content')
    <div class="receiving-container">
        <div class="layout-wrapper-main">
            <main class="receiving-main-panel">

                <div class="dashboard-container-main">
                    <h1>Dashboard</h1>
                    <div class="dashboard-container">
                        <div class="dashboard">
                            <div class="dashboard-status">
                                <div class="dashboard-header-top">
                                    <div class="dashboard-header-text">
                                        <h2><i class="fa-solid fa-print"></i> Printing</h2>
                                    </div>
                                </div>

                                <div class="card-grid">
                                    <div class="card pen">
                                        <a href="{{ route('status-filter', ['filter' => 'pending']) }}" class="text-decoration-none">
                                            <div class="in-cards pending">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Pending</p>
                                                        <h4> {{ $pending }} </h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-regular fa-clock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card inp">
                                        <a href="{{ route('status-filter', ['filter' => 'in_progress']) }}" class="text-decoration-none">
                                            <div class="in-cards  in_progress">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Ongoing</p>
                                                        <h4> {{ $in_progress }} </h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-spinner"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card prt">
                                        <a href="{{ route('status-filter', ['filter' => 'printed']) }}" class="text-decoration-none">
                                            <div class="in-cards printed">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Printed</p>
                                                        <h4> {{ $printed }} </h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-regular fa-circle-check"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card rel">
                                        <a href="{{ route('status-filter', ['filter' => 'released']) }}" class="text-decoration-none">
                                            <div class="in-cards released">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Released</p>
                                                        <h4> {{ $released }} </h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-box-open"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card cld">
                                        <a href="{{ route('status-filter', ['filter' => 'cancelled']) }}" class="text-decoration-none">
                                            <div class="in-cards cancelled">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Cancelled</p>
                                                        <h4> {{ $cancelled }} </h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-ban"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="dashboard-status">
                                <div class="dashboard-header-top">
                                    <div class="dashboard-header-text">
                                        <h2><i class="fa-solid fa-screwdriver-wrench"></i> Repair</h2>
                                    </div>
                                </div>

                                <div class="card-grid">
                                    <div class="card pen">
                                        <a href="{{ route('status-repair-filter', ['filter' => 'pending']) }}" class="text-decoration-none">
                                            <div class="in-cards pending">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Pending</p>
                                                        <h4> {{ $repair_pending }} </h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-regular fa-clock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card inp">
                                        <a href="{{ route('status-repair-filter', ['filter' => 'in_progress']) }}" class="text-decoration-none">
                                            <div class="in-cards in_progress">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Ongoing</p>
                                                        <h4> {{ $repair_in_progress }} </h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-spinner"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card rpr">
                                        <a href="{{ route('status-repair-filter', ['filter' => 'repaired']) }}" class="text-decoration-none">
                                            <div class="in-cards repaired">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Repaired</p>
                                                        <h4> {{ $repair_repaired }} </h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-regular fa-circle-check"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card rel">
                                        <a href="{{ route('status-repair-filter', ['filter' => 'released']) }}" class="text-decoration-none">
                                            <div class="in-cards released">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Released</p>
                                                        <h4> {{ $repair_released }} </h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-box-open"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card unr">
                                        <a href="{{ route('status-repair-filter', ['filter' => 'unrepairable']) }}" class="text-decoration-none">
                                            <div class="in-cards unrepaired">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Unrepairable</p>
                                                        <h4> {{ $repair_unrepairable }} </h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-ban"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                            




                        <div class="recent-activities">
                            <h2>Recent Activities</h2>
                            <div class="activities
                            

                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
