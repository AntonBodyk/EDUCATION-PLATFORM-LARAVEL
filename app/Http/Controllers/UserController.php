<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): object
    {
        $users = User::paginate(50);
        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
//    public function store(Request $request)
//    {
//       $new_user = User::create($request->all());
//
//        if ($request->hasFile('avatar')) {
//            $avatar = $request->file('avatar');
//
//            // Сохранение файла и получение его пути
//            $path = $avatar->store('avatars');
//            $filePath = Storage::path($path);
//
//            // Теперь $filePath содержит полный путь к сохраненному файлу
////            dd($filePath);
////            dump($path);
////            dd($filePath);
////            $new_user->update('avatar', $filePath);
//        }
//
//        return redirect()->route('users.index');
//    }
    public function store(Request $request)
    {
        $new_user = User::create($request->except('avatar'));

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
//            dd($avatar);
            // Сохранение файла и получение его пути
            $path = $avatar->store('avatars');
//            dd($path);

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->except('_token', '_method');

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars');
        }

        $user->update($data);

        return redirect()->route('users.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('users.index');
    }
}
