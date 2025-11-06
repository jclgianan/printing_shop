@extends('layouts.guest')

@section('title', 'Register')

@section('content')
	{{-- Include the register modal partial so layout assets are loaded --}}
	@include('auth.register')

	{{-- Ensure the modal is shown using CSS rules (adds .active) --}}
	<script>
		window.addEventListener('DOMContentLoaded', function () {
			const modal = document.getElementById('registerModal');
			if (modal) modal.classList.add('active');
		});
	</script>
@endsection
