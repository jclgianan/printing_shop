@extends('layouts.default')

@section('content')
    <div class="receiving-container">
        <div class="layout-wrapper-main">
            <main class="receiving-main-panel">

                <div class="dashboard-container-main">
                    <h1>Dashboard</h1>
                    <div class="dashboard-container">
                        <div class="dashboard">
                            <div class="dashboard-status">
                                <div class="dashboard-header-top">
                                    <div class="dashboard-header-text">
                                        <h2><i class="fa-solid fa-print"></i> Printing</h2>
                                    </div>
                                </div>

                                <div class="card-grid">
                                    <div class="card pen">
                                        <a href="{{ route('status-filter', ['filter' => 'pending']) }}" class="text-decoration-none">
                                            <div class="in-cards pending">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Pending</p>
                                                        <h4> {{ $pending }} </h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-regular fa-clock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card inp">
                                        <a href="{{ route('status-filter', ['filter' => 'in_progress']) }}" class="text-decoration-none">
                                            <div class="in-cards  in_progress">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Ongoing</p>
                                                        <h4> {{ $in_progress }} </h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-spinner"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card prt">
                                        <a href="{{ route('status-filter', ['filter' => 'printed']) }}" class="text-decoration-none">
                                            <div class="in-cards printed">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Printed</p>
                                                        <h4> {{ $printed }} </h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-print"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card rel">
                                        <a href="{{ route('status-filter', ['filter' => 'released']) }}" class="text-decoration-none">
                                            <div class="in-cards released">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Released</p>
                                                        <h4> {{ $released }} </h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-box-open"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card cld">
                                        <a href="{{ route('status-filter', ['filter' => 'cancelled']) }}" class="text-decoration-none">
                                            <div class="in-cards cancelled">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Cancelled</p>
                                                        <h4> {{ $cancelled }} </h4>
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
                            <div class="dashboard-status">
                                <div class="dashboard-header-top">
                                    <div class="dashboard-header-text">
                                        <h2><i class="fa-solid fa-screwdriver-wrench"></i> Repair</h2>
                                    </div>
                                </div>

                                <div class="card-grid">
                                    <div class="card pen">
                                        <a href="{{ route('status-repair-filter', ['filter' => 'pending']) }}" class="text-decoration-none">
                                            <div class="in-cards pending">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Pending</p>
                                                        <h4> {{ $repair_pending }} </h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-regular fa-clock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card inp">
                                        <a href="{{ route('status-repair-filter', ['filter' => 'in_progress']) }}" class="text-decoration-none">
                                            <div class="in-cards in_progress">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Ongoing</p>
                                                        <h4> {{ $repair_in_progress }} </h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-spinner"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card rpr">
                                        <a href="{{ route('status-repair-filter', ['filter' => 'repaired']) }}" class="text-decoration-none">
                                            <div class="in-cards repaired">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Repaired</p>
                                                        <h4> {{ $repair_repaired }} </h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-screwdriver-wrench"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card rel">
                                        <a href="{{ route('status-repair-filter', ['filter' => 'released']) }}" class="text-decoration-none">
                                            <div class="in-cards released">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Released</p>
                                                        <h4> {{ $repair_released }} </h4>
                                                    </div>
                                                    <div class="icon-right">
                                                        <i class="fa-solid fa-box-open"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="card unr">
                                        <a href="{{ route('status-repair-filter', ['filter' => 'unrepairable']) }}" class="text-decoration-none">
                                            <div class="in-cards unrepaired">
                                                <div class="card-content">
                                                    <div class="text-left">
                                                        <p>Unrepairable</p>
                                                        <h4> {{ $repair_unrepairable }} </h4>
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

                        <div class="dashboard-activities">
                            <div class="activities-header">
                                <h3>Recent Activities</h3>
                                <button class="activities-menu-btn">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                    </svg>
                                </button>
                            </div>
                            
                            @if (!isset($recentActivities) || $recentActivities->isEmpty())
                                <p class="no-activities">No recent activities available.</p>
                            @else
                                <ul class="activities-list">
                                    @foreach ($recentActivities as $activity)
                                        @php
                                            $type = $activity->type;
                                            $status = $activity->status;
                                            
                                            // Determine icon and color class based on activity type and status
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
                                                    <strong>{{ $activity->user_name }}</strong> {{ $activity->short_description }}
                                                </p>
                                                <span class="activity-timestamp">{{ $activity->created_at->diffForHumans() }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
