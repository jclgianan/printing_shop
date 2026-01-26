<div id="returnModal{{ $items->inventory_id }}">
    {{-- Removed 'modal-content' class as it is already provided by the main shell --}}
    <form action="{{ route('inventory.return', $items->inventory_id) }}" method="POST">
        @csrf

        <div class="modal-body">
            <div class="alert alert-warning py-2">
                <i class="bi bi-arrow-return-left me-2"></i>
                Returning <strong>{{ $items->device_name }}</strong> to available stock.
            </div>

            <div class="mb-3">
                <label for="returnCondition{{ $items->inventory_id }}" class="form-label fw-bold">
                    Condition upon Return <span class="text-danger">*</span>
                </label>
                <select class="form-select" id="returnCondition{{ $items->inventory_id }}" name="condition" required>
                    <option value="new" {{ $items->condition === 'new' ? 'selected' : '' }}>New</option>
                    <option value="good" {{ $items->condition === 'good' ? 'selected' : '' }}>Good</option>
                    <option value="fair" {{ $items->condition === 'fair' ? 'selected' : '' }}>Fair</option>
                    <option value="poor" {{ $items->condition === 'poor' ? 'selected' : '' }}>Poor</option>
                </select>
                <div class="form-text">Update the condition if the device was damaged during use.</div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Date Returned <span class="text-danger">*</span></label>
                {{-- Prefilled with today's date for convenience --}}
                <input type="date" name="date_returned" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
        </div>

        <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary" onclick="toggleReturn('{{ $items->inventory_id }}')">
                <i class="bi bi-x-circle"></i> Cancel
            </button>
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-box-arrow-in-down"></i> Return Device
            </button>
        </div>
    </form>
</div>
