<div id="issueModal{{ $items->inventory_id }}">
    <form action="{{ route('inventory.issue', $items->inventory_id) }}" method="POST">
        @csrf

        <div class="modal-body">
            <div class="alert alert-info py-2">
                <i class="bi bi-info-circle me-2"></i>
                Assigning <strong>{{ $items->device_name }}</strong> to a user.
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Issued To <span class="text-danger">*</span></label>
                <input type="text" name="issued_to" class="form-control" placeholder="Full Name" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Office / Location <span class="text-danger">*</span></label>
                <input type="text" name="office" class="form-control" placeholder="Department or Room" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Date Issued <span class="text-danger">*</span></label>
                <input type="date" name="date_issued" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
        </div>

        <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary" onclick="toggleIssue('{{ $items->inventory_id }}')">
                <i class="bi bi-x-circle"></i> Cancel
            </button>
            {{-- Added type="submit" and used btn-primary for clarity --}}
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Issue Device
            </button>
        </div>
    </form>
</div>
