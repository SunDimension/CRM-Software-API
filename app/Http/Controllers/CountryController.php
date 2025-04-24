<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Http\Requests\CountryStoreRequest;
use App\Http\Requests\CountryUpdateRequest;
use App\Http\Resources\CountryResource;
use App\Http\Resources\CountryCollection;

class CountryController extends Controller
{
    public function index()
    {
        return new CountryCollection(Country::all());
    }

    public function store(CountryStoreRequest $request)
    {
        $country = Country::create($request->validated());
        return new CountryResource($country);
    }

    public function update(CountryUpdateRequest $request, Country $country)
    {
        $country->update($request->validated());
        return new CountryResource($country);
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return response()->json(['message' => 'Deleted successfully.']);
    }
}