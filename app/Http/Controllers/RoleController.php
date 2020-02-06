<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::check('isAdmin')) {
            $roles = Role::orderBy('created_at')->paginate(10);
            return view('admin.role.index', compact('roles'));
        }else{
            return redirect()->route('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        if (Gate::check('isAdmin')) {
            $atts = $this->validate($request, $request->rules(), $request->messages());
            Role::create($atts);
            return back();
        }else{
            return redirect()->route('home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        if (Gate::check('isAdmin')) {
            $atts = $request->validate(
                [
                    'role'          =>  ['required', 'unique:roles,role,'.$role->id],
                    'description'   =>  ['required']
                ],
                [
                    'role.required'         =>   'Role field is required!',
                    'role.unique'           =>   'Role already exists!',
                    'description.required'  =>  'Description field is required!'
                ]
            );

            $role->update($atts);

            return back();
        }else{
            return redirect()->route('home');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if (Gate::check('isAdmin')) {
            if ($role->users->count() > 0) {
                return back()->with('delete_error', 'You cannot delete a role with users');
            }else{
                $role->delete();
                return back();
            }
        }else{
            return redirect()->route('home');
        }
    }
}
