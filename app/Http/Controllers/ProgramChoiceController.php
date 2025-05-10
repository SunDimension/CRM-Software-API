<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgramChoiceRequest;
use App\Http\Resources\ProgramChoiceResource;
use App\Models\StudentPersonalInformation;
use App\Models\StudentProgramChoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramChoiceController extends Controller
{
    public function index(StudentPersonalInformation $personalInformation)
    {
        $this->authorize('view', $personalInformation);

        $choices = $personalInformation->programChoices()->get();
        return ProgramChoiceResource::collection($choices);
    }

    public function store(StoreProgramChoiceRequest $request, StudentPersonalInformation $personalInformation)
    {
        $this->authorize('update', $personalInformation);

        // Check if choices already exist for the student
        $existingChoices = $personalInformation->programChoices()->exists();

        if ($existingChoices) {
            return response()->json(['message' => 'Program choices already exist for this student'], 400);
        }

        // Create program choices
        $choice = $personalInformation->programChoices()->create([
            'country_id' => $request->country_id,
            'university_id' => $request->university_id,
            'program_id' => $request->program_id,
            'first_choice' => $request->first_choice,
            'second_choice' => $request->second_choice,
            'third_choice' => $request->third_choice,
        ]);

        return new ProgramChoiceResource($choice);
    }

    public function show(StudentProgramChoice $programChoice)
    {
        $this->authorize('view', $programChoice->student);

        return new ProgramChoiceResource($programChoice);
    }

    public function update(StoreProgramChoiceRequest $request, StudentProgramChoice $programChoice)
    {
        $this->authorize('update', $programChoice->student);

        $programChoice->update([
            'country_id' => $request->country_id,
            'university_id' => $request->university_id,
            'program_id' => $request->program_id,
            'first_choice' => $request->first_choice,
            'second_choice' => $request->second_choice,
            'third_choice' => $request->third_choice,
        ]);

        return new ProgramChoiceResource($programChoice);
    }

    public function destroy(StudentProgramChoice $programChoice)
    {
        $this->authorize('delete', $programChoice->student);

        $programChoice->delete();

        return response()->json(null, 204);
    }

    public function markAsComplete(StudentProgramChoice $programChoice)
    {
        $this->authorize('update', $programChoice->student);

        $programChoice->update(['is_completed' => true]);

        return new ProgramChoiceResource($programChoice);
    }
}