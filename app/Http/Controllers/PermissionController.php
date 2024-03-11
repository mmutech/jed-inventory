<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $permissions = Permission::orderBy('id','DESC')->paginate(5);

        return view('auth.permission.index',compact('permissions'))
                    ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('auth.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:permissions,name',
        ]);
        
        Permission::create(['name' => $request->input('name')]);

        $this->dispatch('success', message: 'Permission Created Successfully!');
        return redirect()->route('permissions.index');
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
        $permission = Permission::find($id);
        // dd($permission);

        return view('auth.permission.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'name' => 'required|String|unique:permissions,name',
        ]);

        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->save();

        $this->dispatch('success', message: 'Permission Updated Successfully!');
        return redirect()->route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
