<?php

namespace App\Http\Controllers;

use App\Models\LevelOfStudy;
use App\Http\Requests\LevelOfStudyStoreRequest;
use App\Http\Requests\LevelOfStudyUpdateRequest;
use App\Http\Resources\LevelOfStudyResource;
use App\Http\Resources\LevelOfStudyCollection;

class LevelOfStudyController extends Controller
{
    public function index()
    {
        return new LevelOfStudyCollection(LevelOfStudy::all());
    }

    public function store(LevelOfStudyStoreRequest $request)
    {
        $level = LevelOfStudy::create($request->validated());
        return new LevelOfStudyResource($level);
    }

    public function update(LevelOfStudyUpdateRequest $request, LevelOfStudy $levelOfStudy)
    {
        $levelOfStudy->update($request->validated());
        return new LevelOfStudyResource($levelOfStudy);
    }

    public function destroy(LevelOfStudy $levelOfStudy)
    {
        $levelOfStudy->delete();
        return response()->json(['message' => 'Deleted successfully.']);
    }
}
