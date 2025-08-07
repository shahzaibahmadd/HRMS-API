@extends('layouts.app')

@section('content')
    <h2 class="mb-4">Error Logs</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Message</th>
                <th>File</th>
                <th>Line</th>
                <th>Trace</th>
                <th>Created At</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->message }}</td>
                    <td>{{ $log->file }}</td>
                    <td>{{ $log->line }}</td>
                    <td><pre>{{ $log->trace }}</pre></td>
                    <td>{{ $log->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
