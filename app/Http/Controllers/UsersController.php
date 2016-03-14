<?php

namespace Gladiator\Http\Controllers;

use Gladiator\Models\User;
use Gladiator\Services\Registrar;
use Gladiator\Http\Requests\UserRequest;
use Gladiator\Repositories\UserRepositoryInterface;

class UsersController extends Controller
{
    /**
     * Registrar instance.
     *
     * @var \Gladiator\Services\Registrar
     */
    protected $registrar;

    /**
     * UserRepository instance.
     *
     * @var \Gladiator\Repositories\UserRepositoryInterface
     */
    protected $repository;

    /**
     * Create new UsersController instance.
     */
    public function __construct(Registrar $registrar, UserRepositoryInterface $repository)
    {
        $this->registrar = $registrar;
        $this->repository = $repository;

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
        $admins = $this->repository->getAllByRole('admin');
        $staff = $this->repository->getAllByRole('staff');
        $contestants = $this->repository->getAllByRole();

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

        $account->role = $request->role;

        $user = $this->registrar->createUser($account);

        return redirect()->route('users.index')->with('status', 'User has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id  Northstar ID
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->repository->find($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id  Northstar ID
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->repository->find($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Gladiator\Http\Requests\UserRequest  $request
     * @param  string  $id  Northstar ID
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $this->repository->update($request, $id);

        return redirect()->route('users.index')->with('status', 'User has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id  Northstar ID
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // @TODO: implement user deletion from Gladiator.
    }

    /**
     * Show a user's signup information for a specific campaign.
     */
    public function showSignup($id, $signup_id)
    {
        var_dump('show signup');
    }
}
