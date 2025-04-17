<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEducationalQualificationRequest;
use App\Http\Resources\EducationalQualificationResource;
use App\Models\StudentEducationalQualification;
use App\Models\StudentPersonalInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationalQualificationController extends Controller
{
    public function index(StudentPersonalInformation $personalInformation)
    {
        $this->authorize('view', $personalInformation);
        
        $qualifications = $personalInformation->educationalQualifications;
        return EducationalQualificationResource::collection($qualifications);
    }

    public function store(StoreEducationalQualificationRequest $request, StudentPersonalInformation $personalInformation)
    {
        $this->authorize('update', $personalInformation);
        
        // Check if qualification with this order already exists
        $existing = $personalInformation->educationalQualifications()
            ->where('qualification_order', $request->qualification_order)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Qualification with this order already exists'], 400);
        }

        $qualification = $personalInformation->educationalQualifications()->create($request->validated());

        return new EducationalQualificationResource($qualification);
    }

    public function show(StudentEducationalQualification $educationalQualification)
    {
        $this->authorize('view', $educationalQualification->student);
        
        return new EducationalQualificationResource($educationalQualification);
    }

    public function update(StoreEducationalQualificationRequest $request, StudentEducationalQualification $educationalQualification)
    {
        $this->authorize('update', $educationalQualification->student);
        
        $educationalQualification->update($request->validated());

        return new EducationalQualificationResource($educationalQualification);
    }

    public function destroy(StudentEducationalQualification $educationalQualification)
    {
        $this->authorize('delete', $educationalQualification->student);
        
        $educationalQualification->delete();

        return response()->json(null, 204);
    }

    public function markAsComplete(StudentEducationalQualification $educationalQualification)
    {
        $this->authorize('update', $educationalQualification->student);
        
        $educationalQualification->update(['is_completed' => true]);

        return new EducationalQualificationResource($educationalQualification);
    }
}