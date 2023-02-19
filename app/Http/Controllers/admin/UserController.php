<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('role-list')) 
        {
            $users = User::orderBy('id','DESC')->paginate(10);
            return view('pages.users',compact('users'))
              ->with('i', ($request->input('page', 1) - 1) * 10);
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
        $roles = Role::get();
        return view('pages.add_user',compact('roles'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:16',
            'roles' => 'required'
        ],
        [ 
            'email.email' => 'Please enter a valid email',
            'roles.required' => 'Please select the role'
         ]
        );
       
        if($validator->fails())
        {
            return back()->withInput()
                        ->withErrors($validator);
        }
        else{            
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->active = 1;  
            $user->save();

            $user->roles()->attach($request->input('roles'));
            $user_perm = DB::table('roles_permissions')->select('roles_permissions.permission_id')
                     ->whereIn('roles_permissions.role_id',$request->input('roles'))
                     ->groupBy('roles_permissions.permission_id')->pluck('roles_permissions.permission_id')->toArray();
               
            $user->permissions()->attach($user_perm);
            return redirect()->route('users')
                            ->with('success','User created successfully');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::get();
        $userRole = $user->roles->pluck('id','id')->all();
    
        return view('pages.edit_user',compact('user','roles','userRole'));
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
        $input = $request->all();
        $validator = Validator::make($request->all(),  [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'roles' => 'required',
        ],
        [ 
            'email.email' => 'Please enter a valid email',
            'roles.required' => 'Please select the role'
         ]
        );
       
        if($validator->fails())
        {
            return back()->withInput()
                        ->withErrors($validator);
        }
        else{            
            $user = User::find($id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->active= isset($request->active) ? "1" : "0";
            $user->save();

            DB::table('users_roles')->where('user_id',$id)->delete(); 
            DB::table('users_permissions')->where('user_id',$id)->delete(); 

            $user->roles()->attach($request->input('roles'));
            $user_perm = DB::table('roles_permissions')->select('roles_permissions.permission_id')
                     ->whereIn('roles_permissions.role_id',$request->input('roles'))
                     ->groupBy('roles_permissions.permission_id')->pluck('roles_permissions.permission_id')->toArray();
               
            $user->permissions()->attach($user_perm);
        
            return redirect()->route('users')
                            ->with('success','User updated successfully');
        }      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users')
                        ->with('success','User deleted successfully');
    }
}
