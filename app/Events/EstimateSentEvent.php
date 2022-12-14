<?php

namespace App\Events;

use App\Models\Estimate;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EstimateSentEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The estimate instance.
     *
     * @var \App\Models\Estimate
     */
    public $estimate;

    /**
     * Create a new event instance.
     */
    public function __construct(Estimate $estimate)
    {
        $this->estimate = $estimate;
    }
}
