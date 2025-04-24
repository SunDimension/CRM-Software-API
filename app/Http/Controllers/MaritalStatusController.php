<?php
namespace App\Http\Controllers;

use App\Models\MaritalStatus;
use App\Http\Requests\MaritalStatusStoreRequest;
use App\Http\Requests\MaritalStatusUpdateRequest ;
use App\Http\Resources\MaritalStatusResource;
use App\Http\Resources\MaritalStatusCollection;

class MaritalStatusController extends Controller
 {

    public function index()
 {
    return MaritalStatusResource::collection(MaritalStatus::all());
       
    }

    public function store( MaritalStatusStoreRequest $request )
 {
        $status = MaritalStatus::create( $request->validated() );
        return new MaritalStatusResource( $status );
    }

    public function update( MaritalStatusUpdateRequest $request, MaritalStatus $maritalStatus )
 {
        $maritalStatus->update( $request->validated() );
        return new MaritalStatusResource( $maritalStatus );
    }

    public function destroy( MaritalStatus $maritalStatus )
 {
        $maritalStatus->delete();
        return response()->json( [ 'message' => 'Deleted' ] );
    }
}
