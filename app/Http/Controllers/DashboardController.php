<?php

namespace App\Http\Controllers;

use App\Models\SensorReading;
use App\Events\ActuatorUpdated;
use App\Events\SensorUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Actuator;
use Illuminate\Support\Facades\Auth;
use App\Models\Cage;
use App\Models\LatestReading;
use App\Models\Setting;
use App\Services\MqttService;
use Laravel\Reverb\Loggers\Log;
use App\Exports\SuhuKelembapanExport;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $cage = $user->cage;

        $actuators = []; // default biar aman
        $day = null;

        if ($cage) {

            $day = floor(
                \Carbon\Carbon::parse($cage->start_date)
                    ->diffInHours(now()) / 24
            ) + 1;

            $actuators = Actuator::where('cage_id', $cage->id)->get();
        }

        return view('dashboard', [
            'cage' => $cage,
            'day' => $day,
            'actuators' => $actuators
        ]);
    }

    public function updateDate(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date',
        ]);

        $cage = Cage::findOrFail($id);
        $cage->start_date = $request->start_date;
        $cage->save();

        return back()->with('success', 'Tanggal kandang berhasil diperbarui!');
    }

    public function updateEgg(Request $request, $id)
    {
        $request->validate([
            'egg_count' => 'required|integer|min:0',
        ]);

        $cage = Cage::findOrFail($id);
        $cage->egg_count = $request->egg_count;
        $cage->save();

        return back()->with('success', 'Jumlah telur berhasil diperbarui!');
    }

    public function updateTemperature(Request $request)
    {
        $request->validate([
            'max_temperature' => 'nullable|numeric',
        ]);

        $cage = Auth::user()?->cage;
 
        if (!$cage) {
            return back()->with('error', 'Kandang belum dibuat');
        }

        Setting::updateOrCreate(
            ['cage_id' => $cage->id],
            [
                'max_temperature' => $request->max_temperature ?: null,
            ]
        );

        // Publish ke MQTT
        if ($request->max_temperature) {
            app(MqttService::class)->publish(
                "cage/{$cage->id}/setting",
                json_encode([
                    'max_temperature' => (float) $request->max_temperature
                ])
            );
        }

        return back()->with('success', 'Batas suhu berhasil diupdate');
    }

    public function updateHumidity(Request $request)
    {
        $request->validate([
            'min_humidity' => 'nullable|numeric',
        ]);

        $cage = Auth::user()?->cage;

        if (!$cage) {
            return back()->with('error', 'Kandang belum dibuat');
        }

        Setting::updateOrCreate(
            ['cage_id' => $cage->id],
            [
                'min_humidity' => $request->min_humidity ?: null,
            ]
        );

        // Publish ke MQTT
        if ($request->min_humidity) {
            app(MqttService::class)->publish(
                "cage/{$cage->id}/setting",
                json_encode([
                    'min_humidity' => (float) $request->min_humidity
                ])
            );
        }


        return back()->with('success', 'Batas Kelembapan berhasil diupdate');
    }

    public function showSensor()
    {
        // Ambil data terbaru dari 1 kandang
        $latest = LatestReading::where('cage_id', 1)->first();

        event(new SensorUpdated($latest));

        return view('dashboard', compact('latest'));
    }

    public function toggle(Request $request)
    {
        $actuator = Actuator::findOrFail($request->id);

        $actuator->mode = 'MANUAL';
        $actuator->state = $actuator->state == 'ON' ? 'OFF' : 'ON';
        $actuator->save();

        app(MqttService::class)->publish(
            "cage/{$actuator->cage_id}/actuator/set",
            json_encode([
                'name' => $actuator->name,
                'mode' => 'MANUAL',
                'state' => $actuator->state
            ])
        );

        event(new ActuatorUpdated($actuator));
        Log::info('MQTT PUBLISH BERHASIL');
        return response()->json($actuator);
    }

    public function setAuto(Request $request)
    {
        $actuator = Actuator::findOrFail($request->id);

        $actuator->mode = 'AUTO';
        $actuator->save();

        app(MqttService::class)->publish(
            "cage/{$actuator->cage_id}/actuator/set",
            json_encode([
                'name' => $actuator->name,
                'mode' => 'AUTO'
            ])
        );

        event(new ActuatorUpdated($actuator));
        return response()->json($actuator);
    }

    public function chartData(Request $request)
    {
        $date = $request->date ?? Carbon::today()->toDateString();

        $data = SensorReading::whereDate('created_at', $date)
            ->orderBy('created_at')
            ->get();

        return response()->json($data);
    }
public function export(Request $request)
{
    $date  = $request->date;
    $query = \App\Models\SensorReading::orderBy('created_at', 'asc');
    if ($date) $query->whereDate('created_at', $date);
    $rows = $query->get();

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    // Header
    $sheet->fromArray([
        'No', 'Tanggal & Waktu', 'Tipe Sensor', 'Suhu (°C)', 'Kelembapan (%)'
    ], null, 'A1');

    // Data
    foreach ($rows as $i => $row) {
        $sheet->fromArray([
            $i + 1,
            $row->created_at->format('d/m/Y H:i:s'),
            strtoupper($row->type),
            $row->temperature,
            $row->humidity,
        ], null, 'A' . ($i + 2));
    }

    $fileName = 'riwayat-suhu-kelembapan' . ($date ? "_$date" : '') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
}
