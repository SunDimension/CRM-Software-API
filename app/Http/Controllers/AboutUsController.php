<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Http\Requests\AboutUsStoreRequest;
use App\Http\Requests\AboutUsUpdateRequest;
use App\Http\Resources\AboutUsResource;

class AboutUsController extends Controller
{
    public function index()
    {
        return AboutUsResource::collection(AboutUs::all());
    }

    public function store(AboutUsStoreRequest $request)
    {
        $about = AboutUs::create($request->validated());
        return new AboutUsResource($about);
    }

    public function update(AboutUsUpdateRequest $request, AboutUs $aboutUs)
    {
        $aboutUs->update($request->validated());
        return new AboutUsResource($aboutUs);
    }

    public function destroy(AboutUs $aboutUs)
    {
        $aboutUs->delete();
        return response()->json(['message' => 'Deleted successfully.']);
    }
}