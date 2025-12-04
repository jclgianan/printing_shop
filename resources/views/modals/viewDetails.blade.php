<!-- Details Modal -->
<div class="modal fade" id="viewModal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Device Details - {{ $item->individual_id }}</h5>
                <button id="closeModal" type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Device Name:</strong><br>
                        {{ $item->device_name }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Category:</strong><br>
                        {{ $item->category }}
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
                            <strong>Other Specs:</strong><br>
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

                @if($item->issued_to || $item->office)
                    <hr>
                    <h6 class="mb-3">Assignment Information</h6>
                    <div class="row">
                        @if($item->issued_to)
                            <div class="col-md-6 mb-2">
                                <strong>Issued To:</strong> {{ $item->issued_to }}
                            </div>
                        @endif
                        @if($item->office)
                            <div class="col-md-6 mb-2">
                                <strong>Office:</strong> {{ $item->office }}
                            </div>
                        @endif
                    </div>
                @endif

                <hr>
                <h6 class="mb-3">Dates</h6>
                <div class="row">
                    @if($item->date_acquired)
                        <div class="col-md-4 mb-2">
                            <strong>Date Acquired:</strong><br>
                            {{ $item->date_acquired->format('M d, Y') }}
                        </div>
                    @endif
                    @if($item->date_issued)
                        <div class="col-md-4 mb-2">
                            <strong>Date Issued:</strong><br>
                            {{ $item->date_issued->format('M d, Y') }}
                        </div>
                    @endif
                    @if($item->warranty_expiration)
                        <div class="col-md-4 mb-2">
                            <strong>Warranty Expires:</strong><br>
                            {{ $item->warranty_expiration->format('M d, Y') }}
                            @if($item->isWarrantyValid())
                                <span class="badge bg-success">Valid</span>
                            @elseif($item->isWarrantyValid() === false)
                                <span class="badge bg-danger">Expired</span>
                            @endif
                        </div>
                    @endif
                </div>

                @if($item->notes)
                    <hr>
                    <h6 class="mb-2">Notes</h6>
                    <p class="mb-0">{{ $item->notes }}</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="" class="btn btn-warning">Edit</a>
            </div>
        </div>
    </div>
</div>

