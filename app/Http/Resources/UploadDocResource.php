<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UploadDocResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'file_title' => $this->file_title,
            'file_description' => $this->file_description,
            'financial_value' => $this->financial_value,
            'file_expiry_date' => $this->file_expiry_date,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null, // Format the date

            'sub_folder' => $this->whenLoaded('subfolder', function () {
                return [
                    'id' => $this->subfolder_id,
                    'name' => optional($this->subfolder)->name,
                ];
            }),

            'primary_folder' => $this->whenLoaded('subfolder', function () {
                return $this->subfolder->primaryFolder ? [
                    'id' => $this->subfolder->primaryFolder->id,
                    'name' => $this->subfolder->primaryFolder->name,
                ] : null;
            }),

            'company' => $this->whenLoaded('subfolder', function () {
                return $this->subfolder->primaryFolder && $this->subfolder->primaryFolder->company ? [
                    'id' => $this->subfolder->primaryFolder->company->id,
                    'name' => $this->subfolder->primaryFolder->company->name,
                ] : null;
            }),

            'file_type' => $this->whenLoaded('fileType', function () {
                return [
                    'id' => $this->fileType->id ?? null,
                    'name' => optional($this->fileType)->name,
                ];
            }),
    'attach_file' => $this->upload ? [
    'id' => $this->upload->id,
    'name' => $this->upload->file_name,
    'file_path' => $this->upload->file_path, // Actual storage path
    'file_url' => asset('storage/' . $this->upload->file_path), // Public URL
    'mime_type' => Storage::mimeType('public/' . $this->upload->file_path)?:
          $this->guessMimeType($this->upload->file_name), // File type
] : null,


        ];
    }

    private function guessMimeType(string $filename): string
{
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    return match($extension) {
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        default => 'application/octet-stream',
    };

}
}