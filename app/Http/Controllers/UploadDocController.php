<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UploadDocResource;
use App\Models\UploadDoc;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadDocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $uploadDocs = UploadDoc::with(['fileType', 'upload'])
            ->orderBy('created_at', 'desc')
            ->get();

        return UploadDocResource::collection($uploadDocs);
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'file_title' => 'required|string|max:255',
            'filetype_id' => 'required|integer|exists:file_types,id',
            'attach_file' => 'required|file|max:10240', // Max 10MB
        ]);

        try {
            // Handle file upload
            $file = $request->file('attach_file');
            $filePath = $file->store('uploads', 'public');

            // Save file details in the Upload table
            $upload = Upload::create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
            ]);

            // Save document details in the UploadDoc table
            $uploadDoc = UploadDoc::create([
                'file_title' => $validated['file_title'],
                'filetype_id' => $validated['filetype_id'],
                'attach_file' => $upload->id,
            ]);

            return response()->json([
                'message' => 'Document uploaded successfully.',
                'upload_doc' => new UploadDocResource($uploadDoc),
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error uploading document:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to upload document.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $uploadDoc = UploadDoc::with(['fileType', 'upload'])->find($id);

        if (!$uploadDoc) {
            return response()->json(['message' => 'Document not found.'], 404);
        }

        return new UploadDocResource($uploadDoc);
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, $id)
    {
        $uploadDoc = UploadDoc::find($id);

        if (!$uploadDoc) {
            return response()->json(['message' => 'Document not found.'], 404);
        }

        $validated = $request->validate([
            'file_title' => 'required|string|max:255',
            'filetype_id' => 'required|integer|exists:file_types,id',
            'attach_file' => 'nullable|file|max:10240', // Max 10MB
        ]);

        try {
            // Handle file upload if a new file is provided
            if ($request->hasFile('attach_file')) {
                $file = $request->file('attach_file');
                $filePath = $file->store('uploads', 'public');

                // Save new file details in the Upload table
                $upload = Upload::create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $filePath,
                ]);

                $uploadDoc->attach_file = $upload->id;
            }

            // Update document details
            $uploadDoc->update([
                'file_title' => $validated['file_title'],
                'filetype_id' => $validated['filetype_id'],
            ]);

            return response()->json([
                'message' => 'Document updated successfully.',
                'upload_doc' => new UploadDocResource($uploadDoc),
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating document:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to update document.'], 500);
        }
    }

    /**
     * Remove the specified resource.
     */
    public function destroy($id)
    {
        $uploadDoc = UploadDoc::find($id);

        if (!$uploadDoc) {
            return response()->json(['message' => 'Document not found.'], 404);
        }

        try {
            // Delete associated file from storage
            $upload = $uploadDoc->upload;
            if ($upload) {
                Storage::disk('public')->delete($upload->file_path);
                $upload->delete();
            }

            // Delete the document record
            $uploadDoc->delete();

            return response()->json(['message' => 'Document deleted successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting document:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to delete document.'], 500);
        }
    }
}