@extends('layouts.default')

@section('content')
    <div class="receiving-container">
        <div class="layout-wrapper-main">
            <main class="receiving-main-panel">
                <div class="dashboard-container-main">
                    {{-- <h1>Dashboard</h1> --}}
                    <br>
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
                            <hr>
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

                        <!-- Inventory Graph -->
                        <div class="inventory-graph">
                            <div class="activities-header">
                                <h3><i class="fa-solid fa-boxes-packing"></i> Inventory Graph</h3>
                            </div>
                            <div>
                                <div id="apex-column-chart"></div>
                                <div id="apex-pie-chart"></div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="dashboard-actions">
                            <div class="activities-header">
                                <h3><i class="fa-solid fa-bolt-lightning"></i> Quick Actions</h3>
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
                                <h3><i class="fa-solid fa-clock-rotate-left"></i> Recent Activities</h3>
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

        // ========= Inventory Graph CSS =========
        // Store chart instances globally
        let barChartInstance = null;
        let pieChartInstance = null;

        // Bar Chart Graph
        async function loadInventoryChart() {
            const res = await fetch('/dashboard/inventory-chart');
            const data = await res.json();

            if (!data || !data.length) {
                document.querySelector('#apex-column-chart').innerHTML =
                    '<div style="padding: 40px; text-align: center; color: #6c757d;"><i class="fa-solid fa-chart-simple" style="font-size: 48px; opacity: 0.3;"></i><p style="margin-top: 16px;">No inventory data available</p></div>';
                return;
            }

            const categories = data.map(i => i.category);
            const available = data.map(i => i.available);
            const issued = data.map(i => i.issued);
            const unusable = data.map(i => i.unusable);

            // Destroy previous chart instance if it exists
            if (barChartInstance) {
                barChartInstance.destroy();
            }

            var options = {
                chart: {
                    height: '90%',
                    type: 'bar',
                    toolbar: {
                        show: false
                    },
                    animations: {
                        enabled: true
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        columnWidth: '90%',
                        endingShape: 'rounded'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 5,
                    colors: ['transparent']
                },
                colors: ['#10b981', '#3b82f6', '#ef4444'],
                series: [{
                        name: 'Available',
                        data: available
                    },
                    {
                        name: 'Issued',
                        data: issued
                    },
                    {
                        name: 'Unusable',
                        data: unusable
                    }
                ],
                xaxis: {
                    categories: categories,
                },
                yaxis: {
                    title: {
                        text: 'Units',
                        padding: {
                            left: 5
                        }
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " unit" + (val !== 1 ? 's' : '')
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    fontSize: '15px',
                    offsetY: 0
                },
                grid: {
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0
                    }
                }
            };

            barChartInstance = new ApexCharts(
                document.querySelector('#apex-column-chart'),
                options
            );

            barChartInstance.render();
        }

        // Pie Chart Graph
        async function loadInventoryPieChart() {
            const res = await fetch('/dashboard/inventory-chart');
            const data = await res.json();

            if (!data || !data.length) {
                document.querySelector('#apex-pie-chart').innerHTML =
                    '<div style="padding: 40px; text-align: center; color: #6c757d;"><i class="fa-solid fa-chart-pie" style="font-size: 48px; opacity: 0.3;"></i><p style="margin-top: 16px;">No inventory data available</p></div>';
                return;
            }

            // Extract categories and calculate totals for each category
            const categories = data.map(i => i.category);
            const totals = data.map(i => i.available + i.issued + i.unusable);

            // Calculate grand total for percentage calculation
            const grandTotal = totals.reduce((sum, val) => sum + val, 0);

            // Destroy previous chart instance if it exists
            if (pieChartInstance) {
                pieChartInstance.destroy();
            }

            var options = {
                chart: {
                    height: '95%',
                    width: '100%',
                    type: 'pie',
                    toolbar: {
                        show: false
                    },
                    animations: {
                        enabled: true
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val, opts) {
                        return val.toFixed(1) + "%";
                    },
                    dropShadow: {
                        enabled: false
                    },
                    style: {
                        fontSize: '14px',
                        fontWeight: 'bold',
                        colors: ['#808080'],
                    }
                },
                stroke: {
                    show: true,
                    width: 1,
                    colors: ['#808080']
                },
                colors: ['#ffb3ba', '#bae1ff', '#baffc9', '#ffffba', '#ffdfba', '#e0bbff'],
                labels: categories,
                series: totals,
                legend: {
                    position: 'left',
                    horizontalAlign: 'center',
                    fontSize: '14px',
                    offsetY: 10,
                    formatter: function(seriesName, opts) {
                        const value = opts.w.globals.series[opts.seriesIndex];
                        return seriesName;
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            const percentage = ((val / grandTotal) * 100).toFixed(1);
                            return val + " units (" + percentage + "%)";
                        }
                    }
                },
                responsive: [{
                    breakpoint: 768,
                    options: {
                        chart: {
                            height: 300
                        },
                        legend: {
                            position: 'bottom',
                            fontSize: '12px'
                        }
                    }
                }]
            };

            pieChartInstance = new ApexCharts(
                document.querySelector('#apex-pie-chart'),
                options
            );

            pieChartInstance.render();
        }

        // Initial load
        loadInventoryChart();
        loadInventoryPieChart();

        // Auto-refresh every 30 seconds
        setInterval(loadInventoryChart, 7200000);
        setInterval(loadInventoryPieChart, 7200000);
    </script>
@endsection
