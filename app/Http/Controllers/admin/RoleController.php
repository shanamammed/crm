<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Validator;

class RoleController extends Controller
{
    function __construct()
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
        if (auth()->user()->can('role-list')) 
        {
            $roles = Role::orderBy('id','DESC')->get();
            return view('pages.roles',compact('roles'));
        } else {
            return view('pages.error-page');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('pages.add_role',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ],
        [
            'name.required' => 'Please enter the role name',
            'permission.required' =>'Please select atleast one'
        ]);
        if($validator->fails())
        {
            return back()->withInput()
                        ->withErrors($validator);
        }
        else{
            $role = new Role;
            $role->name = $request->input('name');
            $role->slug = lcfirst($request->input('name'));
            $role->save();    
               
            foreach($request->input('permission') as $per) {
                $permission[] = [
                                   'role_id' => $role->id,
                                   'permission_id' => $per
                                ];
            }
            DB::table('roles_permissions')->insert($permission);
        
            return redirect()->route('roles')
                            ->with('success','Role created successfully');
        }       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $role = Role::find($id);
         $permissions = Permission::get();
         $rolePermissions = Permission::select('roles_permissions.permission_id')
            ->join("roles_permissions","roles_permissions.permission_id","=","permissions.id")
            ->where("roles_permissions.role_id",$id)
            ->pluck('permission_id')->toArray();
        // print_r($rolePermissions);
        return view('pages.edit_role',compact('role','permissions','rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("roles_permissions")->where("roles_permissions.role_id",$id)
            ->pluck('roles_permissions.permission_id')
            ->all();
    
        return view('roles.edit',compact('role','permissions','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
    
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        DB::table('roles_permissions')->where('role_id',$id)->delete();
        foreach($request->input('permission') as $per) {
            $permission[] = [
                               'role_id' => $role->id,
                               'permission_id' => $per
                            ];
        }
        DB::table('roles_permissions')->insert($permission);
        return redirect()->route('roles')
                        ->with('success','Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::find($id)->delete();
        return redirect()->route('roles')
                        ->with('success','Role deleted successfully');
    }
}
