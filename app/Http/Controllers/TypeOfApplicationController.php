<?php

namespace App\Http\Controllers;

use App\Models\TypeOfApplication;
use App\Http\Requests\TypeOfApplicationStoreRequest;
use App\Http\Requests\TypeOfApplicationUpdateRequest;
use App\Http\Resources\TypeOfApplicationResource;
use App\Http\Resources\TypeOfApplicationCollection;

class TypeOfApplicationController extends Controller
{
    public function index()
    {
        return new TypeOfApplicationCollection(TypeOfApplication::all());
    }

    public function store(TypeOfApplicationStoreRequest $request)
    {
        $type = TypeOfApplication::create($request->validated());
        return new TypeOfApplicationResource($type);
    }

    public function update(TypeOfApplicationUpdateRequest $request, TypeOfApplication $typeOfApplication)
    {
        $typeOfApplication->update($request->validated());
        return new TypeOfApplicationResource($typeOfApplication);
    }

    public function destroy(TypeOfApplication $typeOfApplication)
    {
        $typeOfApplication->delete();
        return response()->json(['message' => 'Deleted successfully.']);
    }
}