<?php

namespace App\Http\Controllers;

use App\Models\PatientScan;
use App\Models\PatientReport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        $scan->load('patient');

        $reportFileName = 'ai_report_' . $scan->id . '_' . Str::random(8) . '.pdf';

        $relativeReportPath = 'reports/' . $reportFileName;

        $absoluteReportPath = storage_path('app/public/' . $relativeReportPath);

        $reportScript = base_path('ai_int/generate_report.py');

        $reportCommand = 'python '
            . escapeshellarg($reportScript)
            . ' '
            . escapeshellarg($absoluteReportPath)
            . ' '
            . escapeshellarg($scan->patient->name)
            . ' '
            . escapeshellarg($result['prediction'])
            . ' '
            . escapeshellarg($result['confidence']);

        shell_exec($reportCommand);

        PatientReport::create([
            'patient_id' => $scan->patient_id,
            'uploaded_by' => session('user_id'),
            'report_path' => $relativeReportPath,
            'status' => 'ai_generated',
        ]);

        return back()->with('success', 'AI analysis completed.');
    }
}