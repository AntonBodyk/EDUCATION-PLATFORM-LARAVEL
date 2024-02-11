<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
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
        // Используйте $this->teacherId для получения информации о пользователе и генерации отчета
        $teacher = User::findOrFail($this->teacherId);
        $courseCount = $teacher->courses()->count();

        // Далее выполните логику для генерации отчета, включая количество курсов
    }
}
