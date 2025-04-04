<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\FileResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Models\File;
use Illuminate\Support\Facades\Validator;

class FileUploadController extends Controller
{
    public function index(Request $request)
    {
        $files = File::all();
        return response()->json($files);
    }

public function store(Request $request): JsonResponse|FileResource
{
    // Log request data for debugging
    $this->logRequestData($request);

    // Validate the incoming file request
    $validator = $this->validateFileRequest($request);

    if ($validator->fails()) {
        return $this->validationErrorResponse($validator, $request);
    }

    // Store the file and save record in database
    return $this->handleFileUpload($request);
}

/**
 * Log request data for debugging purposes.
 */
private function logRequestData(Request $request): void
{
    Log::info('File upload request received', [
        'request_data' => $request->all(),
        'files' => $_FILES,
    ]);
}

/**
 * Validate the incoming file request.
 */
private function validateFileRequest(Request $request): \Illuminate\Validation\Validator
{
    return Validator::make($request->all(), [
        'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
    ]);
}

/**
 * Return a JSON response with validation errors.
 */
private function validationErrorResponse(\Illuminate\Validation\Validator $validator, Request $request): JsonResponse
{
    return response()->json([
        'errors' => $validator->errors(),
        'request_data' => $request->all(), // Debugging output
    ], 422);
}

/**
 * Handle file upload and database record creation.
 */
private function handleFileUpload(Request $request): JsonResponse|FileResource
{
    if (!$request->hasFile('file')) {
        return response()->json(['message' => 'No file uploaded'], 400);
    }

    try {
        $path = $request->file('file')->store('uploads', 'public');
        $file = File::create(['path' => $path]);

        return new FileResource($file);
    } catch (\Exception $e) {
        Log::error('File upload failed', ['error' => $e->getMessage()]);
        return response()->json(['message' => 'File upload failed', 'error' => $e->getMessage()], 500);
    }
}




    public function show(Request $request, File $file): FileResource
    {
        return new FileResource($file);
    }

    public function destroy($id)
    {
        $file = File::findOrFail($id);

        Storage::delete($file->path);
        $file->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
