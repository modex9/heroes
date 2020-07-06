<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Role;
use App\BanType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AbstractAdminController;

class UserController extends AbstractAdminController
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
        $user_rules = User::getRules(isset($user) ? $user : null);
        $user_rules['password'] = 'string|min:6|max:16|required';

        $custom_messages = [];
        if($request->referralID) {
            $user_rules['referralID'] = 'exists:App\User,nickname';
            $custom_messages['referralID.exists'] = 'User ' . $request->referralID . ' does not exist';
        }

        $not_validated = $this->validateData($request, $user_rules, $custom_messages);
        if($not_validated)
            return $not_validated;

        $user_fields = [
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role,
        ];
        $user_fields['referralID'] = $request->referralID ? $this->getReferralId($request) : '';

        $user = User::create($user_fields);
        return response()->json(array('success' => true, 'user' => $user), 200);
    }

    public function getReferralId(Request $request) {
        // todo : field name referralID is missleading
        $referral = User::where('nickname', $request->referralID)->get()->first();
        return $referral->id;
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
        $user_rules = User::getRules($user);
        if($request->password)
            $user_rules['password'] = 'string|min:6|max:16';
        $not_validated = $this->validateData($request, $user_rules);
        if($not_validated)
            return $not_validated;

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
        $response = [];
        if(!$user) {
            $response['error'] = 'Request failed: user is not valid';
        }
        elseif(Auth::user()->id == $user->id) {
            $response['error'] = 'Can\'t delete yourself.';
        }
        //todo: apsirasyt constanta
        elseif($user->role->id == 1) {
            $response['error'] = 'Can\'t delete admin.';
        }

        if(!isset($response['error'])) {
            $user->delete();
            $response['success'] = true;
        }
        else
            $response['success'] = false;

        return response()->json($response);
    }

    public function getUsers() {
        $users = User::all();
        foreach ($users as $user) {
            $user->banned = $user->isBanned();
        }
        return json_encode($users);
    }
}
