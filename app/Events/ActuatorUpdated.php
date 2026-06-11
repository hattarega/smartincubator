<?php

namespace App\Events;

use App\Models\Actuator;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActuatorUpdated implements ShouldBroadcastNow
{
    public $actuator;

    public function __construct($actuator)
    {
        $this->actuator = $actuator;
        Log::info('EVENT ActuatorUpdated', [
            'cage_id' => $this->actuator->cage_id
        ]);
    }

    public function broadcastOn()
    {
        return new Channel('actuator.' . $this->actuator->cage_id);
    }

    public function broadcastAs()
    {
        return 'actuator.updated';
    }

    public function broadcastWith()
    {
        return [
            'actuator' => $this->actuator->toArray()
        ];
    }
}
