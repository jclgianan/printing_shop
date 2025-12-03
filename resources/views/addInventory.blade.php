@extends('layouts.default')

@section('title', 'Add Inventory Item')

@section('content')
<div class="receiving-container">
    <div class="layout-wrapper">
        <main class="receiving-main-panel">
            <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                        <h1 class="mb-0">Add New Device</h1>
                        <a href="{{ route('inventory') }}" class="btn btn-secondary">
                            ← Back to Inventory
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="process-log">
                        <div class="card-body">
                            <form action="{{ route('inventory.store') }}" method="POST">
                                @csrf

                                <!-- Device Identification Section -->
                                <h5 class="mb-3">Device Identification</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="device_id" class="form-label">Device ID <span class="text-danger">*</span></label>
                                        <input type="text" 
                                            class="form-control @error('device_id') is-invalid @enderror" 
                                            id="device_id" 
                                            name="device_id" 
                                            value="{{ old('device_id') }}"
                                            placeholder="e.g., LAPTOP-001"
                                            required>
                                        <small class="text-muted">Groups same device types together</small>
                                        @error('device_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="individual_id" class="form-label">Individual ID <span class="text-danger">*</span></label>
                                        <input type="text" 
                                            class="form-control @error('individual_id') is-invalid @enderror" 
                                            id="individual_id" 
                                            name="individual_id" 
                                            value="{{ old('individual_id') }}"
                                            placeholder="e.g., LAPTOP-001-A"
                                            required>
                                        <small class="text-muted">Unique serial number or asset tag</small>
                                        @error('individual_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="device_name" class="form-label">Device Name <span class="text-danger">*</span></label>
                                        <input type="text" 
                                            class="form-control @error('device_name') is-invalid @enderror" 
                                            id="device_name" 
                                            name="device_name" 
                                            value="{{ old('device_name') }}"
                                            placeholder="e.g., Dell XPS 15"
                                            required>
                                        @error('device_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                        <select class="form-select @error('category') is-invalid @enderror" 
                                                id="category" 
                                                name="category" 
                                                required>
                                            <option value="">Select Category</option>
                                            <option value="Computer System" {{ old('category') == 'Computer System' ? 'selected' : '' }}>Computer System</option>
                                            <option value="Components" {{ old('category') == 'Components' ? 'selected' : '' }}>Components</option>
                                            <option value="Peripherals" {{ old('category') == 'Peripherals' ? 'selected' : '' }}>Peripherals</option>
                                            <option value="Networking" {{ old('category') == 'Networking' ? 'selected' : '' }}>Networking</option>
                                            <option value="Storage" {{ old('category') == 'Storage' ? 'selected' : '' }}>Storage</option>
                                            <option value="Others" {{ old('category') == 'Others' ? 'selected' : '' }}>Others</option>
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Specifications Section -->
                                <h5 class="mb-3">Specifications (Optional - for PCs)</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="processor" class="form-label">Processor</label>
                                        <input type="text" 
                                            class="form-control" 
                                            id="processor" 
                                            name="processor" 
                                            value="{{ old('processor') }}"
                                            placeholder="e.g., Intel Core i7-11800H">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="ram" class="form-label">RAM</label>
                                        <input type="text" 
                                            class="form-control" 
                                            id="ram" 
                                            name="ram" 
                                            value="{{ old('ram') }}"
                                            placeholder="e.g., 16GB DDR4">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="storage" class="form-label">Storage</label>
                                        <input type="text" 
                                            class="form-control" 
                                            id="storage" 
                                            name="storage" 
                                            value="{{ old('storage') }}"
                                            placeholder="e.g., 512GB SSD">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="graphics_card" class="form-label">Graphics Card</label>
                                        <input type="text" 
                                            class="form-control" 
                                            id="graphics_card" 
                                            name="graphics_card" 
                                            value="{{ old('graphics_card') }}"
                                            placeholder="e.g., NVIDIA RTX 3060">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="other_specs" class="form-label">Other Specifications</label>
                                    <textarea class="form-control" 
                                            id="other_specs" 
                                            name="other_specs" 
                                            rows="3"
                                            placeholder="Any additional specifications...">{{ old('other_specs') }}</textarea>
                                </div>

                                <hr class="my-4">

                                <!-- Status and Condition Section -->
                                <h5 class="mb-3">Status & Condition</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" 
                                                id="status" 
                                                name="status" 
                                                required>
                                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                            <option value="issued" {{ old('status') == 'issued' ? 'selected' : '' }}>Issued</option>
                                            <option value="damaged" {{ old('status') == 'unusable' ? 'selected' : '' }}>Unusable</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="condition" class="form-label">Condition <span class="text-danger">*</span></label>
                                        <select class="form-select @error('condition') is-invalid @enderror" 
                                                id="condition" 
                                                name="condition" 
                                                required>
                                            <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New</option>
                                            <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>Good</option>
                                            <option value="fair" {{ old('condition') == 'fair' ? 'selected' : '' }}>Fair</option>
                                            <option value="poor" {{ old('condition') == 'poor' ? 'selected' : '' }}>Poor</option>
                                        </select>
                                        @error('condition')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Assignment Information Section -->
                                <h5 class="mb-3">Assignment Information</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="issued_to" class="form-label">Issued To</label>
                                        <input type="text" 
                                            class="form-control" 
                                            id="issued_to" 
                                            name="issued_to" 
                                            value="{{ old('issued_to') }}"
                                            placeholder="Employee name">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="office" class="form-label">Office/Location</label>
                                        <input type="text" 
                                            class="form-control" 
                                            id="office" 
                                            name="office" 
                                            value="{{ old('office') }}"
                                            placeholder="e.g., IT Department, 3rd Floor">
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Dates Section -->
                                <h5 class="mb-3">Important Dates</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="date_acquired" class="form-label">Date Acquired</label>
                                        <input type="date" 
                                            class="form-control" 
                                            id="date_acquired" 
                                            name="date_acquired" 
                                            value="{{ old('date_acquired') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="date_issued" class="form-label">Date Issued</label>
                                        <input type="date" 
                                            class="form-control" 
                                            id="date_issued" 
                                            name="date_issued" 
                                            value="{{ old('date_issued') }}">
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Notes Section -->
                                <h5 class="mb-3">Additional Information</h5>
                                <div class="mb-4">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control" 
                                            id="notes" 
                                            name="notes" 
                                            rows="4"
                                            placeholder="Any additional notes or remarks...">{{ old('notes') }}</textarea>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle"></i> Add Device
                                    </button>
                                    <a href="{{ route('inventory') }}" class="btn btn-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
        </main>
        

    </div>
</div>

<script>
    // Auto-fill individual_id based on device_id
    document.getElementById('device_id').addEventListener('input', function() {
        const deviceId = this.value;
        const individualIdField = document.getElementById('individual_id');
        
        if (deviceId && !individualIdField.value) {
            individualIdField.placeholder = `e.g., ${deviceId}-A`;
        }
    });

    // Show/hide issued_to field based on status
    document.getElementById('status').addEventListener('change', function() {
        const issuedToField = document.getElementById('issued_to').closest('.col-md-6');
        const dateIssuedField = document.getElementById('date_issued').closest('.col-md-4');
        
        if (this.value === 'issued') {
            issuedToField.style.display = 'block';
            dateIssuedField.style.display = 'block';
        }
    });
</script>
@endsection