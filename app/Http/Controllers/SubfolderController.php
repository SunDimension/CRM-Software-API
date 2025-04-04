<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubfolderStoreRequest;
use App\Http\Requests\SubfolderUpdateRequest;
use App\Http\Resources\SubfolderCollection;
use App\Http\Resources\SubfolderResource;
use App\Services\AuditTrailService;
use App\Models\Subfolder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubfolderController extends Controller
{
    
 public function index(Request $request): SubfolderCollection
{
    $subfolders = Subfolder::with([
        'primaryFolder' => function ($query) {
            $query->with('company'); // Eager load company with primaryFolder
        }
    ])->get();

    return new SubfolderCollection($subfolders);
}

    public function store(SubfolderStoreRequest $request): SubfolderResource
    {
        $subfolders = Subfolder::create($request->validated());

        AuditTrailService::log('create', $subfolders, null, null, $request);

        return new SubfolderResource($subfolders);
    }

  public function show(Request $request, Subfolder $subfolders): SubfolderResource
{
    // Eager load relationships to prevent N+1 queries
    $subfolders->load(['primaryFolder.company']);
    
    return new SubfolderResource($subfolders);
}

public function update(SubfolderUpdateRequest $request, Subfolder $subfolders): SubfolderResource
{
    $subfolders->update($request->validated());
    
    // Refresh and load relationships before returning
    $subfolders->refresh()->load(['primaryFolder.company']);
    
    return new SubfolderResource($subfolders);
}

  public function destroy($id)
    {   
       
        Subfolder::destroy($id);

        
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
