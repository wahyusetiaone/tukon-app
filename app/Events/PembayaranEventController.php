<?php

namespace App\Events;

use App\Models\NotificationHandler;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PembayaranEventController implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $unReadNotif;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(NotificationHandler $message, int $unReadNotif)
    {
        $this->message = $message;
        $this->unReadNotif = $unReadNotif;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        if ($this->message->role == 'admin'){
            return new PrivateChannel('admin');
        }
        return new PrivateChannel('user.'.$this->message->user_id);
    }

    /**
     * This used to lock of indentity event.
     *
     * @return String
     */
    public static function eventCreated(){
        return 'PembayaranEventController';
    }

}
