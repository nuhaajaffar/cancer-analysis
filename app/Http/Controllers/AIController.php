<?php

namespace App\Http\Controllers;

use App\Models\PatientScan;
use Illuminate\Http\Request;

class AIController extends Controller
{
    public function analyse($scanId)
    {
        $scan = PatientScan::findOrFail($scanId);

        $scanPath = storage_path('app/public/' . $scan->file_path);

        $pythonScript = base_path('ai_int/analyse_scan.py');

        $command = 'python '
            . escapeshellarg($pythonScript)
            . ' '
            . escapeshellarg($scanPath);

        $output = shell_exec($command);

        $result = json_decode($output, true);

        if (!$result) {
            return back()->withErrors([
                'ai' => 'AI analysis failed.',
            ]);
        }

        $scan->update([
            'ai_prediction' => $result['prediction'],
            'ai_confidence' => $result['confidence'],
            'ai_status' => 'completed',
        ]);

        return back()->with('success', 'AI analysis completed.');
    }
}