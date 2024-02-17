<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PdfGenerated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $pdfUrl;

    public function __construct($pdfUrl)
    {
        $this->pdfUrl = $pdfUrl;
    }

    public function broadcastWith()
    {
        //echo"broadcastWith";
        return  ['welcome'=>'welcome to the club'];
    }

    public function broadcastOn()
    {
        return new Channel('reportGeneration');
    }


}
