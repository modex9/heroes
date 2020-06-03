<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\BanType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $ban_types = BanType::all();
        return view('user.index', compact('users', 'ban_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!isset($request->nickname))
            return back();
        User::create([
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role
        ]);
        return redirect('user');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

//        $roles = Role::all();
//        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'nickname' => [
                'required',
                'min:4',
                'max:15',
                Rule::unique('users')->ignore($user->id),
            ],
            'email' => [
                'required',
                'max:50',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'role_id' => 'integer|between:1,3',
            'id' => 'integer',
        ];
        if($request->password)
            $rules['password'] = 'string|min:6|max:16';
        $validator = Validator::make($request->all(), $rules);
        // Validate the input and return correct response
        if ($validator->fails())
        {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400); // 400 being the HTTP code for an invalid request.
        }

        $user->nickname = $request->nickname;
        $user->email = $request->email;
        $user->role_id = $request->role;
        //If validation was passed, the password is good
        if($request->password)
            $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(array('success' => true, 'user' => $user), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(Auth::user()->id !== $user->id) {
            $user->delete();
            $response = array(
                'status' => true
            );
        }
        else
            $response = array(
                'status' => false
            );
        return response()->json($response);
    }

    public function getUsers() {
        return json_encode(User::all());
    }
}
