<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Http\Resources\UploadDocResource;
use App\Http\Requests\UploadDocStoreRequest;
use App\Models\StudentDocument;
use App\Models\UploadDoc;
use App\Models\Upload;
use App\Models\StudentPersonalInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    public function index(StudentPersonalInformation $personalInformation)
    {
        $this->authorize('view', $personalInformation);
        
        $documents = $personalInformation->documents;
        return DocumentResource::collection($documents);
    }

  public function store(UploadDocStoreRequest $request)
{
    DB::beginTransaction();
    
    try {
        Log::info('Upload request received', $request->except('attach_file'));
        
        if (!$request->hasFile('attach_file')) {
            return response()->json(['message' => 'File not received by server'], 400);
        }

        $file = $request->file('attach_file');
        
        Log::info('File details:', [
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $this->formatSizeUnits($file->getSize()),
        ]);

        $filePath = $file->store('uploads', 'public');

        // Save to upload table
        $upload = Upload::create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
        ]);

        if (!$upload) {
            throw new \Exception('Failed to create upload record');
        }

        // Save to upload_doc table
        $uploadDoc = UploadDoc::create([
            'file_title' => $request->document_name,
            'application_id' => $request->application_id,
            'filetype_id' => $request->filetype_id,
            'attach_file' => $upload->id,
        ]);

        DB::commit();

        Log::info('Upload saved successfully', [
            'upload_id' => $upload->id,
            'upload_doc_id' => $uploadDoc->id
        ]);

        $uploadDoc->load('upload');

        return response()->json([
            'message' => 'Upload successful',
            'upload_doc' => new UploadDocResource($uploadDoc),
        ], 201);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Upload failed: ' . $e->getMessage());
        return response()->json(['message' => 'Upload failed: ' . $e->getMessage()], 500);
    }
}

private function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
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