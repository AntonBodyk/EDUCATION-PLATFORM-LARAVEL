<?php

namespace App\Jobs;

use App\Events\PdfGenerated;
use App\Http\Controllers\Api\ReportController;
use App\Models\Course;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use function PHPUnit\Framework\throwException;


class TeacherReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $teacher;

    public $fileUrl;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->teacher = $user;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {

//        $teacher = User::where('id', $this->teacher->id)->first();

        // Получаем текущую дату и дату, предшествующую последней неделе
        $today = Carbon::today();
        $lastWeek = $today->copy()->subWeek();


        // Получаем количество курсов, созданных учителем за последнюю неделю
        $coursesLastWeek = Course::where('author_id', $this->teacher->id)
            ->whereBetween('created_at', [$lastWeek, $today])
            ->count();

        // Получаем количество курсов, созданных учителем за последний месяц
        $lastMonth = $today->copy()->subMonth();
        $coursesLastMonth = Course::where('author_id', $this->teacher->id)
            ->whereBetween('created_at', [$lastMonth, $today])
            ->count();

        // Получаем общее количество курсов у учителя
        $totalCourses = $this->teacher->authoredCourses->count();

        $pdf = Pdf::loadView('pdf.report', [
            'coursesLastWeek' => $coursesLastWeek,
            'coursesLastMonth' => $coursesLastMonth,
            'totalCourses' => $totalCourses,
        ]);

        $fileName = 'user-pdf.pdf';
        $filePath = 'pdfs/';
        $file = Storage::disk('public')->put($filePath . $fileName, $pdf->output());

        if ($file) {
            $this->fileUrl = Storage::url($filePath . $fileName);
            broadcast(new PdfGenerated($this->teacher->id, $this->fileUrl));
        } else {
            \Illuminate\Support\Facades\Log::error('Failed to save PDF file.');
        }


        }

}
