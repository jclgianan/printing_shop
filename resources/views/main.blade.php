@extends('layouts.default')

@section('content')
<div class="receiving-container">
    <div class="layout-wrapper">
        <main class="receiving-main-panel">
            <div class="dashboard">
                <div class="header-top">
                    <div class="header-text">
                        <h2 class="section-heading"><i class="fa-solid fa-print"></i> Printing Dashboard</h2>
                    </div>
                </div>

                <div class="stats">
                    <div class="opts">
                        <a href="{{ route('main') }}" class="text-decoration-none">
                            <div class="card p-4 section-card">
                                <p>Pending</p>
                                <h4> {{$pending}} </h4>
                            </div>
                        </a>
                    </div>

                    <div class="opts">
                        <a href="{{ route('main') }}" class="text-decoration-none">
                            <div class="card p-4 section-card">
                                <p>Ongoing</p>
                                <h4> {{$in_progress}} </h4>
                            </div>
                        </a>
                    </div>

                    <div class="opts">
                        <a href="{{ route('main') }}" class="text-decoration-none">
                            <div class="card p-4 section-card">
                                <p>Printed</p>
                                <h4> {{$printed}} </h4>
                            </div>
                        </a>
                    </div>

                    <div class="opts">
                        <a href="{{ route('main') }}" class="text-decoration-none">
                            <div class="card p-4 section-card">
                                <p>Released</p>
                                <h4> {{$released}} </h4>
                            </div>
                        </a>
                    </div>

                    <div class="opts">
                        <a href="{{ route('main') }}" class="text-decoration-none">
                            <div class="card p-4 section-card">
                                <p>Cancelled</p>
                                <h4> {{$cancelled}} </h4>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="dashboard" >
                <div class="header-top">
                    <div class="header-text">
                        <h2 class="section-heading"><i class="fa-solid fa-screwdriver-wrench"></i> Repair Dashboard</h2>
                    </div>
                </div>
                
                <div class="stats">
                    <div class="opts">
                        <a href="{{ route('printing') }}" class="text-decoration-none">
                            <div class="card p-4 section-card">
                                <p>Pending</p>
                                <h4> {{$repair_pending}} </h4>
                            </div>
                        </a>
                    </div>

                    <div class="opts">
                        <a href="{{ route('repair') }}" class="text-decoration-none">
                            <div class="card p-4 section-card">
                                <p>Ongoing</p>
                                <h4> {{$repair_in_progress}} </h4>
                            </div>
                        </a>
                    </div>

                    <div class="opts">
                        <a href="{{ route('repair') }}" class="text-decoration-none">
                            <div class="card p-4 section-card">
                                <p>Repaired</p>
                                <h4> {{$repair_repaired}} </h4>
                            </div>
                        </a>
                    </div>

                    <div class="opts">
                        <a href="{{ route('repair') }}" class="text-decoration-none">
                            <div class="card p-4 section-card">
                                <p>Released</p>
                                <h4> {{$repair_released}} </h4>
                            </div>
                        </a>
                    </div>

                    <div class="opts">
                        <a href="{{ route('repair') }}" class="text-decoration-none">
                            <div class="card p-4 section-card">
                                <p>Unrepairable</p>
                                <h4> {{$repair_unrepairable}} </h4>
                            </div>
                        </a>
                    </div>
                </div>
                
            </div>
        </main>
    </div>
</div>
@endsection
