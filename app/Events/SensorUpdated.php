<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;

class SensorUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $reading;

    /**
     * Create a new event instance.
     */
    public function __construct($reading)
    {
        $this->reading = $reading;

        Log::info('EVENT SensorUpdated CONSTRUCT', [
            'cage_id' => $reading->cage_id
        ]);
    }

    public function broadcastOn()
    {
        return new Channel('sensor.' . $this->reading->cage_id);
    }

    public function broadcastAs()
    {
        return 'sensor.updated';
    }

    public function broadcastWith()
    {
        return [
            'data' => $this->reading->toArray()
        ];
    }
}
