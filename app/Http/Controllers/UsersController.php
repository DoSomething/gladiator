<?php

namespace Gladiator\Http\Controllers;

use Gladiator\Models\User;
use Gladiator\Services\Registrar;
use Gladiator\Http\Requests\UserRequest;

class UsersController extends Controller
{
    /**
     * Registrar instance.
     *
     * @var \Gladiator\Services\Registrar
     */
    protected $registrar;

    /**
     * Create new UsersController instance.
     */
    public function __construct(Registrar $registrar)
    {
        $this->registrar = $registrar;

        $this->middleware('auth');
        $this->middleware('role:admin,staff');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = User::where('role', '=', 'admin')->get();
        $staff = User::where('role', '=', 'staff')->get();
        $contestants = User::where('role', '=', null)->get();

        return view('users.index', compact('admins', 'staff', 'contestants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Gladiator\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $account = $this->registrar->findUserAccount($request->all());

        if ($account instanceof User) {
            return redirect()->route('users.index')->with('status', 'User already exists!');
        }

        $credentials = $request->all();
        $credentials['id'] = $account;

        $user = $this->registrar->createUser($credentials);

        return redirect()->route('users.index')->with('status', 'User has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Gladiator\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Gladiator\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Gladiator\Http\Requests\UserRequest  $request
     * @param  \Gladiator\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $user)
    {
        $user->role = $request->role;
        $user->save();

        return redirect()->route('users.index')->with('status', 'User has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // @TODO: implement user deletion from Gladiator.
    }

    /**
     * Show a user's signup information for a specific campaign.
     */
    public function showSignup($id, $signup_id) {
        var_dump('show signup');
    }
}
