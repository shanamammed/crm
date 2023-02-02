<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\admin\Company;
use App\Models\admin\Contact;
use App\Models\admin\Deal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::select('companies.id','companies.name','domain','companies.email','users.name as owner_name','companies.created_at')
            ->join('users','users.id','=','companies.user_id')
            ->orderBy('companies.id','desc')
            ->get();
        return view('pages.companies',compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user    = auth::user()->id;
        $owners  = User::select('id','name')->where('active','1')
                       ->orderBy('name','asc')->get();
        $contacts = Contact::select('id','first_name','last_name')
                      ->orderBy('first_name','asc')->get();
        $deals = Deal::select('id','name')->orderBy('name','asc')->get();
        return view('pages.add_company',compact('owners','contacts','deals','user')); 
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
            'domain' => 'required|unique:companies,domain',
            'owner' => 'required'
        ],
        [ 
            'domain.domain' => 'Please enter a valid domain',
            'owner.required' => 'Please select the owner'
         ]
        );
       
        if($validator->fails())
        {
            return back()->withInput()
                        ->withErrors($validator);
        }
        else{            
            $company = Company::insert(['name' => $request->input('name'),
                                  'email' => $request->input('email'),
                                  'domain' => $request->input('domain'),
                                  'user_id' => $request->input('owner'),
                                  'owner_assigned_date' => date('Y-m-d H:i:s'),
                                  'created_by' => auth::user()->id,
                                  'is_active' => '1',
                                  'created_at' => date('Y-m-d H:i:s')  
                                 ]);
            if($company)
            {
                if($request->deals)
                {
                    foreach($request->deals as $deal) {
                        DB::table('deal_companies')
                            ->create(['company_id' => $company->id,
                                      'deal_id' => $deal
                                     ]);
                    }
                }

                if($request->contacts)
                {
                    foreach($request->contacts as $contact) {
                        DB::table('company_contacts')
                            ->create(['company_id' => $company->id,
                                      'contact_id' => $contact
                                     ]);
                    }
                }
            }        
            return redirect()->route('companies')
                            ->with('success','Company created successfully');
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
        //
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
        $validator = Validator::make($request->all(),  [
            'name' => 'required',
            'domain' => 'required|unique:companies,domain',
            'owner' => 'required'
        ],
        [ 
            'domain.domain' => 'Please enter a valid domain',
            'owner.required' => 'Please select the owner'
         ]
        );
       
        if($validator->fails())
        {
            return back()->withInput()
                        ->withErrors($validator);
        }
        else{     
            $company = Company::find($id);       
            $company = Company::insert(['name' => $request->input('name'),
                                  'email' => $request->input('email'),
                                  'domain' => $request->input('domain'),
                                  'user_id' => $request->input('owner'),
                                  'owner_assigned_date' => date('Y-m-d H:i:s'),
                                  'created_by' => auth::user()->id,
                                  'is_active' => '1',
                                  'created_at' => date('Y-m-d H:i:s')  
                                 ]);
            if($company)
            {
                DB::table('deal_companies')->where('company_id',$id)->delete();
                if($request->deals)
                {   
                    foreach($request->deals as $deal) {
                        DB::table('deal_companies')
                            ->create(['company_id' => $id,
                                      'deal_id' => $deal
                                     ]);
                    }
                }
                
                DB::table('company_contacts')->where('company_id',$id)->delete(); 
                if($request->contacts)
                {
                    foreach($request->contacts as $contact) {
                        DB::table('company_contacts')
                            ->create(['company_id' => $id,
                                      'contact_id' => $contact
                                     ]);
                    }
                }
            }        
            return redirect()->route('companies')
                            ->with('success','Company updated successfully');
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
        //
    }
}
