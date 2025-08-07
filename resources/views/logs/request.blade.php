@extends('layouts.app')

@section('content')
    <h2 class="mb-4">Request Logs</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Method</th>
                <th>URL</th>
                <th>Payload</th>
                <th>IP Address</th>
                <th>User Agent</th>
                <th>Created At</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->method }}</td>
                    <td>{{ $log->url }}</td>
                    <td><pre>{{ $log->payload }}</pre></td>
                    <td>{{ $log->ip_address }}</td>
                    <td>{{ $log->user_agent }}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
