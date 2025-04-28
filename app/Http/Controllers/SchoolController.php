<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\School;
use App\Http\Requests\SchoolStoreRequest;
use App\Http\Requests\SchoolUpdateRequest;
use App\Http\Resources\SchoolResource;
use App\Http\Resources\SchoolCollection;
class SchoolController extends Controller
{
    public function index(Request $request): SchoolCollection
    {
        $school = School::all();
        return new SchoolCollection($school);
    }

    public function store(SchoolStoreRequest $request): SchoolResource
    {
        $school = School::create($request->validated());

        return new SchoolResource($school);
    }

    public function show(Request $request, School $school): SchoolResource
    {
        return new SchoolResource($school);
    }

    public function update(SchoolUpdateRequest $request, School $school): SchoolResource
    {
        $school->update($request->validated());

        return new SchoolResource($school);
    }
   

  public function destroy($id)
    {   
       
        School::destroy($id);

        
        return response(null, Response::HTTP_NO_CONTENT);
    }                                 
}
