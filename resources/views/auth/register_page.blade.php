@extends('layouts.guest')

@section('title', 'Register')

@section('content')
    {{-- Include the modal partial (keeps the same markup used in the login page) --}}
    @include('auth.register')

    {{-- Ensure the modal uses CSS visibility rules by adding the active class on page load --}}
    {{-- <script>
        window.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('registerModal');
            if (modal) modal.classList.add('active');
        });
    </script> --}}
@endsection
