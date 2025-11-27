@extends('layouts.default')

@section('title', 'Activity Logs')

@section('content')
<div class="layout-wrapper">
    <main class="receiving-main-panel">

        <h2 class="logs-header-text">Activity Logs</h2>

        <table class="logs-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                @php 
                    $logsChrono = $logs->sortBy('created_at')->values(); 
                    $total = $logsChrono->count(); // total number of logs
                @endphp

                @foreach($logs->sortByDesc('created_at') as $log)
                <tr>
                    <td>{{ $logsChrono->search($log) + 1 }}</td>
                    <td>{{ $log->user_name }}</td>
                    <td>{{ $log->user_email }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{!! $log->description !!}}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </main>
</div>
@endsection
