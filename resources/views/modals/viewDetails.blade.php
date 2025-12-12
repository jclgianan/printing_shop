<!-- Details Modal -->
<div class="modal fade" id="viewModal{{ $item->id }}" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Device Details - {{ $item->individual_id }}</h5>
                <button id="btnClose{{ $item->id }}" type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- View Mode -->
            <div id="viewMode{{ $item->id }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Device Name:</strong>
                            {{ $item->device_name }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Category:</strong>
                            {{ $item->category }}
                        </div>
                    </div>
     

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <strong>Serial Number:</strong> 
                            {{ $item->serial_number ?? 'N/A' }}
                        </div>

                    </div>

                    @if($item->processor || $item->ram || $item->storage || $item->graphics_card)
                        <hr>
                        <h6 class="mb-3">Specifications</h6>
                        <div class="row">
                            @if($item->processor)
                                <div class="col-md-6 mb-2">
                                    <strong>Processor:</strong> {{ $item->processor }}
                                </div>
                            @endif
                            @if($item->ram)
                                <div class="col-md-6 mb-2">
                                    <strong>RAM:</strong> {{ $item->ram }}
                                </div>
                            @endif
                            @if($item->storage)
                                <div class="col-md-6 mb-2">
                                    <strong>Storage:</strong> {{ $item->storage }}
                                </div>
                            @endif
                            @if($item->graphics_card)
                                <div class="col-md-6 mb-2">
                                    <strong>Graphics Card:</strong> {{ $item->graphics_card }}
                                </div>
                            @endif
                        </div>
                        @if($item->other_specs)
                            <div class="mt-2">
                                <strong>Other Specs:</strong>
                                {{ $item->other_specs }}
                            </div>
                        @endif
                    @endif

                    <hr>
                    <h6 class="mb-3">Status Information</h6>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <strong>Status:</strong> 
                            <span class="badge bg-{{ $item->status === 'available' ? 'success' : ($item->status === 'issued' ? 'primary' : 'danger') }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Condition:</strong> 
                            <span class="badge bg-{{ $item->condition === 'new' ? 'info' : ($item->condition === 'good' ? 'success' : 'warning') }}">
                                {{ ucfirst($item->condition) }}
                            </span>
                        </div>
                    </div>

                    @if($item->status === 'issued')
                        <hr>
                        <h6 class="mb-3">Assignment Information</h6>
                        <div class="row">
                            @if(!empty($item->issued_to))
                                <div class="col-md-6 mb-2">
                                    <strong>Issued To:</strong> {{ $item->issued_to }}
                                </div>
                            @endif

                            @if(!empty($item->office))
                                <div class="col-md-6 mb-2">
                                    <strong>Office:</strong> {{ $item->office }}
                                </div>
                            @endif
                        </div>
                    @endif

                    @if(!empty($item->date_acquired) || !empty($item->date_issued) || !empty($item->date_returned))
                    <hr>
                    <h6 class="mb-3">Dates</h6>
                    <div class="row">
                        @if($item->date_acquired)
                            <div class="col-md-4 mb-2">
                                <strong>Date Acquired:</strong>
                                {{ $item->date_acquired->format('M d, Y') }}
                            </div>
                        @endif
                        @if($item->date_issued)
                            <div class="col-md-4 mb-2">
                                <strong>Date Issued:</strong>
                                {{ $item->date_issued->format('M d, Y') }}
                            </div>
                        @endif
                        @if($item->status !== 'issued' && $item->date_returned)
                            <div class="col-md-4 mb-2">
                                <strong>Date returned:</strong>
                                {{ $item->date_returned->format('M d, Y') }}
                            </div>
                        @endif
                    </div>
                    @endif

                    @if($item->notes)
                        <hr>
                        <h6 class="mb-2">Notes</h6>
                        <p class="mb-0">{{ $item->notes }}</p>
                    @endif
                </div>
                <div class="modal-footer">
                    @if($item->status === 'available')
                        <button type="button" class="btn btn-primary" onclick="toggleIssue{{ $item->id }}()">
                            Issue
                        </button>
                    @endif
                    @if($item->status === 'issued')
                        <button type="button" class="btn btn-primary" onclick="toggleReturn{{ $item->id }}()">
                            Return
                        </button>
                    @endif
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" onclick="toggleEditMode{{ $item->id }}()">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                </div>
            </div>

            <!-- Edit Mode -->
            <div id="editMode{{ $item->id }}" style="display: none;">
                <form action="{{ route('inventory.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- If the item is already issued, lock these fields --}}
                    @if($item->status === 'issued')
                        <input type="hidden" name="status" value="issued">
                        <input type="hidden" name="condition" value="{{ $item->condition }}">
                    @endif
                    
                    <div class="modal-body">
                        
                        {{-- Serial Number --}}
                        <h6 class="mb-3">Device Information</h6>
                        <div class="col-md-6">
                            <label for="editSerialNumber{{ $item->id }}" class="form-label">Serial Number</label>
                            <input type="text" class="form-control" id="editSerialNumber{{ $item->id }}" name="serial_number" value="{{ $item->serial_number }}" placeholder="e.g., SN1234567890">
                        </div>

                        <!-- Specifications (Editable) -->
                        @if($item->category === 'Computer System' || $item->category === 'Components')
                            <h6 class="mb-3">Specifications</h6>
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
                        @endif

                        @if($item->status === 'available' || $item->status === 'unusable')
                            <hr>
                            <!-- Status & Condition (Editable) -->
                            <h6 class="mb-3">Status & Condition</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="editStatus{{ $item->id }}" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="editStatus{{ $item->id }}" name="status" required>
                                        <option value="available" {{ $item->status === 'available' ? 'selected' : '' }}>Available</option>
                                        @if(empty($item->status) || $item->status === 'issued')
                                            <option value="issued" {{ $item->status === 'issued' ? 'selected' : '' }}>Issued</option>
                                        @endif
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
                        @endif

                        <!-- Assignment Information (Editable, conditional) -->
                        <div id="editAssignmentSection{{ $item->id }}" style="display: {{ $item->status === 'issued' ? 'block' : 'none' }};">
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

                            <div class="col-md-4" id="editDateIssuedField{{ $item->id }}" style="display: {{ $item->status === 'issued' ? 'block' : 'none' }};">
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

            <!-- Issue Modal -->
            <div id="issueModal{{ $item->id }}" style="display: none;">
                <form class="modal-content" action="{{ route('inventory.issue', $item->id) }}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <p><strong>Device:</strong> {{ $item->device_name }}</p>

                        <div class="mb-3">
                            <label class="form-label">Issued To <span class="text-danger">*</span></label>
                            <input type="text" name="issued_to" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Office / Location <span class="text-danger">*</span></label>
                            <input type="text" name="office" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date Issued <span class="text-danger">*</span></label>
                            <input type="date" name="date_issued" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="toggleIssue{{ $item->id }}()">
                            <i class="bi bi-x-circle"></i> Cancel
                        </button>
                        <button class="btn btn-primary">Issue Device</button>
                    </div>
                </form>
            </div>

            <!-- Return Modal -->
            <div id="returnModal{{ $item->id }}" style="display: none;">
                <form class="modal-content" action="{{ route('inventory.return', $item->id) }}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <p><strong>Device:</strong> {{ $item->device_name }}</p>

                        <div class="mb-3">
                            <label for="editCondition{{ $item->id }}" class="form-label">Condition <span class="text-danger">*</span></label>
                            <select class="form-select" id="editCondition{{ $item->id }}" name="condition" required>
                                <option value="new" {{ $item->condition === 'new' ? 'selected' : '' }}>New</option>
                                <option value="good" {{ $item->condition === 'good' ? 'selected' : '' }}>Good</option>
                                <option value="fair" {{ $item->condition === 'fair' ? 'selected' : '' }}>Fair</option>
                                <option value="poor" {{ $item->condition === 'poor' ? 'selected' : '' }}>Poor</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date Returned <span class="text-danger">*</span></label>
                            <input type="date" name="date_returned" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="toggleReturn{{ $item->id }}()">
                            <i class="bi bi-x-circle"></i> Cancel
                        </button>
                        <button class="btn btn-primary">Return Device</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    // Issue Modal Toggle
    function toggleIssue{{ $item->id }}() {
        const viewMode = document.getElementById('viewMode{{ $item->id }}');
        const issueMode = document.getElementById('issueModal{{ $item->id }}');
        const closeBtn = document.getElementById('btnClose{{ $item->id }}');
        
        if (viewMode.style.display === 'none') {
            // Switch to view mode
            viewMode.style.display = 'block';
            closeBtn.style.display = 'block';
            issueMode.style.display = 'none';
            enableBackdropClose();
        } else {
            // Switch to issue mode
            viewMode.style.display = 'none';
            closeBtn.style.display = 'none';
            issueMode.style.display = 'block';
            disableBackdropClose();
        }
    }

    // Return Modal Toggle
    function toggleReturn{{ $item->id }}() {
        const viewMode = document.getElementById('viewMode{{ $item->id }}');
        const returnMode = document.getElementById('returnModal{{ $item->id }}');
        const closeBtn = document.getElementById('btnClose{{ $item->id }}');

        if (viewMode.style.display === 'none') {
            // Switch to view mode
            viewMode.style.display = 'block';
            returnMode.style.display = 'none';
            closeBtn.style.display = 'block';
        } else {
            // Switch to return mode
            viewMode.style.display = 'none';
            returnMode.style.display = 'block';
            closeBtn.style.display = 'none';
        }
    }

    //  Edit Mode Toggle
    function toggleEditMode{{ $item->id }}() {
        const viewMode = document.getElementById('viewMode{{ $item->id }}');
        const editMode = document.getElementById('editMode{{ $item->id }}');
        const closeBtn = document.getElementById('btnClose{{ $item->id }}');
        
        if (viewMode.style.display === 'none') {
            // Switch to view mode
            viewMode.style.display = 'block';
            editMode.style.display = 'none';
            closeBtn.style.display = 'block';
        } else {
            // Switch to edit mode
            viewMode.style.display = 'none';
            editMode.style.display = 'block';
            closeBtn.style.display = 'none';
        }
    }

    //always poor condition if unusable
    document.getElementById('editStatus{{ $item->id }}').addEventListener('change', function() {
        const conditionSelect = document.getElementById('editCondition{{ $item->id }}');

        if (this.value === 'unusable') {
            conditionSelect.value = 'poor';   // auto set to poor
        }
    });

    // Show/hide assignment fields based on status in edit mode
    document.getElementById('editStatus{{ $item->id }}').addEventListener('change', function() {
        const assignmentSection = document.getElementById('editAssignmentSection{{ $item->id }}');
        const dateIssuedField = document.getElementById('editDateIssuedField{{ $item->id }}');
        
        if (this.value === 'issued') {
            assignmentSection.style.display = 'block';
            dateIssuedField.style.display = 'block';
        } else {
            assignmentSection.style.display = 'none';
            dateIssuedField.style.display = 'none';
        }
    });
    
</script>