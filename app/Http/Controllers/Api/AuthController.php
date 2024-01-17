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
        $validateUser = Validator::make($request->all(), [
            'avatar' => 'required|image:jpg,jpeg,png',
            'second_name' => 'required|string|max:100|regex:/^[a-zA-Zа-яА-ЯёЁіІїЇґҐ]+\s*$/u',
            'first_name' => 'required|string|max:100|regex:/^[a-zA-Zа-яА-ЯёЁіІїЇґҐ]+\s*$/u',
            'last_name' => 'required|string|max:100|regex:/^[a-zA-Zа-яА-ЯёЁіІїЇґҐ]+\s*$/u',
            'email' => 'required|string|email|unique:users,email',
            'role_id' => 'required',
            'password' => 'required|string|min:8|confirmed|regex:/^[A-ZА-Я][\p{Lu}\p{L}0-9\s]+$/u',
        ]);



        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 422);
        }

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars');
        }

        $user = User::create([
            'avatar' => $avatarPath,
            'second_name' => mb_convert_case($request->input('second_name'), MB_CASE_TITLE, 'UTF-8'),
            'first_name' => mb_convert_case($request->input('first_name'), MB_CASE_TITLE, 'UTF-8'),
            'last_name' => mb_convert_case($request->input('last_name'), MB_CASE_TITLE, 'UTF-8'),
            'email' => $request->input('email'),
            'role_id' => $request->input('role_id'),
            'password' => Hash::make($request->input('password'))
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
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
            ], 422);
        }

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'User not found',
                'status' => false
            ], 404);
        }

        $user = User::where('email', $request->email)->first();

        $fullUrl = url('storage/' . $user->avatar);

        $userArray = [
            'id'=> $user->id,
            'avatar'=> $fullUrl,
            'second_name'=> $user->second_name,
            'first_name'=> $user->first_name,
            'last_name'=> $user->last_name,
            'email'=> $user->email,
            'role_id'=> $user->role_id,
        ];


        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'user'=> $userArray,
        ], 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
