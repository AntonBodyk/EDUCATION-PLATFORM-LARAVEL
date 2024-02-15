<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\TeacherReport;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pusher\Pusher;

class ReportController extends Controller
{
    public function generateReport(Request $request): object
    {
        $teacherId = $request->input('teacherId');

        TeacherReport::dispatch($teacherId);


        return response()->json(['message' => 'Report generation has been initiated']);
    }
}
