@extends('layouts.default')

@section('title', 'Activity Logs')

@section('content')
<div class="layout-wrapper">
    <main class="receiving-main-panel">

        <h2>Activity Logs</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                @foreach($logs as $log)
                <tr>
                    <td>{{ $log->user_name }}</td>
                    <td>{{ $log->user_email }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </main>
</div>
@endsection
