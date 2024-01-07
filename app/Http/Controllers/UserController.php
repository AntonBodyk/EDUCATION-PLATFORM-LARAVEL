<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $users = User::paginate(50);

        if($request->input('page') > $users->lastPage()){
            abort(404);
        }
        return view('users.index', ['users' => $users]);
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

    public function store(UserRequest $request): object
    {

        $new_user = User::create($request->except('avatar'));

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

            $path = $avatar->store('avatars');

            $new_user->update(['avatar' => $path]);
        }


        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): object
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', ['user'=> $user], ['roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user): object
    {

        $data = $request->except('avatar');
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $path = $avatar->store('avatars');
            $data['avatar'] = $path;
        }



        $user->update($data);
        return redirect()->route('users.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): object
    {
        User::findOrFail($id)->delete();
        return redirect()->route('users.index');
    }
}
