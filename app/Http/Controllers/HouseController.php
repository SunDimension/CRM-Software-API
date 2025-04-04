<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HouseStoreRequest;
use App\Http\Requests\HouseUpdateRequest;
use App\Http\Resources\HouseCollection;
use App\Http\Resources\HouseResource;
use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HouseController extends Controller
{
    
    public function index(Request $request): HouseCollection
    {
        $primaryfolders = House::all();

        return new HouseCollection($primaryfolders);
    }

    public function store(PrimaryFolderStoreRequest $request): PrimaryFolderResource
    {
        $primaryfolders = House::create($request->validated());

        return new HouseResource($primaryfolders);
    }

    public function show(Request $request, House $primaryfolders): HouseResource
    {
        return new HouseResource($primaryfolders);
    }

    public function update(PrimaryFolderUpdateRequest $request, PrimaryFolder $primaryfolders): HouseResource
    {
        $primaryfolders->update($request->validated());

        return new HouseResource($primaryfolders);
    }

  public function destroy($id)
    {   
       
        House::destroy($id);

        
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
