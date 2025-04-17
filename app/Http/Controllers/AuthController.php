<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{


  public function register(Request $request)
  {


      dd([
        'default_connection' => config('database.default'),
        'connections' => config('database.connections'),
        'current_db' => DB::connection()->getDatabaseName(),
        'env_db' => env('DB_DATABASE')
    ]);
    // Log database connection info
    Log::info('Database Connection Info:', [
        'default' => config('database.default'),
        'connections' => config('database.connections'),
        'current_connection' => DB::connection()->getDatabaseName()
    ]);

    $this->validate($request, [
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8',
      'role_id' => 'required',
    ]);

    try {
        // Create new User
        $user = User::create([
          'name' => $request->name,
          'email' => $request->email,
          'role_id' => $request->role_id,
          'password' => bcrypt($request->password),
        ]);

        // Log successful user creation
        Log::info('User created successfully:', [
            'user_id' => $user->id,
            'email' => $user->email,
            'database' => DB::connection()->getDatabaseName()
        ]);

        return response()->json(['user' => $user], 201);
    } catch (\Exception $e) {
        Log::error('User registration failed:', [
            'error' => $e->getMessage(),
            'database' => DB::connection()->getDatabaseName()
        ]);
        return response()->json(['error' => 'Registration failed: ' . $e->getMessage()], 500);
    }
  }

 
  public function login(Request $request)
{
    try {
        // Validate incoming request fields
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
            
        $user = User::where('email', $request->email)->first();
     
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid password'], 401);
        }
        
        // If credentials are valid, get the authenticated user
        Auth::login($user);
        
        // Load the role relationship
        $user->load('role');
        
        // Create a new token for this user
        $token = $user->createToken('authToken')->plainTextToken;
        
        return response()->json([
            'user' => new UserResource($user), 
            'token' => $token,
            'role' => $user->role->name
        ]);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Login failed: ' . $e->getMessage()], 500);
    }
}

  // Function to handle user logout
  public function logout(Request $request)
  {
    // Delete all tokens for the authenticated user
    $request->user()->tokens()->delete();

    // Return success message as JSON
    return response()->json(['message' => 'Logged out']);
  }
}
