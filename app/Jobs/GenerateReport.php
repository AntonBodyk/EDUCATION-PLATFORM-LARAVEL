<?php

namespace App\Jobs;

use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateReport implements ShouldQueue
{
use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

protected $teacherId;

/**
* Create a new job instance.
*
* @param int $teacherId
*/
public function __construct(int $teacherId)
{
$this->teacherId = $teacherId;
}

/**
* Execute the job.
*/
public function handle(): void
{
// Отримати інформацію про вчителя
$teacher = User::findOrFail($this->teacherId);
$courseCount = $teacher->courses()->count();

// Створити PDF-документ
$pdf = PDF\Pdf::class::loadView('reports.teacher_courses', [
'teacher' => $teacher,
'courseCount' => $courseCount
]);

// Зберегти PDF-документ
$pdf->save(storage_path('app/public/reports') . "teacher_{$teacher->id}_courses_report.pdf");
}
}
