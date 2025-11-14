@extends('layouts.default') {{-- Main layout --}}

@section('title', 'Add User')

@section('content')
<div class="receiving-container">
    <div class="layout-wrapper">
        <main class="receiving-main-panel">
            <div class="content-placeholder header-row">
                <div class="header-top">
                    <div class="header-text">
                        <h2 class="section-heading">Add New User</h2>
                        <p class="section-description">Select an option from the menu to get started.</p>
                    </div>
                </div>
            </div>

            <div class="logs-bottomBar">
                @include('auth.register')
            </div>
        </main>
    </div>
</div>
@endsection
