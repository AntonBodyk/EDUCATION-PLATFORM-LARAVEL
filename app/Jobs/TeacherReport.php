<?php

namespace App\Jobs;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;

class TeacherReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $teacherId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $teacherId)
    {
        $this->teacherId = $teacherId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {

        $teacher = User::findOrFail($this->teacherId);
        $teacherCourses = $teacher->authoredCourses;
        $teacherCoursesCount = $teacher->authoredCourses->count();

        $pdf = Pdf::loadView('pdf.report', ['teacher'=> $teacherCourses]);

        $pdfContent = $pdf->output();

        try {
            // Отправьте содержимое PDF-файла через Pusher
            $pusher = new Pusher('5af85efcf93524328676', '4f1608a5f03a18405750', '1755270');
            $pusher->trigger('teacher_report', 'teacher_report_generated', ['content' => $pdfContent]);
        } catch (\Exception $e) {
            Log::error('Failed to send PDF content via Pusher: ' . $e->getMessage());
        }


    }
}
