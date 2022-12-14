<?php

namespace App\Listeners;

use App\Events\EstimateSentEvent;
use App\Notifications\EstimateSent;
use Illuminate\Support\Facades\Notification;

class EstimateSentListener
{
    /**
     * Handle the event.
     *
     * @param EstimateSentEvent $event
     */
    public function handle(EstimateSentEvent $event)
    {
        $estimate = $event->estimate;
        $currentCompany = $event->estimate->company;

        // Send Notification to Company User
        $notifyUsers = $currentCompany->users()->get()->filter(function ($user) {
            return $user->getSetting('notification_estimate_sent');
        });

        try {
            Notification::send($notifyUsers, new EstimateSent($estimate));
        } catch (\Exception $th) {
            //throw $th;
        }
    }
}
