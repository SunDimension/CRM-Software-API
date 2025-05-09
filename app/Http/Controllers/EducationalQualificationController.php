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

    $qualificationsData = $request->validated()['qualifications'];

    $createdQualifications = [];

    foreach ($qualificationsData as $data) {
        // Check for existing qualification_order
        $exists = $personalInformation->educationalQualifications()
            ->where('qualification_order', $data['qualification_order'])
            ->first();

        if ($exists) {
            return response()->json([
                'message' => "Qualification with order {$data['qualification_order']} already exists."
            ], 400);
        }

        $createdQualifications[] = $personalInformation->educationalQualifications()->create($data);
    }

    return EducationalQualificationResource::collection(collect($createdQualifications));
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