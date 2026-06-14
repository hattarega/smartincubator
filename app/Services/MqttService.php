<?php

namespace App\Services;

use App\Events\ActuatorUpdated;
use PhpMqtt\Client\MqttClient;
use Illuminate\Support\Facades\Log;
use App\Models\Actuator;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\LatestReading;
use App\Models\SensorReading;
use App\Events\SensorUpdated;

class MqttService
{
    public function subscribe()
    {
        $server = env('MQTT_HOST');
        $port = env('MQTT_PORT', 8883);
        $clientId = 'laravel-subscriber';

        $mqtt = new MqttClient($server, $port, $clientId);

        $connectionSettings = (new ConnectionSettings)
            ->setUsername(env('MQTT_USERNAME'))
            ->setPassword(env('MQTT_PASSWORD'))
            ->setUseTls(true)
            ->setTlsSelfSignedAllowed(true);

        $mqtt->connect($connectionSettings, true);

        $cageId = 1;

        /*
        |--------------------------------------------------------------------------
        | 1. SUBSCRIBE SENSOR
        |--------------------------------------------------------------------------
        */
        $mqtt->subscribe('cage/1/sensor', function ($topic, $message) use ($cageId) {

            Log::info('MQTT SENSOR MASUK', [
                'topic' => $topic,
                'message' => $message
            ]);

            $data = json_decode($message, true);

            if (!$data) {
                Log::error('MQTT SENSOR GAGAL JSON');
                return;
            }

            if (!isset($data['dht11'], $data['dht22'])) {
                Log::error('FORMAT SALAH');
                return;
            }

            Log::info('MQTT SENSOR JSON OK', $data);


            // ✅ Update latest
            $latest = LatestReading::updateOrCreate(
                ['cage_id' => $cageId],
                [
                    'temperature_dht11' => $data['dht11']['suhu'] ?? null,
                    'humidity_dht11' => $data['dht11']['kelembapan'] ?? null,
                    'temperature_dht22' => $data['dht22']['suhu'] ?? null,
                    'humidity_dht22' => $data['dht22']['kelembapan'] ?? null,
                    'recorded_at' => now(),
                ]
            );

            // ✅ Simpan histori tiap 60 detik
            static $lastInsert = 0;
            if (time() - $lastInsert >= 60) {


                SensorReading::create([
                    'cage_id' => $cageId,
                    'type' => 'dht11',
                    'temperature' => $data['dht11']['suhu'] ?? null,
                    'humidity' => $data['dht11']['kelembapan'] ?? null,
                ]);

                SensorReading::create([
                    'cage_id' => $cageId,
                    'type' => 'dht22',
                    'temperature' => $data['dht22']['suhu'] ?? null,
                    'humidity' => $data['dht22']['kelembapan'] ?? null,
                ]);

                $lastInsert = time();
            }

            Log::info('DATABASE UPDATED', [
                'latest_id' => $latest->id
            ]);

            // 🔥 Broadcast realtime ke frontend
            try {
                event(new SensorUpdated($latest));
            } catch (\Throwable $e) {
                Log::error('EVENT ERROR: ' . $e->getMessage());
            }
        }, 0);

        // ================= ACTUATOR =================
        $mqtt->subscribe('cage/1/actuator/state', function ($topic, $message) use ($cageId) {

            Log::info('MQTT ACTUATOR MASUK', [
                'topic'   => $topic,
                'message' => $message
            ]);

            $data = json_decode($message, true);
            if (!$data) {
                Log::error('MQTT ACTUATOR GAGAL JSON');
                return;
            }

            // Loop tiap aktuator yang ada di payload (lampu, mistmaker, dst)
            foreach ($data as $name => $info) {
                if (!isset($info['state'], $info['mode'])) {
                    Log::warning('MQTT ACTUATOR: field state/mode tidak lengkap', ['name' => $name]);
                    continue;
                }

                $actuator = \App\Models\Actuator::where('cage_id', $cageId)
                    ->whereRaw('LOWER(name) = ?', [strtolower($name)])
                    ->first();

                if (!$actuator) {
                    Log::warning('MQTT ACTUATOR: tidak ditemukan di DB', ['name' => $name]);
                    continue;
                }

                // Update state dan mode sesuai yang dikirim ESP
                $actuator->update([
                    'state'      => strtoupper($info['state']),
                    'mode'       => strtoupper($info['mode']),
                    'updated_at' => now()
                ]);

                Log::info('MQTT ACTUATOR UPDATED', [
                    'name'  => $name,
                    'state' => $info['state'],
                    'mode'  => $info['mode'],
                ]);

                try {
                    event(new ActuatorUpdated($actuator));
                } catch (\Throwable $e) {
                    Log::error('EVENT ERROR: ' . $e->getMessage());
                }
            }
        }, 0);

        $mqtt->loop(true);
    }

    public function publish($topic, $message)
    {
        $server = env('MQTT_HOST');
        $port = env('MQTT_PORT', 8883);
        $clientId = 'laravel-client' . uniqid();

        $mqtt = new MqttClient($server, $port, $clientId);

        $connectionSettings = (new ConnectionSettings)
            ->setUsername(env('MQTT_USERNAME'))
            ->setPassword(env('MQTT_PASSWORD'))
            ->setUseTls(true)
            ->setTlsSelfSignedAllowed(false);

        $mqtt->connect($connectionSettings, true);

        // 🔥 FIX DI SINI
        if (is_array($message)) {
            $message = json_encode($message);
        }

        $mqtt->publish($topic, $message);

        $mqtt->disconnect();
    }
}