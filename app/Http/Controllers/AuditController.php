<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuditActionStoreRequest;
use App\Http\Requests\AuditActionUpdateRequest;
use App\Http\Resources\AuditActionCollection;
use App\Http\Resources\AuditActionResource;
use App\Models\AuditAction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuditActionController extends Controller
{
    
    public function index(Request $request): AuditActionCollection
    {
        $auditaction = AuditAction::all();

        return new AuditActionCollection($auditaction);
    }

    public function store(AuditActionStoreRequest $request): AuditActionResource
    {
        $auditaction = AuditAction::create($request->validated());

        return new AuditActionResource($auditaction);
    }

    public function show(Request $request, AuditAction $auditaction): AuditActionResource
    {
        return new AuditActionResource($auditaction);
    }

    public function update(AuditActionUpdateRequest $request, AuditAction $auditaction): AuditActionResource
    {
        $auditaction->update($request->validated());

        return new AuditActionResource($auditaction);
    }

  public function destroy($id)
    {   
       
        AuditAction::destroy($id);

        
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
