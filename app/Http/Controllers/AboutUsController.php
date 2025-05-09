<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutUsStoreRequest;
use App\Http\Resources\AboutUsResource;
use App\Models\AboutUs;
use App\Models\StudentPersonalInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AboutUsController extends Controller
{
    /**
     * Display the About Us information for a specific student
     * 
     * @param StudentPersonalInformation $personalInformation
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(StudentPersonalInformation $personalInformation)
    {
        $this->authorize('view', $personalInformation);
        
        $aboutUs = $personalInformation->aboutUs;
        return new AboutUsResource($aboutUs);
    }

    /**
     * Store new About Us information for a student
     * 
     * @param AboutUsStoreRequest $request
     * @param StudentPersonalInformation $personalInformation
     * @return AboutUsResource
     */
    public function store(AboutUsStoreRequest $request, StudentPersonalInformation $personalInformation)
    {
        $this->authorize('update', $personalInformation);
        
        $aboutUs = $personalInformation->aboutUs()->create($request->validated());

        return new AboutUsResource($aboutUs);
    }

    /**
     * Display specific About Us information
     * 
     * @param AboutUs $aboutUs
     * @return AboutUsResource
     */
    public function show(AboutUs $aboutUs)
    {
        $this->authorize('view', $aboutUs->student);
        
        return new AboutUsResource($aboutUs);
    }

    /**
     * Update specific About Us information
     * 
     * @param AboutUsStoreRequest $request
     * @param AboutUs $aboutUs
     * @return AboutUsResource
     */
    public function update(AboutUsStoreRequest $request, AboutUs $aboutUs)
    {
        $this->authorize('update', $aboutUs->student);
        
        $aboutUs->update($request->validated());

        return new AboutUsResource($aboutUs);
    }

    /**
     * Delete About Us information
     * 
     * @param AboutUs $aboutUs
     * @return \Illuminate\Http\Response
     */
    public function destroy(AboutUs $aboutUs)
    {
        $this->authorize('delete', $aboutUs->student);
        
        $aboutUs->delete();

        return response()->json(null, 204);
    }

    /**
     * Mark About Us information as complete
     * 
     * @param AboutUs $aboutUs
     * @return AboutUsResource
     */
    public function markAsComplete(AboutUs $aboutUs)
    {
        $this->authorize('update', $aboutUs->student);
        
        $aboutUs->update(['is_completed' => true]);

        return new AboutUsResource($aboutUs);
    }
}