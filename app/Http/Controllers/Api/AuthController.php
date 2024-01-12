<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request): JsonResponse
    {
        $validateUser = Validator::make($request->all(),
            [
                'avatar' => 'required|image:jpg,jpeg,png',
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email',
                'role_id' => 'required',
                'password' => 'required|string|min:8',
            ]);

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        if($request->hasFile('avatar')){
            $avatarPath = $request->file('avatar')->store('avatars');
        }


        $user = User::create([
            'avatar'=>$avatarPath,
            'name' => $request->name,
            'email' => $request->email,
            'role_id'=> $request->role_id,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);
    }

    public function login(Request $request): JsonResponse
    {
        $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|string|email',
                'password' => 'required|string'
            ]);

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'You cannot sign with those email and password',
                'status' => false
            ], 401);
        }

        $user = User::where('email', $request->email)->first();


        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
        ], 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
