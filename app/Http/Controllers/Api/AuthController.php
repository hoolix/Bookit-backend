<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\Business;
use App\Models\BusinessType;
use App\Models\User;
use Hash;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function googleLogin(Request $request)
    {
        // Validate request
        $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
        ]);

        // Convert username to lowercase & replace spaces with underscores
        $baseUsername = strtolower(str_replace(' ', '_', $request->username));
        $username = $baseUsername;

        // Check if username already exists
        $existingUser = User::where('username', $username)->first();
        $counter = 1;

        while ($existingUser) {
            // If username exists, append a number (increment if already exists)
            $username = $baseUsername . $counter;
            $existingUser = User::where('username', $username)->first();
            $counter++;
        }

        // Check if user already exists by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Generate a secure password (hashed)
            $generatedPassword = Hash::make($username);

            // Create a new user
            $user = User::create([
                'username' => $username, // Unique username
                'email' => $request->email,
                'password' => $generatedPassword,
            ]);
        }

        // Generate authentication token
        $token = $user->createToken('main')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Login successful'
        ]);
    }


    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
    
        // Allow login with either email or username
        $user = User::where('email', $credentials['email'])
                    ->orWhere('username', $credentials['username']) // Support login with username
                    ->first();
    
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email or password'
            ], 422);
        }
    
        // Generate token
        $token = $user->createToken('main')->plainTextToken;
    
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful!',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function signup(SignupRequest $request)
{
    $validatedData = $request->validated();

    // Check if the business type exists
    $businessType = BusinessType::find($validatedData['businessType']);

    if (!$businessType) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid business type selected.'
        ], 422);
    }

     // Check if acceptTerms is provided and valid, set default to false
     $acceptTerms = $request->has('acceptTerms') && $request->acceptTerms === true ? 1 : 0;

    // Create a new user
    $user = User::create([
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
        'username' => $validatedData['username'],
        'phone' => $validatedData['phone'], // Assuming phone is provided in the request
        'accept_terms' => $acceptTerms,
    ]);

    // Create a new business
    $business = Business::create([
        'business_name' => $validatedData['businessName'],
        'business_type_id' => $validatedData['businessType'], // Link to business type
        'user_id' => $user->id, // Link to the created user
    ]);

    // Generate token for the new user
    $token = $user->createToken('main')->plainTextToken;

    return response()->json([
        'status' => 'success',
        'message' => 'Signup successful!',
        'user' => $user,
        'token' => $token
    ], 200);
}

    

    public function logout(Request $request)
{
    $user = $request->user();
    $user->currentAccessToken()->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Logged out successfully'
    ], 200);
}

}