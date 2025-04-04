<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\YearStoreRequest;
use App\Http\Requests\YearUpdateRequest;
use App\Http\Resources\YearCollection;
use App\Http\Resources\YearResource;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class YearController extends Controller
{
    
    public function index(Request $request): YearCollection
    {
        $year = Year::all();

        return new YearCollection($year);
    }

    public function store(YearStoreRequest $request): YearResource
    {
        $year = Year::create($request->validated());

        return new YearResource($year);
    }

    public function show(Request $request, Year $year): YearResource
    {
        return new YearResource($year);
    }

    public function update(YearUpdateRequest $request, Year $year): YearResource
    {
        $year->update($request->validated());

        return new YearResource($year);
    }

  public function destroy($id)
    {   
       
        Year::destroy($id);

        
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
