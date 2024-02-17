<?php

namespace App\Http\Controllers\Api;

use App\Events\Hello;
use App\Events\PdfGenerated;
use App\Http\Controllers\Controller;
use App\Jobs\TeacherReport;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pusher\Pusher;

class ReportController extends Controller
{

    public function generateReport(Request $request)
    {
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true
            ]
        );

        $pusher->trigger('reportGeneration', 'PdfGenerated ', ['message' => 'Hello message sent']);

        \Illuminate\Support\Facades\Log::info('Report generation event sent.');
        return response()->json(['message' => 'Report generated successfully'], 200);
    }
}
