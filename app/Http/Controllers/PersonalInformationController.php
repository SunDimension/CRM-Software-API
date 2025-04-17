<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonalInformationRequest;
use App\Http\Requests\UpdatePersonalInformationRequest;
use App\Http\Resources\PersonalInformationResource;
use App\Models\StudentPersonalInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalInformationController extends Controller
{
    public function index()
    {
        $personalInfo = StudentPersonalInformation::where('user_id', Auth::id())->first();
        
        if (!$personalInfo) {
            return response()->json(['message' => 'No personal information found'], 404);
        }

        return new PersonalInformationResource($personalInfo);
    }

    public function store(StorePersonalInformationRequest $request)
    {
        $personalInfo = StudentPersonalInformation::where('user_id', Auth::id())->first();

        if ($personalInfo) {
            return response()->json(['message' => 'Personal information already exists'], 400);
        }

        $personalInfo = StudentPersonalInformation::create([
            'user_id' => Auth::id(),
            ...$request->validated()
        ]);

        return new PersonalInformationResource($personalInfo);
    }

    public function show(StudentPersonalInformation $personalInformation)
    {
        $this->authorize('view', $personalInformation);
        return new PersonalInformationResource($personalInformation);
    }

    public function update(UpdatePersonalInformationRequest $request, StudentPersonalInformation $personalInformation)
    {
        $this->authorize('update', $personalInformation);
        
        $personalInformation->update($request->validated());

        return new PersonalInformationResource($personalInformation);
    }

    public function destroy(StudentPersonalInformation $personalInformation)
    {
        $this->authorize('delete', $personalInformation);
        
        $personalInformation->delete();

        return response()->json(null, 204);
    }

    public function markAsComplete(StudentPersonalInformation $personalInformation)
    {
        $this->authorize('update', $personalInformation);
        
        $personalInformation->update(['is_completed' => true]);

        return new PersonalInformationResource($personalInformation);
    }
}