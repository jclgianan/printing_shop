<div class="modal fade" id="addUnitModal" tabindex="-1" aria-labelledby="addUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUnitModalLabel">Add New Unit(s) to {{ $items->first()->device_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('inventory.add-units', $deviceId) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Hidden field for device_id -->
                    <input type="hidden" name="device_id" value="{{ $deviceId }}">

                    <!-- Device Info Display -->
                    <div class="alert alert-info mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Device:</strong> {{ $items->first()->device_name }}<br>
                                <strong>Device ID:</strong> {{ $deviceId }}<br>
                                <strong>Category:</strong> {{ $items->first()->category }}
                            </div>
                            <div class="col-md-6">
                                <strong>Current Units:</strong> {{ $items->count() }}<br>
                                @if($items->first()->processor)
                                    <strong>Processor:</strong> {{ $items->first()->processor }}<br>
                                @endif
                                @if($items->first()->ram)
                                    <strong>RAM:</strong> {{ $items->first()->ram }}
                                @endif
                            </div>
                        </div>
                    </div>                    

                    <!-- Quantity -->
                    <div class="mb-3">
                        <label for="addQuantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                        <input type="number" 
                            class="form-control" 
                            id="addQuantity" 
                            name="quantity" 
                            value="1"
                            min="1"
                            max="50"
                            required>
                        <small class="text-muted">Number of units to add</small>
                    </div>

                    <!-- Individual IDs Preview -->
                    <div class="mb-4">
                        <label class="form-label">Individual IDs That Will Be Created</label>
                        <div class="form-control bg-light" style="min-height: 60px;" id="addUnitPreview">
                            <small class="text-muted">Change quantity to see preview</small>
                        </div>
                    </div>

                    <hr>

                    <!-- Status & Condition -->
                    <h6 class="mb-3">Unit Status & Condition</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="addStatus" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="addStatus" name="status" required>
                                <option value="available" selected>Available</option>
                                <option value="issued">Issued</option>
                                <option value="unusable">Unusable</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="addCondition" class="form-label">Condition <span class="text-danger">*</span></label>
                            <select class="form-select" id="addCondition" name="condition" required>
                                <option value="new" selected>New</option>
                                <option value="good">Good</option>
                                <option value="fair">Fair</option>
                                <option value="poor">Poor</option>
                            </select>
                        </div>
                    </div>

                    <!-- Assignment Information (shown only if status = issued) -->
                    <div id="addAssignmentSection" style="display: none;">
                        <hr>
                        <h6 class="mb-3">Assignment Information</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="addIssuedTo" class="form-label">Issued To</label>
                                <input type="text" class="form-control" id="addIssuedTo" name="issued_to" placeholder="Employee name">
                            </div>

                            <div class="col-md-6">
                                <label for="addOffice" class="form-label">Office/Location</label>
                                <input type="text" class="form-control" id="addOffice" name="office" placeholder="e.g., IT Department">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="addDateIssued" class="form-label">Date Issued</label>
                            <input type="date" class="form-control" id="addDateIssued" name="date_issued">
                        </div>
                    </div>

                    <hr>

                    <!-- Additional Info -->
                    <h6 class="mb-3">Additional Information (Optional)</h6>
                    <div class="mb-3">
                        <label for="addDateAcquired" class="form-label">Date Acquired</label>
                        <input type="date" class="form-control" id="addDateAcquired" name="date_acquired">
                    </div>

                    <div class="mb-3">
                        <label for="addNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="addNotes" name="notes" rows="3" placeholder="Any additional notes for these units..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Unit(s)
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>