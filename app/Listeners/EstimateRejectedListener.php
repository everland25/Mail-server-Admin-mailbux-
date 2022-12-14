<?php

namespace App\Listeners;

use App\Events\EstimateRejectedEvent;
use App\Notifications\EstimateRejected;
use Illuminate\Support\Facades\Notification;

class EstimateRejectedListener
{
    /**
     * Handle the event.
     *
     * @param EstimateRejectedEvent $event
     */
    public function handle(EstimateRejectedEvent $event)
    {
        $estimate = $event->estimate;
        $currentCompany = $event->estimate->company;

        // Send Notification to Company User
        $notifyUsers = $currentCompany->users()->get()->filter(function ($user) {
            return $user->getSetting('notification_estimate_approved_or_rejected');
        });

        try {
            Notification::send($notifyUsers, new EstimateRejected($estimate));
        } catch (\Exception $th) {
            //throw $th;
        }
    }
}
