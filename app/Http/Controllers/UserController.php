<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\PermissionUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $items = User::with('department')->orderBy('id', 'desc')
            ->filter($request->only('search'))
            ->paginate()->through(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'email' => $item->email,
                    'dni' => $item->dni,
                    'updated_at' => $item->updated_at->format('d/m/Y H:i'),
                    'allow_login' => $item->allow_login,
                    'department' => $item->department->name ?? null,
                    'edit_url' => route('users.edit', $item),
                    'permission_url' => route('users.permission', $item),
                    'show_url' => route('users.show', $item),
                    'can' => [
                        'show' => auth()->user()->can('view', $item),
                        'edit' => auth()->user()->can('update', $item),
                        'permission' => auth()->user()->can('update', $item),
                        'delete' => auth()->user()->can('delete', $item),
                    ]
                ];
            });

        return Inertia::render('Users/Index', [
            'filters' => $request->all('search'),
            'items' => $items,
            'urls' => [
                'create_url' => route('users.create'),
                'restore_url' => route('users.trash'),
            ],
            'can' => [
                'create' => auth()->user()->can('create', User::class),
                'restore' => auth()->user()->can('restoreAny', User::class),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $departments = Department::select('id', 'name')->whereNotNull('parent_id')->get()
            ->map(function ($item) {
                return ['value' => $item->id, 'label' => $item->name];
            })->toArray();

        $data = collect(config('permission_rules'));

        $permissions = [];
        foreach ($data as $key => $permission) {
            $collect = collect($permission);
            $plucked = $collect->pluck('permission', 'display_name');
            $permissions[$key] = $plucked->all();
        }

        return Inertia::render('Users/Add', [
            'departments' => $departments,
            'dniTypes' => User::getDniTypes(),
            'genderTypes' => User::getGenderTypes(),
            'allowLoginList' => User::getAllowLogin(),
            'permissions' => $permissions,
            'return_url' => route('users.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        $data = $request->only('name', 'email', 'dni', 'department_id', 'allow_login', 'dni_type', 'gender', 'address', 'phone');
        $data['password'] = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password

        $user = User::create($data);

        if ($request->has('permissions')) {
            $user->syncPermissions($request->input('permissions'));
        }

        $request->session()->flash('success', 'Usuario creado satisfactoriamente');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        $user = User::with('department')->where('id', $user->id)->first();
        $user = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'dni' => $user->dni,
            'allow_login' => $user->allow_login,
            'department' => $user->department->name ?? null,
            'dni_type' => $user->dni_type ?? null,
            'gender' => $user->gender ?? null,
            'address' => $user->address,
            'phone' => $user->phone
        ];

        return Inertia::render('Users/Show', [
            'return_url' => route('users.index'),
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $departments = Department::select('id', 'name')->whereNotNull('parent_id')->get()
            ->map(function ($item) {
                return ['value' => $item->id, 'label' => $item->name];
            })->toArray();

        return Inertia::render('Users/Edit', [
            'return_url' => route('users.index'),
            'user' => $user->only('id', 'name', 'email', 'dni', 'allow_login', 'department_id', 'dni_type', 'gender', 'address', 'phone'),
            'dniTypes' => User::getDniTypes(),
            'genderTypes' => User::getGenderTypes(),
            'allowLoginList' => User::getAllowLogin(),
            'departments' => $departments,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update($request->all());

        $request->session()->flash('success', 'Usuario actualizado satisfactoriamente');
        return redirect()->route('users.index');
    }


    public function permission(User $user)
    {
        $this->authorize('update', $user);

        $data = collect(config('permission_rules'));

        $permissions = [];
        foreach ($data as $key => $permission) {
            $collect = collect($permission);
            $plucked = $collect->pluck('permission', 'display_name');
            $permissions[$key] = $plucked->all();
        }

        return Inertia::render('Users/Permission', [
            'return_url' => route('users.index'),
            'user' => $user->only('id', 'name', 'dni'),
            'permissions' => $permissions,
            'current_permissions' => $user->getPermissionNames()->toArray()
        ]);
    }

    public function permissionStore(PermissionUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->syncPermissions($request->input('permissions'));

        $request->session()->flash('success', 'Permisos de usuario actualizado satisfactoriamente');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        $request->session()->flash('info', 'Usuario eliminado satisfactoriamente');
        return redirect()->route('users.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(Request $request)
    {
        $this->authorize('restoreAny', User::class);

        $items = User::with('department')->onlyTrashed()->orderBy('id', 'desc')
            ->filter($request->only('search'))
            ->paginate()->through(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'email' => $item->email,
                    'dni' => $item->dni,
                    'allow_login' => $item->allow_login,
                    'department' => $item->department->name ?? null,
                    'can' => [
                        'restore' => auth()->user()->can('restore', $item),
                        'forceDelete' => auth()->user()->can('forceDelete', $item),
                    ]
                ];
            });

        return Inertia::render('Users/Trash', [
            'filters' => $request->all('search'),
            'items' => $items,
            'urls' => [
                'return_url' => route('users.index'),
            ]
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $user_id)
    {
        $user = User::onlyTrashed()->find($user_id);

        $this->authorize('restore', $user);

        $user->restore();

        $request->session()->flash('success', 'Usuario restaurado satisfactoriamente');
        return redirect()->route('users.trash');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function trashDestroy(Request $request, $user_id)
    {
        $user = User::onlyTrashed()->find($user_id);

        $this->authorize('forceDelete', $user);

        $user->forceDelete();

        $request->session()->flash('warn', 'Usuario eliminado definitivamente');
        return redirect()->route('users.trash');
    }
}
