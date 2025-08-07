<?php

namespace App\Http\Controllers\LogViewer;

use App\Http\Controllers\Controller;
use App\Models\ApiLog;
use App\Models\error_logs;
use App\Models\RequestLog;

class LogViewerController extends Controller
{
    public function errorLogs()
    {
        $logs = error_logs::latest()->paginate(50);
        return view('logs.error', compact('logs'));
    }

    public function requestLogs()
    {
        $logs = RequestLog::latest()->paginate(50);
        return view('logs.request', compact('logs'));
    }

    public function apiLogs()
    {
        $logs = ApiLog::latest()->paginate(50);
        return view('logs.api', compact('logs'));
    }
}
