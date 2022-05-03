<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Zakat;
use App\Models\User;
use App\Models\SatuanZakat;
use App\Models\Rt;

class ZakatRecapt implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $zakat;
    public $user;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $zakat)
    {
        $this->user = $user;
        $this->zakat = $zakat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('zakats');
    }
}
