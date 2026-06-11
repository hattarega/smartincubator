<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cage;
use App\Models\Setting;
use App\Models\Actuator;
use App\Models\SensorReading;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // =========================================
        // CAGE
        // =========================================
        $cage = Cage::create([
            'id' => 1,
            'name' => 'Inkubator 1',

            // mulai 30 hari lalu
            'start_date' => now()->subDays(30),

            'egg_count' => 50,
        ]);

        // =========================================
        // USER
        // =========================================
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('123456')
        ]);

        $user->update([
            'cage_id' => $cage->id
        ]);

        // =========================================
        // SETTING
        // =========================================
        Setting::create([
            'cage_id' => $cage->id,
            'max_temperature' => 37.8,
            'min_humidity' => 65,
        ]);

        // =========================================
        // ACTUATORS
        // =========================================
        $actuators = ['lampu', 'mistmaker'];

        foreach ($actuators as $name) {

            Actuator::firstOrCreate([
                'cage_id' => $cage->id,
                'name' => $name,
            ], [
                'mode' => 'AUTO',
                'state' => 'OFF'
            ]);
        }

        // =========================================
        // SENSOR READING
        // 30 hari • tiap 30 menit
        // =========================================

        $start = Carbon::create(2026, 5, 1, 0, 0, 0);
        $end   = Carbon::create(2026, 5, 28, 23, 30, 0);

        $current = $start->copy();

        while ($current <= $end) {

            $day = $start->diffInDays($current) + 1;

            // =====================================
            // SIKLUS HARIAN
            // =====================================

            $hourDecimal =
                $current->hour +
                ($current->minute / 60);

            $wave = sin(
                ($hourDecimal / 24) * 2 * M_PI
            );

            // =====================================
            // FASE INKUBASI
            // =====================================

            if ($day <= 15) {

                $targetTemp = 38.5;
                $targetHum  = 45;
            } elseif ($day <= 25) {

                $targetTemp = 36.8;
                $targetHum  = 65;
            } else {

                $targetTemp = 36.7;
                $targetHum  = 72;
            }

            // =====================================
            // FLUKTUASI ALAMI
            // =====================================

            $baseTemp =
                $targetTemp +
                ($wave * 0.15);

            $baseHum =
                $targetHum +
                ($wave * 2);

            // =====================================
            // OVERSHOOT HEATER
            // =====================================

            if (rand(1, 100) <= 2) {
                $baseTemp += rand(1, 3) / 10;
            }

            // =====================================
            // AIR TRAY DITAMBAH
            // =====================================

            if (rand(1, 100) <= 3) {
                $baseHum += rand(2, 5);
            }

            // =====================================
            // DHT11
            // =====================================

            SensorReading::create([
                'cage_id' => $cage->id,
                'type' => 'DHT11',

                'temperature' => round(
                    $baseTemp + rand(-8, 8) / 10,
                    1
                ),

                'humidity' => round(
                    $baseHum + rand(-4, 4),
                    1
                ),

                'created_at' => $current,
                'updated_at' => $current,
            ]);

            // =====================================
            // DHT22
            // =====================================

            SensorReading::create([
                'cage_id' => $cage->id,
                'type' => 'DHT22',

                'temperature' => round(
                    $baseTemp + rand(-2, 2) / 10,
                    1
                ),

                'humidity' => round(
                    $baseHum + rand(-1, 1),
                    1
                ),

                'created_at' => $current,
                'updated_at' => $current,
            ]);

            $current->addMinutes(30);
        }
    }
}
