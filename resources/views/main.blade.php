@extends('layouts.guest')

@section('content')
<div class="main-page d-flex justify-content-center align-items-center min-vh-100">
    <div class="container text-center">
        <h1 class="mb-5">Welcome to the Dashboard</h1>

        <div class="row justify-content-center">
            <!-- Printing -->
            <div class="col-md-3 mb-4">
                <a href="{{ route('printing') }}" class="text-decoration-none">
                    <div class="card p-4 shadow-sm section-card">
                        <h3 class="text-primary">Printing</h3>
                        <p class="text-muted">Start recording printing items here.</p>
                    </div>
                </a>
            </div>

            <!-- Repair -->
            <div class="col-md-3 mb-4">
                <a href="{{ route('receiving') }}" class="text-decoration-none">
                    <div class="card p-4 shadow-sm section-card">
                        <h3 class="text-primary">Repair</h3>
                        <p class="text-muted">Start recording repair items here.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
