@extends('layouts.default')

@section('content')
    <div class="receiving-container">
        <div class="layout-wrapper-main">
            <main class="receiving-main-panel">
                <div class="dashboard-container-main">
                    <h1>Dashboard</h1>
                    <div class="dashboard-container">
                        <!-- Dashboard Stats -->
                        <div class="dashboard" id="dashboard-stats">
                            <!-- Printing Section -->
                            <div class="dashboard-status">
                                <div class="dashboard-header-top">
                                    <div class="dashboard-header-text">
                                        <h2><i class="fa-solid fa-print"></i> Printing</h2>
                                    </div>
                                </div>

                                <div class="card-grid">
                                    <div class="card pen">
                                        <a href="{{ route('status-filter', ['filter' => 'pending']) }}"
                                            class="text-decoration-none">
                                            <div class="in-cards pending">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Pending</p>
                                                        <h4 id="printing-pending">{{ $pending }}</h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-regular fa-clock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card inp">
                                        <a href="{{ route('status-filter', ['filter' => 'in_progress']) }}"
                                            class="text-decoration-none">
                                            <div class="in-cards in_progress">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Ongoing</p>
                                                        <h4 id="printing-in-progress">{{ $in_progress }}</h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-spinner"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card prt">
                                        <a href="{{ route('status-filter', ['filter' => 'printed']) }}"
                                            class="text-decoration-none">
                                            <div class="in-cards printed">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Printed</p>
                                                        <h4 id="printing-printed">{{ $printed }}</h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-print"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card rel">
                                        <a href="{{ route('status-filter', ['filter' => 'released']) }}"
                                            class="text-decoration-none">
                                            <div class="in-cards released">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Released</p>
                                                        <h4 id="printing-released">{{ $released }}</h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-box-open"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card cld">
                                        <a href="{{ route('status-filter', ['filter' => 'cancelled']) }}"
                                            class="text-decoration-none">
                                            <div class="in-cards cancelled">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Cancelled</p>
                                                        <h4 id="printing-cancelled">{{ $cancelled }}</h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-ban"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Repair Section -->
                            <div class="dashboard-status">
                                <div class="dashboard-header-top">
                                    <div class="dashboard-header-text">
                                        <h2><i class="fa-solid fa-screwdriver-wrench"></i> Repair</h2>
                                    </div>
                                </div>

                                <div class="card-grid">
                                    <div class="card pen">
                                        <a href="{{ route('status-repair-filter', ['filter' => 'pending']) }}"
                                            class="text-decoration-none">
                                            <div class="in-cards pending">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Pending</p>
                                                        <h4 id="repair-pending">{{ $repair_pending }}</h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-regular fa-clock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card inp">
                                        <a href="{{ route('status-repair-filter', ['filter' => 'in_progress']) }}"
                                            class="text-decoration-none">
                                            <div class="in-cards in_progress">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Ongoing</p>
                                                        <h4 id="repair-in-progress">{{ $repair_in_progress }}</h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-spinner"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card rpr">
                                        <a href="{{ route('status-repair-filter', ['filter' => 'repaired']) }}"
                                            class="text-decoration-none">
                                            <div class="in-cards repaired">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Repaired</p>
                                                        <h4 id="repair-repaired">{{ $repair_repaired }}</h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-screwdriver-wrench"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card rel">
                                        <a href="{{ route('status-repair-filter', ['filter' => 'released']) }}"
                                            class="text-decoration-none">
                                            <div class="in-cards released">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Released</p>
                                                        <h4 id="repair-released">{{ $repair_released }}</h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-box-open"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card unr">
                                        <a href="{{ route('status-repair-filter', ['filter' => 'unrepairable']) }}"
                                            class="text-decoration-none">
                                            <div class="in-cards unrepaired">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Unrepairable</p>
                                                        <h4 id="repair-unrepairable">{{ $repair_unrepairable }}</h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-ban"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="dashboard-actions">
                            <div class="activities-header">
                                <h3>Quick Actions</h3>
                            </div>

                            <div class="quick-buttons">
                                <div class="quick-print">
                                    <h5><i class="fa-solid fa-print"></i> Add Print Ticket</h5>
                                    <a class="open-print-modal">
                                        <i class="fa-solid fa-circle-plus"></i>
                                    </a>
                                </div>

                                <div class="quick-repair">
                                    <h5><i class="fa-solid fa-screwdriver-wrench"></i> Add Repair Ticket</h5>
                                    <a class="open-repair-modal">
                                        <i class="fa-solid fa-circle-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activities -->
                        <div class="dashboard-activities">
                            <div class="activities-header">
                                <h3>Recent Activities</h3>
                                <button class="activities-menu-btn">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                    </svg>
                                </button>
                            </div>

                            <ul class="activities-list" id="activities-list">
                                @if ($recentActivities->isEmpty())
                                    <p class="no-activities">No recent activities available.</p>
                                @else
                                    @foreach ($recentActivities as $activity)
                                        @php
                                            $type = $activity->type;
                                            $status = $activity->status;

                                            if ($type === 'update_status') {
                                                switch ($status) {
                                                    case 'pending':
                                                        $iconClass = 'fa-clock';
                                                        $colorClass = 'status-pending';
                                                        break;
                                                    case 'ongoing':
                                                    case 'in_progress':
                                                        $iconClass = 'fa-spinner';
                                                        $colorClass = 'status-ongoing';
                                                        break;
                                                    case 'printed':
                                                        $iconClass = 'fa-print';
                                                        $colorClass = 'status-printed';
                                                        break;
                                                    case 'repaired':
                                                        $iconClass = 'fa-screwdriver-wrench';
                                                        $colorClass = 'status-printed';
                                                        break;
                                                    case 'released':
                                                        $iconClass = 'fa-circle-check';
                                                        $colorClass = 'status-released';
                                                        break;
                                                    case 'cancelled':
                                                    case 'unrepairable':
                                                        $iconClass = 'fa-circle-xmark';
                                                        $colorClass = 'status-cancelled';
                                                        break;
                                                    default:
                                                        $iconClass = 'fa-circle-info';
                                                        $colorClass = 'status-default';
                                                }
                                            } elseif ($type === 'create_ticket' || $type === 'repair') {
                                                $iconClass = 'fa-file-lines';
                                                $colorClass = 'activity-ticket';
                                            } elseif ($type === 'update_ticket') {
                                                $iconClass = 'fa-pen-to-square';
                                                $colorClass = 'activity-ticket';
                                            } elseif ($type === 'update_user') {
                                                $iconClass = 'fa-user';
                                                $colorClass = 'activity-user';
                                            } elseif ($type === 'password_changed') {
                                                $iconClass = 'fa-lock';
                                                $colorClass = 'activity-password';
                                            } elseif ($type === 'delete_user') {
                                                $iconClass = 'fa-user-slash';
                                                $colorClass = 'activity-delete';
                                            } elseif ($type === 'add_inventory') {
                                                $iconClass = 'fa-boxes-packing';
                                                $colorClass = 'add-inventory';
                                            } elseif ($type === 'issue_inventory') {
                                                $iconClass = 'fa-user-check';
                                                $colorClass = 'issue-inventory';
                                            } elseif ($type === 'return_inventory') {
                                                $iconClass = 'fa-share';
                                                $colorClass = 'return-inventory';
                                            } elseif ($type === 'edit_inventory') {
                                                $iconClass = 'fa-pen-to-square';
                                                $colorClass = 'edit-inventory';
                                            } elseif ($type === 'delete_inventory') {
                                                $iconClass = 'fa-ban';
                                                $colorClass = 'delete-inventory';
                                            } else {
                                                $iconClass = 'fa-circle-info';
                                                $colorClass = 'activity-default';
                                            }
                                        @endphp

                                        <li class="activity-item">
                                            <div class="activity-icon-wrapper {{ $colorClass }}">
                                                <i class="fa-solid {{ $iconClass }}"></i>
                                            </div>
                                            <div class="activity-details">
                                                <p class="activity-description">
                                                    <strong>{{ $activity->user_name }}</strong>
                                                    <span
                                                        class="activity-text-subtle">{{ $activity->short_description }}</span>
                                                </p>
                                                <span
                                                    class="activity-timestamp">{{ $activity->created_at->diffForHumans() }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                @include('modals.addPrinting')
                @include('modals.addRepair')

            </main>
        </div>
    </div>

    {{-- Auto-refresh Script --}}
    <script>
        // Function to update dashboard stats
        function updateDashboardStats() {
            fetch('{{ route('api.dashboard.stats') }}')
                .then(response => response.json())
                .then(data => {
                    // Update printing stats
                    document.getElementById('printing-pending').textContent = data.printing.pending;
                    document.getElementById('printing-in-progress').textContent = data.printing.in_progress;
                    document.getElementById('printing-printed').textContent = data.printing.printed;
                    document.getElementById('printing-released').textContent = data.printing.released;
                    document.getElementById('printing-cancelled').textContent = data.printing.cancelled;

                    // Update repair stats
                    document.getElementById('repair-pending').textContent = data.repair.pending;
                    document.getElementById('repair-in-progress').textContent = data.repair.in_progress;
                    document.getElementById('repair-repaired').textContent = data.repair.repaired;
                    document.getElementById('repair-released').textContent = data.repair.released;
                    document.getElementById('repair-unrepairable').textContent = data.repair.unrepairable;

                    console.log('Dashboard stats updated');
                })
                .catch(error => console.error('Error updating stats:', error));
        }

        // Function to update recent activities
        function updateRecentActivities() {
            fetch('{{ route('api.dashboard.activities') }}')
                .then(response => response.json())
                .then(data => {
                    const activitiesList = document.getElementById('activities-list');

                    if (data.activities.length === 0) {
                        activitiesList.innerHTML = '<p class="no-activities">No recent activities available.</p>';
                        return;
                    }

                    activitiesList.innerHTML = data.activities.map(activity => `
                        <li class="activity-item">
                            <div class="activity-icon-wrapper ${activity.color_class}">
                                <i class="fa-solid ${activity.icon_class}"></i>
                            </div>
                            <div class="activity-details">
                                <p class="activity-description">
                                    <strong>${activity.user_name}</strong>
                                    <span class="activity-text-subtle">${activity.short_description}</span>
                                </p>
                                <span class="activity-timestamp">${activity.created_at}</span>
                            </div>
                        </li>
                    `).join('');

                    console.log('Recent activities updated');
                })
                .catch(error => console.error('Error updating activities:', error));
        }

        // Track user activity
        let lastActivity = Date.now();
        ['mousemove', 'keypress', 'click', 'scroll'].forEach(event => {
            document.addEventListener(event, () => {
                lastActivity = Date.now();
            });
        });

        // Auto-refresh every 30 seconds adn 5 minutes if user inactive for 10 seconds
        setInterval(() => {
            if (Date.now() - lastActivity > 10000) {
                updateRecentActivities();
            }
        }, 30000);
        setInterval(() => {
            if (Date.now() - lastActivity > 10000) {
                updateDashboardStats();
            }
        }, 300000);

        console.log('Dashboard auto-refresh initialized');

        // For Add print and repair modal pop up
        document.addEventListener('DOMContentLoaded', () => {

            function setupModal(openSelector, modalId, closeId) {
                const openBtns = document.querySelectorAll(openSelector);
                const modal = document.getElementById(modalId);
                const closeBtn = modal?.querySelector(closeId);

                if (!modal) return;

                openBtns.forEach(btn => {
                    btn.addEventListener('click', () => modal.classList.add('active'));
                });

                closeBtn?.addEventListener('click', () => modal.classList.remove('active'));

                window.addEventListener('click', (e) => {
                    if (e.target === modal) modal.classList.remove('active');
                });
            }

            // Print modal
            setupModal('.open-print-modal', 'addPrintingModal', '#closeModal');

            // Repair modal
            setupModal('.open-repair-modal', 'addRepairModal', '#closeRepairModal');
        });
    </script>
@endsection
