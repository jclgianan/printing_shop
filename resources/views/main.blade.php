@extends('layouts.guest')

@section('content')
<div class="main-page-container">
    <div class="main-page">
        <div class="container text-center">
            <h1 class="mb-5">Welcome to the Secret Shop!</h1>

            <div class="row justify-content-center">
                <!-- Printing -->
                <div class="opts col-md-5 mb-4">
                    <a href="{{ route('printing') }}" class="text-decoration-none">
                        <div class="card p-4 section-card">
                            <h3><i class="fa-solid fa-print fa-xs"></i> Printing <i class="fa-solid fa-print fa-xs"></i></h3>
                            <p>Start recording printing items.</p>
                        </div>
                    </a>
                </div>

                <!-- Repair -->
                <div class="opts col-md-5 mb-4">
                    <a href="{{ route('repair') }}" class="text-decoration-none">
                        <div class="card p-4 section-card">
                            <h3><i class="fa-solid fa-screwdriver-wrench fa-xs"></i> Repair <i class="fa-solid fa-screwdriver-wrench fa-xs"></i></h3>
                            <p>Start recording repair items.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
