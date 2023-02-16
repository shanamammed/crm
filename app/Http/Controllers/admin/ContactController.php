<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\admin\Contact;
use App\Models\admin\Company;
use App\Models\admin\Deal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;

class ContactController extends Controller
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
       $contacts = Contact::select('contacts.id','first_name','last_name','contacts.email','users.name as owner_name','contacts.created_at','sources.name as source')
            ->join('users','users.id','=','contacts.user_id')
            ->join('sources','sources.id','=','contacts.source_id','left')
            ->orderBy('contacts.id','desc')
            ->get();
        foreach ($contacts as $contact) {
            $contact->phones = DB::table('contact_mobiles')->select('mobile')->where('contact_id',$contact->id)->get();
         }   
        return view('pages.contacts',compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if(auth::user()->can('contact-create')) {
            $user    = auth::user()->id;
            $owners  = User::select('id','name')->where('active','1')
                           ->orderBy('name','asc')->get();
            $companies = Company::select('id','name')
                          ->orderBy('name','asc')->get();
            $deals = Deal::select('id','name')->orderBy('name','asc')->get();
            $sources = DB::table('sources')->select('id','name')->get();
            return view('pages.add_contact',compact('owners','companies','deals','user','sources')); 
        // } else {
        //     print_r('ok');
        // }
        
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:contacts,email',
            'owner' => 'required'
        ],
        [ 
            'email.domain' => 'Please enter a valid email',
            'owner.required' => 'Please select the owner'
         ]
        );
       
        if($validator->fails())
        {
            return back()->withInput()
                        ->withErrors($validator);
        }
        else{            
            $contact = new Contact;
            $contact->first_name = $request->input('first_name');
            $contact->last_name = $request->input('last_name');
            $contact->email = $request->input('email');
            $contact->email = $request->input('email');
            $contact->user_id = $request->input('owner');
            $contact->source_id = $request->input('source');
            $contact->owner_assigned_date = date('Y-m-d H:i:s');
            $contact->created_by = auth::user()->id;
            $contact->created_at = date('Y-m-d H:i:s');  
            $result = $contact->save();                    
            if($result)
            {
                $phones     = $_POST['phones'];
    
                $i = 0;
                foreach ($phones as $phone) 
                {
                    DB::table('contact_mobiles')
                            ->insert(['contact_id' => $contact->id,
                                      'mobile' => $phone
                                     ]);
                    $i++;
                }

                if($request->deals)
                {
                    foreach($request->deals as $deal) {
                        DB::table('deal_contacts')
                            ->insert(['contact_id' => $contact->id,
                                      'deal_id' => $deal
                                     ]);
                    }
                }

                if($request->companies)
                {
                    foreach($request->companies as $company) {
                        DB::table('company_contacts')
                            ->insert(['company_id' => $company,
                                      'contact_id' => $contact->id
                                     ]);
                    }
                }
                return redirect()->route('contacts')
                            ->with('success','Contact created successfully');
            }  
            else
            {      
                 return redirect()->route('contacts')          
                             ->with('error','Failed to create contact');
                // print_r('ok');
            }                 
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
        $contact = Contact::find($id);
        $user    = auth::user()->id;
        $owners  = User::select('id','name')->where('active','1')
                       ->orderBy('name','asc')->get();
        $companies = Company::select('id','name')
                      ->orderBy('name','asc')->get();
        $company_contacts = DB::table('company_contacts')->select('company_id')->where('contact_id',$id)->get();
        $deals = Deal::select('id','name')->orderBy('name','asc')->get();
        $contact_deals = DB::table('deal_contacts')->select('deal_id')->where('contact_id',$id)->get();
        $contact_phones = DB::table('contact_mobiles')->select('mobile')->where('contact_id',$id)->get();
        $sources = DB::table('sources')->select('id','name')->get();
        return view('pages.edit_contact',compact('contact','user','owners','companies','deals','contact_deals','company_contacts','contact_phones','sources'));
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:contacts,email,'.$id,
            'owner' => 'required'
        ],
        [ 
            'email.domain' => 'Please enter a valid email',
            'owner.required' => 'Please select the owner'
         ]
        );
       
        if($validator->fails())
        {
            return back()->withInput()
                        ->withErrors($validator);
        }
        else{            
            $contact = Contact::find($id);
            $contact->first_name = $request->input('first_name');
            $contact->last_name = $request->input('last_name');
            $contact->email = $request->input('email');
            $contact->email = $request->input('email');
            $contact->user_id = $request->input('owner');
            $contact->source_id = $request->input('source');
            $contact->updated_at = date('Y-m-d H:i:s');  
            $result = $contact->save();                    
            if($result)
            {
                $phones     = $_POST['phones'];
                DB::table('contact_mobiles')->where('contact_id',$id)->delete();    
                $i = 0;
                foreach ($phones as $phone) 
                {
                    DB::table('contact_mobiles')
                            ->insert(['contact_id' => $contact->id,
                                      'mobile' => $phone
                                     ]);
                    $i++;
                }
                
                DB::table('deal_contacts')->where('contact_id',$id)->delete();
                if($request->deals)
                {
                    foreach($request->deals as $deal) {
                        DB::table('deal_contacts')
                            ->insert(['contact_id' => $contact->id,
                                      'deal_id' => $deal
                                     ]);
                    }
                }
                
                DB::table('company_contacts')->where('contact_id',$id)->delete();
                if($request->companies)
                {
                    foreach($request->companies as $company) {
                        DB::table('company_contacts')
                            ->insert(['company_id' => $company,
                                      'contact_id' => $contact->id
                                     ]);
                    }
                }
                return redirect()->route('contacts')
                            ->with('success','Contact updated successfully');
            }  
            else
            {      
                 return redirect()->route('contacts')          
                             ->with('error','Failed to create contact');
            }                 
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
        Contact::find($id)->delete();
        return redirect()->route('contacts')
                        ->with('success','Contact deleted successfully');
    }
}
