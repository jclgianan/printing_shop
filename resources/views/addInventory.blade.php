@extends('layouts.default')

@section('title', 'Add Inventory Item')

@section('content')
    <div class="receiving-container">
        <div class="layout-wrapper">
            <main class="receiving-main-panel">
                <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                    <h1 class="mb-0">Add New Device</h1>
                    <a href="{{ route('inventory') }}" class="btn-normal">
                        <i class="fa-solid fa-angles-left"></i> Back to Inventory
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
                                <div class="col-md-4">
                                    <label for="inventory_id" class="form-label">Inventory ID <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control @error('inventory_id') is-invalid @enderror"
                                            id="inventory_id" name="inventory_id" value="{{ old('inventory_id') }}"
                                            placeholder="Auto-generated" readonly required>
                                        <button type="button" class="btn btn-secondary btn-generate-id"
                                            id="generateInventoryId">
                                            <i class="bi bi-arrow-repeat"></i> Generate
                                        </button>
                                    </div>
                                    <small class="text-muted">Click Generate to create a unique Inventory ID</small>
                                    @error('inventory_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <label for="quantity" class="form-label">Quantity <span
                                            class="text-danger">*</span></label>
                                    <div class="button-counter-container d-flex align-items-center">
                                        <button class="minus-btn" type="button"><i
                                                class="fa-solid fa-minus fa-xs"></i></button>
                                        <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                            id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1"
                                            max="1000" required>
                                        <button class="plus-btn" type="button"><i
                                                class="fa-solid fa-plus fa-xs"></i></button>
                                    </div>
                                    <small class="text-muted">Number of devices</small>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="col-md-4">
                                    <label class="form-label">Individual IDs Preview</label>
                                    <div class="form-control bg-light" style="min-height: 38px;" id="individualIdPreview"
                                        aria-placeholder="123">
                                        <small class="text-muted">Generate Device ID first</small>
                                    </div>
                                    <small class="text-muted">Auto-generated based on quantity</small>
                                </div> --}}
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="device_name" class="form-label">Device Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('device_name') is-invalid @enderror"
                                        id="device_name" name="device_name" value="{{ old('device_name') }}"
                                        placeholder="e.g., Dell XPS 15" required>
                                    @error('device_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="category" class="form-label">Category <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('category') is-invalid @enderror" id="category"
                                        name="category" required>
                                        <option value="">Select Category</option>
                                        <option value="Computer System"
                                            {{ old('category') == 'Computer System' ? 'selected' : '' }}>Computer System
                                        </option>
                                        <option value="Components" {{ old('category') == 'Components' ? 'selected' : '' }}>
                                            Components</option>
                                        <option value="Peripherals"
                                            {{ old('category') == 'Peripherals' ? 'selected' : '' }}>Peripherals</option>
                                        <option value="Networking" {{ old('category') == 'Networking' ? 'selected' : '' }}>
                                            Networking</option>
                                        <option value="Cables & Adapters"
                                            {{ old('category') == 'Cables & Adapters' ? 'selected' : '' }}>Cables &
                                            Adapters</option>
                                        <option value="Others" {{ old('category') == 'Others' ? 'selected' : '' }}>Others
                                        </option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-3">

                            <div id="Specifications">
                                <!-- Specifications Section -->
                                <h5 class="mb-3">Specifications (Optional - for PCs)</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="processor" class="form-label">Processor</label>
                                        <input type="text" class="form-control" id="processor" name="processor"
                                            value="{{ old('processor') }}" placeholder="e.g., Intel Core i7-11800H">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="ram" class="form-label">RAM</label>
                                        <input type="text" class="form-control" id="ram" name="ram"
                                            value="{{ old('ram') }}" placeholder="e.g., 16GB DDR4">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="storage" class="form-label">Storage</label>
                                        <input type="text" class="form-control" id="storage" name="storage"
                                            value="{{ old('storage') }}" placeholder="e.g., 512GB SSD">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="graphics_card" class="form-label">Graphics Card</label>
                                        <input type="text" class="form-control" id="graphics_card"
                                            name="graphics_card" value="{{ old('graphics_card') }}"
                                            placeholder="e.g., NVIDIA RTX 3060">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="other_specs" class="form-label">Other Specifications</label>
                                    <textarea class="form-control" id="other_specs" name="other_specs" rows="3"
                                        placeholder="Any additional specifications...">{{ old('other_specs') }}</textarea>
                                </div>

                                <hr class="my-3">
                            </div>

                            <!-- Status and Condition Section -->
                            <h5 class="mb-3">Status & Condition</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="statusSelect" class="form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="statusSelect"
                                        name="status" required>
                                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>
                                            Available</option>
                                        <option value="issued" {{ old('status') == 'issued' ? 'selected' : '' }}>Issued
                                        </option>
                                        <option value="unusable" {{ old('status') == 'unusable' ? 'selected' : '' }}>
                                            Unusable</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="condition" class="form-label">Condition <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('condition') is-invalid @enderror" id="condition"
                                        name="condition" required>
                                        <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New
                                        </option>
                                        <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>Good
                                        </option>
                                        <option value="fair" {{ old('condition') == 'fair' ? 'selected' : '' }}>Fair
                                        </option>
                                        <option value="poor" {{ old('condition') == 'poor' ? 'selected' : '' }}>Poor
                                        </option>
                                    </select>
                                    @error('condition')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-3">

                            <div id="assignmentSection">
                                <!-- Assignment Information Section -->
                                <h5 class="mb-3">Assignment Information</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="issued_to" class="form-label">Issued To</label>
                                        <input type="text" class="form-control" id="issued_to" name="issued_to"
                                            value="{{ old('issued_to') }}" placeholder="Employee name">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="office" class="form-label">Office/Location</label>
                                        <input type="text" class="form-control" id="office" name="office"
                                            value="{{ old('office') }}" placeholder="e.g., IT Department, 3rd Floor">
                                    </div>
                                </div>

                                <hr class="my-3">
                            </div>

                            <!-- Dates Section -->
                            <h5 class="mb-3">Important Dates</h5>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="date_acquired" class="form-label">Date Acquired</label>
                                    <input type="date" class="form-control" id="date_acquired" name="date_acquired"
                                        value="{{ old('date_acquired') }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="date_issued" class="form-label">Date Issued</label>
                                    <input type="date" class="form-control" id="date_issued" name="date_issued"
                                        value="{{ old('date_issued') }}">
                                </div>
                            </div>

                            <hr class="my-3">

                            <!-- Notes Section -->
                            <h5 class="mb-3">Additional Information</h5>
                            <div class="mb-4">
                                <textarea class="form-control" id="notes" name="notes" rows="4"
                                    placeholder="Any additional notes or remarks...">{{ old('notes') }}</textarea>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="ad-btn-container">
                                <a href="{{ route('inventory') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                                <button type="submit" class="btn-normal btn-primary">
                                    <i class="bi bi-check-circle"></i> Add Device(s)
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Generate Device ID
        document.getElementById('generateInventoryId').addEventListener('click', async function() {
            try {
                const categorySelect = document.getElementById('category');
                const inventoryInput = document.getElementById('inventory_id');
                const button = document.querySelector('.btn-generate-id');

                if (!categorySelect || !categorySelect.value) {
                    alert('Please select a category first.');
                    return;
                }

                const response = await fetch(
                    '{{ route('generate-inventory-id') }}?category=' + encodeURIComponent(categorySelect
                        .value)
                );

                const data = await response.json();

                if (data.inventory_id) {
                    inventoryInput.value = data.inventory_id;

                    // Optional: update preview if you have one
                    if (typeof updateIndividualIdPreview === 'function') {
                        updateIndividualIdPreview();
                    }

                    button.remove();
                }
            } catch (error) {
                console.error('Error generating Inventory ID:', error);
                alert('Failed to generate Inventory ID.');
            }
        });

        // Update Individual ID Preview when quantity changes
        // document.getElementById('quantity').addEventListener('input', updateIndividualIdPreview);

        // function updateIndividualIdPreview() {
        //     const deviceId = document.getElementById('device_id').value;
        //     const quantity = parseInt(document.getElementById('quantity').value) || 1;
        //     const previewDiv = document.getElementById('individualIdPreview');
        //     if (!deviceId) {
        //         previewDiv.innerHTML = '<small class="text-muted">Generate Device ID first</small>';
        //         return;
        //     }

        //     let previewText = '';
        //     const maxPreview = 5; // Show max 5 examples

        //     for (let i = 1; i <= Math.min(quantity, maxPreview); i++) {
        //         const individualId = `${deviceId}(${String(i).padStart(2, '0')})`;
        //         previewText += `<span class="badge bg-secondary me-1 mb-1">${individualId}</span>`;
        //     }

        //     if (quantity > maxPreview) {
        //         previewText += `<span class="text-muted">... and ${quantity - maxPreview} more</span>`;
        //     }

        //     previewDiv.innerHTML = previewText;
        // }

        // Show/hide issued_to and date_issued fields based on status
        document.getElementById('statusSelect').addEventListener('change', function() {
            const assignmentSection = document.getElementById('assignmentSection');
            const dateIssuedField = document.getElementById('date_issued').closest('.col-md-4');

            if (this.value === 'issued') {
                assignmentSection.style.display = 'block';
                dateIssuedField.style.display = 'block';
            } else {
                assignmentSection.style.display = 'none';
                dateIssuedField.style.display = 'none';
            }
        });

        // Initialize visibility on page load
        window.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('statusSelect');
            const assignmentSection = document.getElementById('assignmentSection');
            const dateIssuedField = document.getElementById('date_issued').closest('.col-md-4');

            const categorySelect = document.getElementById('category');
            const specificationsSection = document.getElementById('Specifications');

            // Hide by default if status is not 'issued'
            if (statusSelect.value !== 'issued') {
                assignmentSection.style.display = 'none';
                dateIssuedField.style.display = 'none';
            }

            // Hide by default if status is not 'issued'
            if (statusSelect.value !== 'Computer System') {
                specificationsSection.style.display = 'none';
            }

        });

        // Show/hide issued_to and date_issued fields based on status
        document.getElementById('category').addEventListener('change', function() {
            const specificationsSection = document.getElementById('Specifications');

            if (this.value === 'Computer System') {
                specificationsSection.style.display = 'block';
            } else {
                specificationsSection.style.display = 'none';
            }
        });

        // Generate Device ID on page load if empty
        // window.addEventListener('DOMContentLoaded', function() {
        //     if (!document.getElementById('device_id').value) {
        //         document.getElementById('generateDeviceId').click();
        //     }
        // });

        //counter
        const display = document.getElementById('quantity');
        const plusBtn = document.querySelector('.plus-btn');
        const minusBtn = document.querySelector('.minus-btn');

        // let count = 1;
        let count = parseInt(display.value);

        plusBtn.addEventListener('click', () => {
            count++;
            display.value = count;

            display.dispatchEvent(new Event('input', {
                bubbles: true
            }));
        });

        minusBtn.addEventListener('click', () => {
            if (count > 1) {
                count--;
                display.value = count;

                display.dispatchEvent(new Event('input', {
                    bubbles: true
                }));
            }
        });

        // Auto-set condition to 'poor' if status is 'unusable'
        const addStatus = document.getElementById('statusSelect');
        const addCondition = document.getElementById('condition');

        addStatus.addEventListener('change', function() {
            if (this.value === 'unusable') {
                addCondition.value = 'poor'; // auto set to poor
                addCondition.style.backgroundColor = '#e9ecef';
                conditionSelect.style.pointerEvents = 'none';
            } else {
                addCondition.disabled = false;
                conditionSelect.style.backgroundColor = '';
                conditionSelect.style.pointerEvents = '';
            }
        });
    </script>
@endsection
