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
        $user = $request->user();
        if ($user) {
            $teacherReport = TeacherReport::dispatch($user)->onQueue('default');



            return response()->json(['message' => 'Report generated successfully'], 200);
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    }
}
