<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $limit = $request->query('limit') ?? 10;
        $search = $request->query('search') ?? '';

        $users = UserResource::collection(
            User::with(['userDetails'])
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                })
                ->latest()
                ->paginate($limit)
        );

        return Inertia::render('UserManagement/Index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('UserManagement/Form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        $users = $request->only('name', 'email');

        User::create([
            ...$users,
            'user_type' => $request->userType,
            'password' => Hash::make($request->password)
        ])->userDetails()->create([
            'first_name' => $request->firstname,
            'last_name' => $request->lastname
        ]);

        return to_route('user-management.index')->with([
            'message' => 'Created sucessfully',
            'status' => 'created'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user_management)
    {
        $user = $user_management;

        return Inertia::render('UserManagement/Form', [
            'user' => $user,
            'user_details' => $user->userDetails
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user_management)
    {

        $data = [
            ...$request->only('name', 'email'),
            'user_type' => $request->userType,
        ];

        if ($request->password) {
            $data = [
                ...$data,
                'password' => Hash::make($request->password)
            ];
        }

        $user_management->update($data);

        $user_management->userDetails()->update([
            'first_name' => $request->firstname,
            'last_name' => $request->lastname
        ]);

        return to_route('user-management.index')->with([
            'message' => 'Updated sucessfully',
            'status' => 'updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user_management)
    {
        $user_management->userDetails()->delete();
        $user_management->delete();

        return to_route('user-management.index')->with([
            'message' => 'Deleted sucessfully',
            'status' => 'deleted'
        ]);
    }
}
