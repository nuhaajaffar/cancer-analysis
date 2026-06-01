<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index()
    {
        if (session('user_role') !== 'admin') {
            abort(403);
        }

        $search = request('search');
        $userId = request('user_id');
        $date = request('date');

        $users = \App\Models\User::orderBy('name')->get();

        $auditLogs = AuditLog::with('user')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('action', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('target_type', 'like', "%{$search}%");
                });
            })
            ->when($userId, function ($query, $userId) {
                $query->where('user_id', $userId);
            })
            ->when($date, function ($query, $date) {
                $query->whereDate('created_at', $date);
            })
            ->latest()
            ->get();

        return view('audit-logs.index', compact(
            'auditLogs',
            'users',
            'search',
            'userId',
            'date'
        ));
    }
}