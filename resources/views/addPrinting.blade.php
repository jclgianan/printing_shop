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
                
                <form action="{{ route('printTicket.store', ['type' => 'addPrinting']) }}" method="POST" class="process-form">
                    @csrf
                    
                    <input type="hidden" name="type" value="{{ $type }}">
                
                    <div class="form-group">
                        <label for="printTicket_id">Ticket ID</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="text" id="printTicket_id_display" class="form-control" placeholder="Click 'Generate'" readonly>
                            <input type="hidden" name="printTicket_id" id="printTicket_id">
                            <button type="button" onclick="generateprintTicketId()" class="btn btn-secondary btn-generate-id">Generate</button>
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label for="receiving_date">Receiving Date</label>
                        <input type="date" name="receiving_date" id="receiving_date" class="form-control @error('receiving_date') is-invalid @enderror" 
                            value="{{ old('receiving_date') }}" required>
                        @error('receiving_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                            value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="office_department">Office/Department</label>
                        <input type="text" name="office_department" id="office_department" class="form-control @error('office_department') is-invalid @enderror" 
                            value="{{ old('office_department') }}" required>
                        @error('office_department')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="itemname">Name of Item</label>
                        <input type="text" name="itemname" id="itemname" class="form-control @error('itemname') is-invalid @enderror" 
                            value="{{ old('itemname') }}" required>
                        @error('itemname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>                                                        
                    <div class="form-group">
                        <label for="size">Size</label>
                        <input type="text" name="size" id="size" class="form-control @error('size') is-invalid @enderror" 
                            value="{{ old('size') }}" required>
                        @error('size')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>                    
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" 
                            value="{{ old('quantity') }}" min="1" required>
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                 <br>
                    <button type="submit" class="btn btn-primary">Submit Ticket</button>
                </form>
            </div>
        </main>
    </div>
</div>
<script>
function generateprintTicketId() {
    const button = document.querySelector('.btn-generate-id');
    button.disabled = true;
    button.textContent = 'Generating...';

    fetch("{{ route('generate.printTicket.id') }}")
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            document.getElementById('printTicket_id_display').value = data.printTicket_id;
            document.getElementById('printTicket_id').value = data.printTicket_id;
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