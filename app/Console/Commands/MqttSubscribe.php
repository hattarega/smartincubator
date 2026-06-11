<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LatestReading;
use App\Models\SensorReading;
use App\Events\SensorUpdated;
use Illuminate\Support\Facades\Log;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

class MqttSubscribe extends Command
{
    protected $signature = 'mqtt:subscribe';
    protected $description = 'Subscribe MQTT Topic';

    public function handle()
    {
        $this->info("MQTT Listener Running...");

        while (true) {
            try {
                app(\App\Services\MqttService::class)->subscribe();
            } catch (\Throwable $e) {
                $this->error($e->getMessage());
                sleep(5);
            }
        }
       
    }
}
