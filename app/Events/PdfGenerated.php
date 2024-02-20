<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PdfGenerated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $pdfUrl;
    public $userId;

    public function __construct($userId, string $pdfUrl)
    {
        $this->pdfUrl = $pdfUrl;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new Channel('reportGeneration');

    }


}
