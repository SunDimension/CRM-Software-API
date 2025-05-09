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
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null, // Format the date
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null, // Format the date
            'is_completed' => $this->is_completed,

            'application_id' => $this->whenLoaded('application', function () {
                return [
                    'id' => $this->application->id,
                    'name' => $this->application->name,
                    'surname' => $this->application->surname,
                    'email' => $this->application->email,
                    'phone_number' => $this->application->phone_number,
                ];
            }),

      

            'filetype_id' => $this->whenLoaded('fileType', function () {
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