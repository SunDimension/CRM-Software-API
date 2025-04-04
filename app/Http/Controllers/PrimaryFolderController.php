<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrimaryFolderStoreRequest;
use App\Http\Requests\PrimaryFolderUpdateRequest;
use App\Http\Resources\PrimaryFolderCollection;
use App\Http\Resources\PrimaryFolderResource;
use App\Services\AuditTrailService;
use App\Models\PrimaryFolder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class PrimaryFolderController extends Controller
{
    public function index(Request $request): PrimaryFolderCollection
{
    $query = PrimaryFolder::with('company', 'year');

    if ($request->has('company_id')) {
        $query->where('company_id', $request->company_id);
    }

    $primaryfolders = $query->get();

    return new PrimaryFolderCollection($primaryfolders);
}


    public function store(PrimaryFolderStoreRequest $request): PrimaryFolderResource
    {
        $primaryfolders = PrimaryFolder::create($request->validated());

         AuditTrailService::log('create', $primaryfolders, null, null, $request);

        return new PrimaryFolderResource($primaryfolders);
    }

   public function show(Request $request, PrimaryFolder $primaryfolders): PrimaryFolderResource
{
    // Eager load the company relationship
    $primaryfolders->load('company');
    
    return new PrimaryFolderResource($primaryfolders);
}

     public function update(PrimaryFolderUpdateRequest $request, PrimaryFolder $primaryFolder): JsonResponse|PrimaryFolderResource
    {
        // Verify the model exists
        if (!$primaryFolder->exists) {
            return response()->json(['message' => 'Primary folder not found'], 404);
        }

        try {
            $primaryFolder->update($request->validated());
            
            // Refresh the model to get updated values
            $primaryFolder->refresh();
            
            // Load relationships if needed
            $primaryFolder->load(['company', 'year']);
            Log::info('Updating primary folder', [
    'id' => $primaryFolder->id,
    'input' => $request->validated(),
    'before' => $primaryFolder->toArray()
]);
            
            return new PrimaryFolderResource($primaryFolder);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

  public function destroy($id)
    {   
       
        PrimaryFolder::destroy($id);

        
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
