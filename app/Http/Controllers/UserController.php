<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserAddRequest;
use Spatie\Permission\Models\Role;
use App;
use App\Model\MasterData\Vendor;
use App\UserProfile;
use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $this->authorize(User::class, 'index');
        if ($request->ajax()) {
            $users = new User();
            if ($request->q) {
                $users = $users->where('name', 'like', '%'.$request->q.'%')->orWhere('email', $request->q);
            }
            $users = $users->paginate(config('stisla.perpage'))->appends(['q' => $request->q]);

            return response()->json($users);
        }

        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserAddRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $role = Role::find($request->role);

        if ($role) {
            $user->assignRole($request->role);
        }

        $user_profile = UserProfile::create([
            'user_id' => $user->id,
            'dept' => $request->dept,
            'bank_account' => $request->bank_account,
            'bank_id' => $request->bank,
            'created_at' => Carbon::now(),
        ]);

        $vendor = Vendor::create([
            'name' => $request->name,
            'category_id' => 9,
            'pic_vendor' => $request->name,
            'tlp_pic' => 0,
            'bank_account' => $request->bank_account,
            'bank_id' => $request->bank,
            'created_by' => $user->id,
            'type_vendor' => 1,
            'created_at' => Carbon::now(),
        ]);

        return response()->json([
            'user' => $user,
            'user_profile' => $user_profile,
            'vendor' => $vendor,
            'request_all' => $request->all(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        if (!App::environment('demo')) {
            $user->update($request->only([
                'name', 'email',
            ]));

            if ($request->password) {
                $user->update(['password' => Hash::make($request->password)]);
            }

            if ($request->role && $request->user()->can('edit-users') && !$user->isme) {
                $role = Role::find($request->role);
                if ($role) {
                    $user->syncRoles([$role]);
                }
            }
        }

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (!App::environment('demo') && !$user->isme) {
            $user->delete();
        } else {
            return response()->json(['message' => 'User accounts cannot be deleted in demo mode.'], 400);
        }
    }

    public function roles()
    {
        return response()->json(Role::get());
    }
}
