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
        
        $choices = $personalInformation->programChoices()->orderBy('priority')->get();
        return ProgramChoiceResource::collection($choices);
    }

    public function store(StoreProgramChoiceRequest $request, StudentPersonalInformation $personalInformation)
    {
        $this->authorize('update', $personalInformation);
        
        // Check if choice with this priority already exists
        $existing = $personalInformation->programChoices()
            ->where('priority', $request->priority)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Program choice with this priority already exists'], 400);
        }

        $choice = $personalInformation->programChoices()->create($request->validated());

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
        
        $programChoice->update($request->validated());

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