@extends('layouts.default')

@section('title', 'Add Entry')

@section('content')
<div class="disbursement-container">
    <div class="layout-wrapper">
        <!-- Main Content Area -->
        <!-- add printing ticket -->
        <main class="main-panel">
            <div class="content-placeholder header-row">
                <div class="header-top">
                    <div class="header-text">
                        <h2>Add Printing Ticket</h2>
                    </div>
                </div>
            </div>
                <!-- Show success or error message -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="content-placeholder">
                <!-- Form to add a new process -->
                
                <form action="{{ route('process.store') }}" method="POST" class="process-form">
                    @csrf
                    
                    <input type="hidden" name="type" value="{{ $type }}">
                
                    <div class="form-group">
                        <label for="process_id">Ticket ID</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="text" id="process_id_display" class="form-control" placeholder="Click 'Generate'" readonly>
                            <input type="hidden" name="process_id" id="process_id">
                            <button type="button" onclick="generateProcessId()" class="btn btn-secondary btn-generate-id">Generate</button>
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label for="receiving_date">Receiving Date</label>
                        <input type="date" name="receiving_date" id="receiving_date" class="form-control" required>
                    </div>
                
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category" id="category" class="form-control" required>
                            <option value="category1">Category 1</option>
                            <option value="category2">Category 2</option>
                            <option value="category3">Category 3</option>
                        </select>
                    </div>
                
                    <button type="submit" class="btn btn-primary">Save Process</button>
                </form>
            </div>
        </main>
    </div>
</div>
<script>
function generateProcessId() {
    const button = document.querySelector('.btn-generate-id');
    button.disabled = true;
    button.textContent = 'Generating...';

    fetch("{{ route('generate.process.id') }}")
        .then(response => response.json())
        .then(data => {
            document.getElementById('process_id_display').value = data.process_id;
            document.getElementById('process_id').value = data.process_id;
            button.textContent = 'Generated';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to generate ID. Please try again.');
            button.disabled = false;
            button.textContent = 'Generate';
        });
}
</script>
@endsection