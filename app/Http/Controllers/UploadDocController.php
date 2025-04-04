<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadDocStoreRequest;
use App\Http\Requests\UploadDocUpdateRequest;
use App\Http\Resources\UploadDocCollection;
use App\Http\Resources\UploadDocResource;
use App\Models\UploadDoc;
use App\Mail\DocumentShareMail;
use App\Models\PrimaryFolder;
use App\Models\Upload;
use Illuminate\Support\Facades\Mail;
use App\Models\Subfolder;
use App\Services\AuditTrailService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

class UploadDocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $uploadDocs = UploadDoc::with([
            'upload',
            'subfolder.primaryFolder.company',
            'fileType'
        ])
        ->where('status', 'Approved')
        ->orderBy('created_at', 'desc') // Optional: add sorting
        ->get();

    return UploadDocResource::collection($uploadDocs);
}


    /**
     * Store a newly created resource.
     */
public function store(UploadDocStoreRequest $request)
{
    Log::info('Upload request received', $request->all());
    Log::info('Uploaded file:', ['file' => $request->file('attach_file')]);

    if (!$request->hasFile('attach_file')) {
        return response()->json(['message' => 'File not received by server'], 400);
    }

    $file = $request->file('attach_file');
       Log::info('File details:', [
        'original_name' => $file->getClientOriginalName(),
        'mime_type' => $file->getMimeType(),
        'size' => $file->getSize(),
    ]);

    $filePath = $file->store('uploads','public'); // Save to storage/uploads


       Log::info('Saving file:', [
        'file_name' => $file->getClientOriginalName(),
        'file_path' => $filePath,
    ]);
    // ✅ Save to upload table and get ID
    $upload = Upload::create([
        'file_name' => $file->getClientOriginalName(),
        'file_path' => $filePath,
    ]);

    if (!$upload) {
        Log::error('Upload failed!');
        return response()->json(['message' => 'Upload failed'], 500);
    }

    Log::info('Upload saved successfully', ['upload_id' => $upload->id]);

    // ✅ Save document record
    $uploadDoc = UploadDoc::create([
        'file_title' => $request->file_title,
        'file_description' => $request->file_description,
        'financial_value' =>$request->financial_value,
        'file_expiry_date'=>$request->file_expiry_date,
        'subfolder_id' => $request->subfolder_id,
        'filetype_id' => $request->filetype_id,
        'attach_file' => $upload->id, // ✅ Save uploaded file ID
    ]);

       AuditTrailService::log('create', $uploadDoc, null, null, $request);

$uploadDoc->load('upload');

    return response()->json([
        'message' => 'Upload successful',
        'upload_doc' => new UploadDocResource($uploadDoc),
    ], 201);
}

public function pending(Request $request): UploadDocCollection
{
    $bankRemit = UploadDoc::where('status', 'pending')
        ->with([
            'subfolder.primaryFolder.company', // ✅ Load subfolder, primary folder, and company
            'fileType',
            'upload'
        ])->get();
        
    return new UploadDocCollection($bankRemit);
}

    public function approve(Request $request)
{
    Log::info('Approving Uploads.', ['request_data' => $request->all()]);

    $validated = $request->validate([
        'comment' => ['nullable'],
        'status' => ['required', 'string'],
        'id' => ['required']
    ]);

    $uploadDoc = UploadDoc::findOrFail($validated['id']);
    
    // Capture ALL old values before making any changes
    $oldValues = $uploadDoc->getOriginal(); // Use getOriginal() to get raw DB values
    
    $uploadDoc->approval_comment = $validated['comment'];
    $uploadDoc->status = $validated['status'];
    $uploadDoc->approved_by = auth()->user()->id;
    $uploadDoc->approval_date = now();
    $uploadDoc->save();

    // Log the approval action with old values and let service capture new values automatically
    AuditTrailService::log('approve', $uploadDoc, $oldValues, null, $request);

    Log::info('Upload Document approved.', [
        'id' => $validated['id'], 
        'status' => $validated['status']
    ]);

    return new UploadDocResource($uploadDoc);
}
    /**
     * Display the specified resource.
     */
public function show($id)
{
    $uploadDoc = UploadDoc::with([
        'subfolder.primaryFolder.company',
        'fileType',
        'upload'
    ])->find($id);

    if (!$uploadDoc) {
        return response()->json([
            'message' => 'Document not found',
            'success' => false
        ], 404);
    }
    
    return new UploadDocResource($uploadDoc);
}

    /**
     * Update the specified resource.
     */
public function update(UploadDocUpdateRequest $request, $id)
{
    $uploadDoc = UploadDoc::find($id);
    
    if (!$uploadDoc) {
        return response()->json([
            'message' => 'Document not found',
            'success' => false
        ], 404);
    }

    // Capture old values
    $oldValues = $uploadDoc->getAttributes();
    
    // Handle file upload if present
    if ($request->hasFile('attach_file')) {
        $file = $request->file('attach_file');
        $path = $file->store('uploads', 'public');
        
        // Create new upload record
        $upload = Upload::create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path
        ]);
        
        $request->merge(['attach_file' => $upload->id]);
    }

    $uploadDoc->update($request->validated());
    
    AuditTrailService::log('update', $uploadDoc, $oldValues, null, $request);
    
    return new UploadDocResource($uploadDoc->fresh(['subfolder', 'fileType', 'upload']));
}

    /**
     * Remove the specified resource.
     */
    public function destroy($id)
    {
        $uploadDoc = UploadDoc::findOrFail($id);
        $uploadDoc->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }



public function filterUploads(Request $request)
{
    try {

    Log::info('Incoming request data:', $request->all());
        // Validate the request
        $validated = $request->validate([
            'company_id' => 'nullable|integer|exists:companies,id',
            'primary_folder_id' => 'nullable|integer|exists:primary_folders,id',
            'subfolder_id' => 'nullable|integer|exists:subfolders,id',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
             'share_method' => 'nullable|string|in:email,whatsapp,link,copy',
             'recipients' => 'nullable|array',
             'recipients.*' => 'email'
        ]);

        Log::info('Validated data:', $validated);

        // Log the received filters
        Log::info('Filtering uploads with parameters:', $validated);

        // Initialize query with relations
        $query = UploadDoc::with(['upload', 'subfolder.primaryFolder.company', 'fileType']);

        // Apply filters dynamically
        foreach (['company_id', 'primary_folder_id', 'subfolder_id'] as $filter) {
            if (!empty($validated[$filter])) {
                Log::info("Applying filter: $filter = " . $validated[$filter]);
                $query->whereHas('subfolder.primaryFolder.company', function ($q) use ($filter, $validated) {
                    $q->where('id', $validated[$filter]);
                });
            }
        }

        // Handle date filters
        if (!empty($validated['from_date']) || !empty($validated['to_date'])) {
            $fromDate = !empty($validated['from_date']) ? Carbon::parse($validated['from_date'])->startOfDay() : null;
            $toDate = !empty($validated['to_date']) ? Carbon::parse($validated['to_date'])->endOfDay() : null;

            Log::info("Applying date filters: from_date = $fromDate, to_date = $toDate");

            $query->when($fromDate, fn($q) => $q->where('created_at', '>=', $fromDate));
            $query->when($toDate, fn($q) => $q->where('created_at', '<=', $toDate));
        }

                if ($request->share_method) {
            return $this->handleDocumentSharing($query->get(), $validated);
        }

        return UploadDocResource::collection($query->paginate($request->get('per_page', 15)));

    } catch (\Exception $e) {
        Log::error('Error sharing documents:', ['error' => $e->getMessage()]);
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    



    /**
     * Fetch primary folders for a given company.
     */
    public function getPrimaryFolders(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'company_id' => 'required|integer|exists:companies,id',
            ]);

            Log::info('Fetching primary folders for company_id: ' . $validated['company_id']);

            // Retrieve primary folders
            $primaryFolders = PrimaryFolder::where('company_id', $validated['company_id'])->get();

            Log::info('Primary Folders Found:', $primaryFolders->toArray());

            return response()->json(['success' => true, 'data' => $primaryFolders]);

        } catch (\Exception $e) {
            Log::error('Error fetching primary folders:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while fetching primary folders.'], 500);
        }
    }

    public function getSubfolders(Request $request)
{
    try {
        // Validate the request
        $validated = $request->validate([
            'primary_folder_id' => 'required|integer|exists:primary_folders,id',
        ]);

        // Fetch subfolders for the selected primary folder
        $subfolders = Subfolder::where('primary_folder_id', $validated['primary_folder_id'])->get();

        // Return the subfolders as a JSON response
        return response()->json(['success' => true, 'data' => $subfolders]);

    } catch (\Exception $e) {
        // Handle any exceptions
        return response()->json(['error' => 'An error occurred while fetching subfolders.'], 500);
    }
}

public function shareDocument(Request $request)
{

    
    try {

    Log::info('Incoming request data:', $request->all());
        // Validate the request
        $validated = $request->validate([
            'company_id' => 'nullable|integer|exists:companies,id',
            'primary_folder_id' => 'nullable|integer|exists:primary_folders,id',
            'subfolder_id' => 'nullable|integer|exists:subfolders,id',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'share_method' => 'nullable|string|in:email,whatsapp,link,copy', // New validation
            'recipients' => 'nullable|array', // For email sharing
            'recipients.*' => 'email' 
        ]);

        Log::info('Validated data:', $validated);

        // Log the received filters
        Log::info('Filtering uploads with parameters:', $validated);

        // Initialize query with relations
        $query = UploadDoc::with(['upload', 'subfolder.primaryFolder.company', 'fileType']);

        // Apply filters dynamically
        foreach (['company_id', 'primary_folder_id', 'subfolder_id'] as $filter) {
            if (!empty($validated[$filter])) {
                Log::info("Applying filter: $filter = " . $validated[$filter]);
                $query->whereHas('subfolder.primaryFolder.company', function ($q) use ($filter, $validated) {
                    $q->where('id', $validated[$filter]);
                });
            }
        }

        // Handle date filters
        if (!empty($validated['from_date']) || !empty($validated['to_date'])) {
            $fromDate = !empty($validated['from_date']) ? Carbon::parse($validated['from_date'])->startOfDay() : null;
            $toDate = !empty($validated['to_date']) ? Carbon::parse($validated['to_date'])->endOfDay() : null;

            Log::info("Applying date filters: from_date = $fromDate, to_date = $toDate");

            $query->when($fromDate, fn($q) => $q->where('created_at', '>=', $fromDate));
            $query->when($toDate, fn($q) => $q->where('created_at', '<=', $toDate));
        }
         if ($request->share_method) {
            return $this->handleDocumentSharing($query->get(), $validated);
        }
        // Paginate results
        $perPage = $request->get('per_page', 15);
        Log::info("Paginating results with per_page = $perPage");

        $uploadDocs = $query->paginate($perPage);

        return UploadDocResource::collection($uploadDocs);

    } catch (\Exception $e) {
        Log::error('Error filtering uploads:', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'An error occurred while filtering uploads.'], 500);
    }
}


private function handleDocumentSharing($documents, $data)
{
    try {
        $shareableLinks = $documents->map(function ($doc) {
            return [
                'id' => $doc->id,
                'title' => $doc->file_title,
                'url' => $doc->upload->file_url,
                'expires_at' => now()->addDays(7)->format('Y-m-d H:i:s')
            ];
        });

        switch ($data['share_method']) {
            case 'email':
                if (empty($data['recipients'])) {
                    throw new \Exception('No email recipients specified');
                }

                Mail::to($data['recipients'])
                    ->send(new DocumentShareMail($shareableLinks->toArray()));
                
                return response()->json([
                    'success' => true,
                    'message' => 'Documents shared successfully via email'
                ]);

            case 'whatsapp':
                $whatsappLinks = $shareableLinks->map(function ($doc) {
                    return 'https://wa.me/?text=' . urlencode("Check this document: {$doc['title']} - {$doc['url']}");
                });
                return response()->json([
                    'success' => true,
                    'whatsapp_links' => $whatsappLinks
                ]);

            case 'link':
                return response()->json([
                    'success' => true,
                    'shareable_links' => $shareableLinks
                ]);

            case 'copy':
                return response()->json([
                    'success' => true,
                    'text_to_copy' => $shareableLinks->pluck('url')->implode("\n")
                ]);

            default:
                throw new \Exception('Invalid share method specified');
        }
    } catch (\Exception $e) {
        Log::error('Document sharing failed: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
}