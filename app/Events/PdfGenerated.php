<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PdfGenerated
{
    use Dispatchable, SerializesModels;

    public $pdfUrl;

    public function __construct($pdfUrl)
    {
        $this->pdfUrl = $pdfUrl;
    }
}
