<?php

namespace App\Listeners;

use App\Events\EstimateViewedEvent;
use App\Notifications\EstimateViewed;
use Illuminate\Support\Facades\Notification;

class EstimateViewedListener
{
    /**
     * Handle the event.
     *
     * @param EstimateViewedEvent $event
     */
    public function handle(EstimateViewedEvent $event)
    {
        $estimate = $event->estimate;
        $currentCompany = $event->estimate->company;

        // Send Notification to Company User
        $notifyUsers = $currentCompany->users()->get()->filter(function ($user) {
            return $user->getSetting('notification_estimate_viewed');
        });

        try {
            Notification::send($notifyUsers, new EstimateViewed($estimate));
        } catch (\Exception $th) {
            //throw $th;
        }
    }
}
