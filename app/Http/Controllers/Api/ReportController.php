<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateReport;
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
        // Добавление задачи в очередь на генерацию отчета
        GenerateReport::dispatch($teacherId);

        // Отправка сообщения через WebSocket о начале генерации отчета
        Broadcast::channel('reportGeneration', function () {
            return ['message' => 'Report generation has been initiated'];
        });

        $filename = "teacher_{$teacherId}_courses_report.pdf";
        $url = Storage::url($filename);
        return response()->json(['download_url' => $url]);

        // Возвращаем ответ клиенту
//        return response()->json(['message' => 'Report generation has been initiated']);
    }
}
