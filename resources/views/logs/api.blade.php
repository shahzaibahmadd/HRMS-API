@extends('layouts.app')

@section('content')
    <h2 class="mb-4">API Logs</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Resource</th>
                <th>URL</th>
                <th>Method</th>
                <th>Query Params</th>
                <th>Request Payload</th>
                <th>Response Payload</th>
                <th>Status Code</th>
                <th>User ID</th>
                <th>Created At</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->resource }}</td>
                    <td>{{ $log->url }}</td>
                    <td>{{ $log->method }}</td>
                    <td>{{ $log->query_params ? json_encode($log->query_params) : '-' }}</td>
                    <td>{{ $log->request_payload ? json_encode($log->request_payload) : '-' }}</td>
                    <td>{{ $log->response_payload ? Str::limit(json_encode($log->response_payload), 100) : '-' }}</td>
                    <td>{{ $log->status_code }}</td>
                    <td>{{ $log->user_id ?? '-' }}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
