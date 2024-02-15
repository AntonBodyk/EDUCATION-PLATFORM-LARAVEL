<?php

namespace App\Jobs;

use App\Events\PdfGenerated;
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



            $pdf = Pdf::loadView('pdf.report');

            $pdfContent = $pdf->output();

            $pdfPath = 'pdfs/' . now()->format('Ymd_His') . '_teacher_report.pdf';
            Storage::put($pdfPath, $pdfContent);

            $pdfUrl = Storage::url($pdfPath);
            event(new PdfGenerated($pdfUrl));
        }

}
