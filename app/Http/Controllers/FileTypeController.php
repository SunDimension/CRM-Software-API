<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileTypeStoreRequest;
use App\Http\Requests\FileTypeUpdateRequest;
use App\Http\Resources\FileTypeCollection;
use App\Http\Resources\FileTypeResource;
use App\Services\AuditTrailService;
use App\Models\FileType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FileTypeController extends Controller
{
    
    public function index(Request $request): FileTypeCollection
    {
        $filetype = FileType::all();

        return new FileTypeCollection($filetype);
    }

    public function store(FileTypeStoreRequest $request): FileTypeResource
    {
        $filetype = FileType::create($request->validated());

        
          AuditTrailService::log('create', $filetype, null, null, $request);

        return new FileTypeResource($filetype);
    }

    public function show(Request $request, FileType $filetype): FileTypeResource
    {
        return new FileTypeResource($filetype);
    }

    public function update(FileTypeUpdateRequest $request, FileType $filetype): FileTypeResource
    {
        $filetype->update($request->validated());

        
          AuditTrailService::log('update', $filetype, null, null, $request);

        return new FileTypeResource($filetype);
    }

  public function destroy($id)
    {   
       
        FileType::destroy($id);

        
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
