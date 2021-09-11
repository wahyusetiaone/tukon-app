<?php

use App\Models\NotificationHandler as NotificationHandler;
use \App\Events\PembayaranEventController as PembayaranEventController;
use \App\Events\PenarikanDanaEventController as PenarikanDanaEventController;
use \App\Events\PenawaranEventController as PenawaranEventController;
use \App\Events\PengajuanEventController as PengajuanEventController;
use \App\Events\ProyekEventController as ProyekEventController;

if (!function_exists("createNotification")) {
    function createNotification(int $user_id, String $title, String $message, String $name, int $deep_id, String $role, String $action, String $eventCreated)
    {
        $msg = new NotificationHandler();
        $msg->user_id = $user_id;
        $msg->title = $title;
        $msg->message = $message;
        $msg->name = $name;
        $msg->deep_id = $deep_id;
        $msg->role = $role; //client/tukang/admin
        $msg->action = $action; //add/delete/update
        $msg->read = false;
        $msg->save();
        $unReadNotif = NotificationHandler::select()->where('user_id', $user_id)->count();

        bringInNotification($msg, $unReadNotif, $eventCreated);
    }
}

