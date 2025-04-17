<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmergencyContactRequest;
use App\Http\Resources\EmergencyContactResource;
use App\Models\StudentEmergencyContact;
use App\Models\StudentPersonalInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmergencyContactController extends Controller
{
    public function index(StudentPersonalInformation $personalInformation)
    {
        $this->authorize('view', $personalInformation);
        
        $contacts = $personalInformation->emergencyContacts;
        return EmergencyContactResource::collection($contacts);
    }

    public function store(StoreEmergencyContactRequest $request, StudentPersonalInformation $personalInformation)
    {
        $this->authorize('update', $personalInformation);
        
        $contact = $personalInformation->emergencyContacts()->create($request->validated());

        return new EmergencyContactResource($contact);
    }

    public function show(StudentEmergencyContact $emergencyContact)
    {
        $this->authorize('view', $emergencyContact->student);
        
        return new EmergencyContactResource($emergencyContact);
    }

    public function update(StoreEmergencyContactRequest $request, StudentEmergencyContact $emergencyContact)
    {
        $this->authorize('update', $emergencyContact->student);
        
        $emergencyContact->update($request->validated());

        return new EmergencyContactResource($emergencyContact);
    }

    public function destroy(StudentEmergencyContact $emergencyContact)
    {
        $this->authorize('delete', $emergencyContact->student);
        
        $emergencyContact->delete();

        return response()->json(null, 204);
    }

    public function markAsComplete(StudentEmergencyContact $emergencyContact)
    {
        $this->authorize('update', $emergencyContact->student);
        
        $emergencyContact->update(['is_completed' => true]);

        return new EmergencyContactResource($emergencyContact);
    }
}