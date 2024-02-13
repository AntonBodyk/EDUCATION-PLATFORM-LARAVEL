<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Mail\WelcomeMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;
use function Symfony\Component\String\u;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): object
    {
        $sortColumn = $request->get('sortColumn', 'id');
        $sortDirection = $request->get('sortDirection', 'asc');

        $validColumns = ['id', 'first_name', 'emails', 'role'];
        if (!in_array($sortColumn, $validColumns)) {
            $sortColumn = 'first_name';
        }

        $usersQuery = User::orderBy($sortColumn, $sortDirection);

        if ($request->filled('roleFilter')) {
            $usersQuery->whereHas('role', function ($query) use ($request) {
                $query->where('role_name', $request->input('roleFilter'));
            });
        }

        $users = $usersQuery->paginate(50);

        if ($request->input('page') > $users->lastPage()) {
            abort(404);
        }

        return view('users.index', compact('users', 'sortColumn', 'sortDirection'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): object
    {
        $roles = Role::all();
        return view('users.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(CreateUserRequest $request): object
    {

        $data = $request->except('avatar');

        $data['first_name'] = mb_convert_case($data['first_name'], MB_CASE_TITLE, 'UTF-8');
        $data['second_name'] = mb_convert_case($data['second_name'], MB_CASE_TITLE, 'UTF-8');
        $data['last_name'] = mb_convert_case($data['last_name'], MB_CASE_TITLE, 'UTF-8');



        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

            $path = $avatar->store('avatars');

            $data['avatar'] = $path;
        }

        $new_user = User::create($data);

        Mail::to($new_user->email)->send(new WelcomeMail($new_user, $data['password']));

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id):object
    {
        return User::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): object
    {
        $roles = Role::all();
        return view('users.edit', ['user'=> $user], ['roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): object
    {
        $data = $request->except('avatar');

        $data['first_name'] = mb_convert_case($data['first_name'], MB_CASE_TITLE, 'UTF-8');
        $data['second_name'] = mb_convert_case($data['second_name'], MB_CASE_TITLE, 'UTF-8');
        $data['last_name'] = mb_convert_case($data['last_name'], MB_CASE_TITLE, 'UTF-8');

        $userResource = new UserResource($user);

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars');
            $data['avatar'] = $avatarPath;
        }

        $user->update($data);

        if ($request->expectsJson()) {
            $user->refresh();

            return response()->json(['user' => $userResource, 'message' => 'Updated successfully'], 200)
                ->header('Access-Control-Allow-Methods', 'PATCH')
                ->header('Access-Control-Allow-Headers', 'Content-Type,API-Key');
        }

        return redirect()->route('users.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): object
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
