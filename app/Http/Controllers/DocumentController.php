<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Models\StudentDocument;
use App\Models\StudentPersonalInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(StudentPersonalInformation $personalInformation)
    {
        $this->authorize('view', $personalInformation);
        
        $documents = $personalInformation->documents;
        return DocumentResource::collection($documents);
    }

    public function store(StoreDocumentRequest $request, StudentPersonalInformation $personalInformation)
    {
        $this->authorize('update', $personalInformation);
        
        $file = $request->file('file');
        $path = $file->store('documents', 'public');

        $document = $personalInformation->documents()->create([
            'document_name' => $request->document_name,
            'document_type' => $request->document_type,
            'file_path' => $path,
        ]);

        return new DocumentResource($document);
    }

    public function show(StudentDocument $document)
    {
        $this->authorize('view', $document->student);
        
        return new DocumentResource($document);
    }

    public function destroy(StudentDocument $document)
    {
        $this->authorize('delete', $document->student);
        
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return response()->json(null, 204);
    }

    public function markAsComplete(StudentDocument $document)
    {
        $this->authorize('update', $document->student);
        
        $document->update(['is_completed' => true]);

        return new DocumentResource($document);
    }
}