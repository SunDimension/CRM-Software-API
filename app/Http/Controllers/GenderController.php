<?php
namespace App\Http\Controllers;

use App\Models\Gender;
use App\Http\Requests\GenderStoreRequest;
use App\Http\Requests\GenderUpdateRequest;
use App\Http\Resources\GenderResource;
use App\Http\Resources\GenderCollection;

class GenderController extends Controller
{
    public function index()
{
    return GenderResource::collection(Gender::all());
    // No need for the additional GenderCollection wrapper
}

    public function store(GenderStoreRequest $request)
    {
        $gender = Gender::create($request->validated());
        return new GenderResource($gender);
    }

    public function update(GenderUpdateRequest $request, Gender $gender)
    {
        $gender->update($request->validated());
        return new GenderResource($gender);
    }

    public function destroy(Gender $gender)
    {
        $gender->delete();
        return response()->json(['message' => 'Deleted successfully.']);
    }
}