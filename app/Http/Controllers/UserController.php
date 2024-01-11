<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
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
        // Получите параметры сортировки из запроса
        $sortColumn = $request->get('sortColumn', 'id');
        $sortDirection = $request->get('sortDirection', 'asc');

        $validColumns = ['id', 'name', 'email', 'role'];
        if (!in_array($sortColumn, $validColumns)) {
            $sortColumn = 'name';
        }

        // Получите запрос на пользователей, отсортированных и разбитых по страницам
        $usersQuery = User::orderBy($sortColumn, $sortDirection);

        // Примените фильтр по роли, если он установлен
        if ($request->filled('roleFilter')) {
            $usersQuery->whereHas('role', function ($query) use ($request) {
                $query->where('role_name', $request->input('roleFilter'));
            });
        }

        // Получите пользователей, отсортированных и разбитых по страницам
        $users = $usersQuery->paginate(50);

        // Проверьте, допустимы ли значения номера страницы
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
        $data = $request->all();
        $user->update($data);
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
