<div id="editMode{{ $item->id }}" tabindex="-1" class="modal fade">
    <form action="{{ route('inventory.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="modal-body">

            <!-- Specifications (Editable) -->
            <h6 class="mb-3">Specifications (Editable)</h6>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="editProcessor{{ $item->id }}" class="form-label">Processor</label>
                    <input type="text" class="form-control" id="editProcessor{{ $item->id }}" name="processor" value="{{ $item->processor }}" placeholder="e.g., Intel Core i7-11800H">
                </div>

                <div class="col-md-6">
                    <label for="editRam{{ $item->id }}" class="form-label">RAM</label>
                    <input type="text" class="form-control" id="editRam{{ $item->id }}" name="ram" value="{{ $item->ram }}" placeholder="e.g., 16GB DDR4">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="editStorage{{ $item->id }}" class="form-label">Storage</label>
                    <input type="text" class="form-control" id="editStorage{{ $item->id }}" name="storage" value="{{ $item->storage }}" placeholder="e.g., 512GB SSD">
                </div>

                <div class="col-md-6">
                    <label for="editGraphicsCard{{ $item->id }}" class="form-label">Graphics Card</label>
                    <input type="text" class="form-control" id="editGraphicsCard{{ $item->id }}" name="graphics_card" value="{{ $item->graphics_card }}" placeholder="e.g., NVIDIA RTX 3060">
                </div>
            </div>

            <div class="mb-3">
                <label for="editOtherSpecs{{ $item->id }}" class="form-label">Other Specifications</label>
                <textarea class="form-control" id="editOtherSpecs{{ $item->id }}" name="other_specs" rows="2" placeholder="Any additional specifications...">{{ $item->other_specs }}</textarea>
            </div>

            <hr>

            <!-- Status & Condition (Editable) -->
            <h6 class="mb-3">Status & Condition</h6>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="editStatus{{ $item->id }}" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" id="editStatus{{ $item->id }}" name="status" required>
                        <option value="available" {{ $item->status === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="issued" {{ $item->status === 'issued' ? 'selected' : '' }}>Issued</option>
                        <option value="unusable" {{ $item->status === 'unusable' ? 'selected' : '' }}>Unusable</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="editCondition{{ $item->id }}" class="form-label">Condition <span class="text-danger">*</span></label>
                    <select class="form-select" id="editCondition{{ $item->id }}" name="condition" required>
                        <option value="new" {{ $item->condition === 'new' ? 'selected' : '' }}>New</option>
                        <option value="good" {{ $item->condition === 'good' ? 'selected' : '' }}>Good</option>
                        <option value="fair" {{ $item->condition === 'fair' ? 'selected' : '' }}>Fair</option>
                        <option value="poor" {{ $item->condition === 'poor' ? 'selected' : '' }}>Poor</option>
                    </select>
                </div>
            </div>

            <!-- Assignment Information (Editable, conditional) -->
            <div id="editAssignmentSection{{ $item->id }}" style="display: {{ $item->status === 'issued'}};">
                <hr>
                <h6 class="mb-3">Assignment Information</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="editIssuedTo{{ $item->id }}" class="form-label">Issued To</label>
                        <input type="text" class="form-control" id="editIssuedTo{{ $item->id }}" name="issued_to" value="{{ $item->issued_to }}" placeholder="Employee name">
                    </div>

                    <div class="col-md-6">
                        <label for="editOffice{{ $item->id }}" class="form-label">Office/Location</label>
                        <input type="text" class="form-control" id="editOffice{{ $item->id }}" name="office" value="{{ $item->office }}" placeholder="e.g., IT Department">
                    </div>
                </div>
            </div>

            <hr>

            <!-- Dates (Editable) -->
            <h6 class="mb-3">Dates</h6>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="editDateAcquired{{ $item->id }}" class="form-label">Date Acquired</label>
                    <input type="date" class="form-control" id="editDateAcquired{{ $item->id }}" name="date_acquired" value="{{ $item->date_acquired ? $item->date_acquired->format('Y-m-d') : '' }}">
                </div>

                <div class="col-md-4" id="editDateIssuedField{{ $item->id }}" style="display: {{ $item->status === 'issued'}};">
                    <label for="editDateIssued{{ $item->id }}" class="form-label">Date Issued</label>
                    <input type="date" class="form-control" id="editDateIssued{{ $item->id }}" name="date_issued" value="{{ $item->date_issued ? $item->date_issued->format('Y-m-d') : '' }}">
                </div>

                @if($item->warranty_expiration)
                <div class="col-md-4">
                    <label for="editWarrantyExp{{ $item->id }}" class="form-label">Warranty Expires</label>
                    <input type="date" class="form-control" id="editWarrantyExp{{ $item->id }}" name="warranty_expiration" value="{{ $item->warranty_expiration->format('Y-m-d') }}">
                </div>
                @endif
            </div>

            <hr>

            <!-- Notes (Editable) -->
            <h6 class="mb-3">Notes</h6>
            <div class="mb-3">
                <textarea class="form-control" name="notes" rows="3" placeholder="Any additional notes...">{{ $item->notes }}</textarea>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="toggleEditMode{{ $item->id }}()">
                <i class="bi bi-x-circle"></i> Cancel
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Save Changes
            </button>
        </div>
    </form>
</div>