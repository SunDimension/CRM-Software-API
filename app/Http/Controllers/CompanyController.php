<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Services\AuditTrailService;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    
    public function index(Request $request): CompanyCollection
    {
        $companies = Company::all();

        return new CompanyCollection($companies);
    }

    public function store(CompanyStoreRequest $request): CompanyResource
    {
        $companies = Company::create($request->validated());

          AuditTrailService::log('create', $companies, null, null, $request);

        return new CompanyResource($companies);
    }

    public function show(Request $request, Company $companies): CompanyResource
    {
        return new CompanyResource($companies);
    }

    public function update(CompanyUpdateRequest $request, Company $company): CompanyResource
    {
        $company->update($request->validated());

          AuditTrailService::log('update', $company, null, null, $request);

        return new CompanyResource($company);
    }

  public function destroy($id)
    {   
       
        Company::destroy($id);

        
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
