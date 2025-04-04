<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileStatusStoreRequest;
use App\Http\Requests\FileStatusUpdateRequest;
use App\Http\Resources\FileStatusCollection;
use App\Http\Resources\FileStatusResource;
use App\Models\FileStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FileStatusController extends Controller
{
    
    public function index(Request $request): FileStatusCollection
    {
        $filestatuses = FileStatus::all();

        return new FileStatusCollection($filestatuses);
    }

    public function store(FileStatusStoreRequest $request): FileStatusResource
    {
        $filestatuses = FileStatus::create($request->validated());

        return new FileStatusResource($filestatuses);
    }

    public function show(Request $request, FileStatus $filestatuses): FileStatusResource
    {
        return new FileStatusResource($filestatuses);
    }

    public function update(FileStatusUpdateRequest $request, FileStatus $filestatus): FileStatusResource
    {
        $filestatus->update($request->validated());

        return new FileStatusResource($filestatus);
    }

  public function destroy($id)
    {   
       
        FileStatus::destroy($id);

        
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
