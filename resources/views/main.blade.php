@extends('layouts.default')

@section('content')
    <div class="receiving-container">
        <div class="layout-wrapper-main">
            <main class="receiving-main-panel">

                <div class="dashboard-container-main">
                    <h1>Dashboard</h1>
                    <div class="dashboard-container">
                        <div class="dashboard">
                            <div class="dashboard-header-top">
                                <div class="dashboard-header-text">
                                    <h2><i class="fa-solid fa-print"></i> Printing</h2>
                                </div>
                            </div>

                            <div class="card-grid">
                                <div class="card pen">
                                    <a href="{{ route('main') }}" class="text-decoration-none">
                                        <div class="in-cards pending">
                                            <p>Pending</p>
                                            <h4> {{ $pending }} </h4>
                                        </div>
                                    </a>
                                </div>

                                <div class="card inp">
                                    <a href="{{ route('main') }}" class="text-decoration-none">
                                        <div class="in-cards  in_progress">
                                            <p>Ongoing</p>
                                            <h4> {{ $in_progress }} </h4>
                                        </div>
                                    </a>
                                </div>

                                <div class="card prt">
                                    <a href="{{ route('main') }}" class="text-decoration-none">
                                        <div class="in-cards printed">
                                            <p>Printed</p>
                                            <h4> {{ $printed }} </h4>
                                        </div>
                                    </a>
                                </div>

                                <div class="card rel">
                                    <a href="{{ route('main') }}" class="text-decoration-none">
                                        <div class="in-cards released">
                                            <p>Released</p>
                                            <h4> {{ $released }} </h4>
                                        </div>
                                    </a>
                                </div>

                                <div class="card cld">
                                    <a href="{{ route('main') }}" class="text-decoration-none">
                                        <div class="in-cards cancelled">
                                            <p>Cancelled</p>
                                            <h4> {{ $cancelled }} </h4>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>




                        <div class="dashboard">
                            <div class="dashboard-header-top">
                                <div class="dashboard-header-text">
                                    <h2><i class="fa-solid fa-screwdriver-wrench"></i> Repair</h2>
                                </div>
                            </div>

                            <div class="card-grid">
                                <div class="card pen">
                                    <a href="{{ route('repair') }}" class="text-decoration-none">
                                        <div class="in-cards pending">
                                            <p>Pending</p>
                                            <h4> {{ $repair_pending }} </h4>
                                        </div>
                                    </a>
                                </div>

                                <div class="card inp">
                                    <a href="{{ route('repair') }}" class="text-decoration-none">
                                        <div class="in-cards in_progress">
                                            <p>Ongoing</p>
                                            <h4> {{ $repair_in_progress }} </h4>
                                        </div>
                                    </a>
                                </div>

                                <div class="card rpr">
                                    <a href="{{ route('repair') }}" class="text-decoration-none">
                                        <div class="in-cards repaired">
                                            <p>Repaired</p>
                                            <h4> {{ $repair_repaired }} </h4>
                                        </div>
                                    </a>
                                </div>

                                <div class="card rel">
                                    <a href="{{ route('repair') }}" class="text-decoration-none">
                                        <div class="in-cards released">
                                            <p>Released</p>
                                            <h4> {{ $repair_released }} </h4>
                                        </div>
                                    </a>
                                </div>

                                <div class="card unr">
                                    <a href="{{ route('repair') }}" class="text-decoration-none">
                                        <div class="in-cards unrepaired">
                                            <p>Unrepairable</p>
                                            <h4> {{ $repair_unrepairable }} </h4>
                                        </div>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
