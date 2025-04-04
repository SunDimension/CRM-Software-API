<?php
// app/Http/Controllers/AuditTrailController.php

namespace App\Http\Controllers;

use App\Http\Resources\AuditTrailCollection;
use App\Http\Resources\AuditTrailResource;
use App\Models\AuditTrail;
use Illuminate\Http\Request;

class AuditTrailController extends Controller
{
public function index(Request $request)
{
    $query = AuditTrail::with(['user'])
        ->latest();

    // Date range filtering
    if ($request->has('from_date') && $request->has('to_date')) {
        $query->whereBetween('created_at', [
            $request->from_date . ' 00:00:00',
            $request->to_date . ' 23:59:59'
        ]);
    }

    // Action filtering
    if ($request->has('action')) {
        $query->where('action', $request->action);
    }

    return new AuditTrailCollection($query->paginate());
}

    public function show(AuditTrail $auditTrail)
    {
        return new AuditTrailResource($auditTrail->load(['user', 'model']));
    }
}