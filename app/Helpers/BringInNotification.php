<?php

use App\Models\NotificationHandler as NotificationHandler;
use \App\Events\PembayaranEventController as PembayaranEventController;
use \App\Events\PenarikanDanaEventController as PenarikanDanaEventController;
use \App\Events\PenawaranEventController as PenawaranEventController;
use \App\Events\PengajuanEventController as PengajuanEventController;
use \App\Events\ProyekEventController as ProyekEventController;

if (!function_exists("bringInNotification")) {
    function bringInNotification(NotificationHandler $notificationHandler, int $unReadNotif, string $eventCreated)
    {
        switch ($eventCreated) {
            case PembayaranEventController::eventCreated():
                broadcast(new PembayaranEventController($notificationHandler, $unReadNotif));
                break;
            case PenarikanDanaEventController::eventCreated():
                broadcast(new PenarikanDanaEventController($notificationHandler, $unReadNotif));
                break;
            case PenawaranEventController::eventCreated():
                broadcast(new PenawaranEventController($notificationHandler, $unReadNotif));
                break;
            case PengajuanEventController::eventCreated():
                broadcast(new PengajuanEventController($notificationHandler, $unReadNotif));
                break;
            case ProyekEventController::eventCreated():
                broadcast(new ProyekEventController($notificationHandler, $unReadNotif));
                break;
        }
    }
}

