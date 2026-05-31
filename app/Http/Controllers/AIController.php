<?php

namespace App\Http\Controllers;

use App\Models\PatientScan;
use App\Models\PatientReport;
use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AIController extends Controller
{
    public function analyse($scanId)
    {
        $scan = PatientScan::with('patient')->findOrFail($scanId);

        if ($scan->ai_status === 'completed') {
            return back()->withErrors([
                'ai' => 'This scan has already been analysed.',
            ]);
        }

        $scan->update([
            'ai_status' => 'processing',
        ]);

        $scanPath = storage_path('app/public/' . $scan->file_path);
        $pythonScript = base_path('ai_int/analyse_scan.py');

        if (!file_exists($scanPath)) {
            $scan->update(['ai_status' => 'failed']);

            return back()->withErrors([
                'ai' => 'Scan file not found.',
            ]);
        }

        if (!file_exists($pythonScript)) {
            $scan->update(['ai_status' => 'failed']);

            return back()->withErrors([
                'ai' => 'AI script not found.',
            ]);
        }

        $command = 'python '
            . escapeshellarg($pythonScript)
            . ' '
            . escapeshellarg($scanPath);

        $output = shell_exec($command);

        $result = json_decode($output, true);

        if (!$result || !isset($result['prediction'], $result['confidence'])) {
            $scan->update(['ai_status' => 'failed']);

            return back()->withErrors([
                'ai' => 'AI analysis failed.',
            ]);
        }

        $scan->update([
            'ai_prediction' => $result['prediction'],
            'ai_confidence' => $result['confidence'],
            'ai_status' => 'completed',
        ]);

        $reportFileName = 'ai_report_' . $scan->id . '_' . Str::random(8) . '.pdf';
        $relativeReportPath = 'reports/' . $reportFileName;
        $absoluteReportPath = storage_path('app/public/' . $relativeReportPath);
        $reportScript = base_path('ai_int/generate_report.py');

        if (!file_exists($reportScript)) {
            $scan->update(['ai_status' => 'failed']);

            return back()->withErrors([
                'ai' => 'Report generation script not found.',
            ]);
        }

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

        if (!file_exists($absoluteReportPath)) {
            $scan->update(['ai_status' => 'failed']);

            return back()->withErrors([
                'ai' => 'AI report PDF could not be generated.',
            ]);
        }

        PatientReport::create([
            'patient_id' => $scan->patient_id,
            'uploaded_by' => session('user_id'),
            'report_path' => $relativeReportPath,
            'status' => 'ai_generated',
        ]);

        if ($scan->patient->assigned_doctor_id) {
            AppNotification::create([
                'user_id' => $scan->patient->assigned_doctor_id,
                'title' => 'AI Report Generated',
                'message' => 'An AI-generated report is available for ' . $scan->patient->name . '.',
                'type' => 'ai_report_generated',
            ]);
        }

        return back()->with('success', 'AI analysis and report generation completed.');
    }
}