<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\admin\Activity;
use App\Models\admin\Deal;
use App\Models\admin\Contact;
use App\Models\admin\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Activity::select('activities.id','activities.title','due_date','users.name as owner_name','activities.created_at','activity_types.name as activity_type')
            ->join('users','users.id','=','activities.user_id')
            ->join('activity_types','activity_types.id','=','activities.activity_type_id','left')
            ->orderBy('activities.id','desc')
            ->get();
        return view('pages.activities',compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user     = auth::user()->id;
        $owners   = User::select('id','name')->where('active','1')
                       ->orderBy('name','asc')->get();
        $companies = Company::select('id','name')
                      ->orderBy('name','asc')->get();
        $contacts = Contact::select('id','first_name','last_name')
                      ->orderBy('first_name','asc')->get();
        $deals  = Deal::select('id','name')
                      ->orderBy('name','asc')->get();
        $types  = DB::table('activity_types')->select('id','name')->get();
        return view('pages.add_activity',compact('owners','companies','contacts','user','deals','types')); 
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
            'title' => 'required',
            'type' => 'required',
            'owner' => 'required'
        ],
        [ 
            'owner.required' => 'Please select the owner'
         ]
        );
       
        if($validator->fails())
        {
            return back()->withInput()
                        ->withErrors($validator);
        }
        else{            
            $activity = new Activity;
            $activity->title = $request->input('title');
            $activity->activity_type_id = $request->input('type');
            $activity->note = $request->input('note');
            $activity->description = $request->input('description');
            $activity->user_id = $request->input('owner');
            $activity->due_date = $request->input('due_date');
            $activity->due_time = $request->input('due_time');
            $activity->end_date = $request->input('end_date');
            $activity->end_time = $request->input('end_time');
            $activity->owner_assigned_date = date('Y-m-d H:i:s');
            $activity->created_by = auth::user()->id;
            $activity->created_at = date('Y-m-d H:i:s');  
            $result = $activity->save();   
            print_r($result);                 
            if($result)
            {
                if($request->guests)
                {
                    foreach($request->guests as $guest) {
                        DB::table('activity_guests')
                            ->insert(['activity_id' => $activity->id,
                                      'user_id' => $guest
                                     ]);
                    }
                }

                if($request->deals)
                {
                    foreach($request->deals as $deal) {
                        DB::table('activity_deals')
                            ->insert(['activity_id' => $activity->id,
                                      'deal_id' => $deal
                                     ]);
                    }
                }

                if($request->contacts)
                {
                    foreach($request->contacts as $contact) {
                        DB::table('activity_contacts')
                            ->insert(['contact_id' => $contact,
                                      'activity_id' => $activity->id
                                     ]);
                    }
                }

                if($request->companies)
                {
                    foreach($request->companies as $company) {
                        DB::table('activity_companies')
                            ->insert(['company_id' => $company,
                                      'activity_id' => $activity->id
                                     ]);
                    }
                }
                return redirect()->route('activities')
                            ->with('success','Activity created successfully');
            }  
            else
            {      
                 return redirect()->route('activities')          
                             ->with('error','Failed to create activity');
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
        $activity = Activity::find($id);
        $user     = auth::user()->id;
        $pipeline = DB::table('pipelines')->select('id','name')->get();
        $stages   = DB::table('stages')->select('id','name')->get();
        $owners   = User::select('id','name')->where('active','1')->orderBy('name','asc')->get();
        $companies = Company::select('id','name')->orderBy('name','asc')->get();
        $deals   = Deal::select('id','name')->orderBy('name','asc')->get();
        $activity_deals = DB::table('activity_deals')->select('deal_id')->where('activity_id',$id)->get();
        $contacts = Contact::select('id','first_name','last_name')->orderBy('first_name','asc')->get();
        $activity_contacts = DB::table('activity_contacts')->select('contact_id')->where('activity_id',$id)->get();
        $activity_companies = DB::table('activity_companies')->select('company_id')->where('activity_id',$id)->get();
        $activity_guests = DB::table('activity_guests')->select('user_id')->where('activity_id',$id)->get();
        $types  = DB::table('activity_types')->select('id','name')->get();
        return view('pages.edit_activity',compact('activity','user','owners','companies','contacts','deals','activity_deals','activity_companies','activity_contacts','stages','pipeline','activity_guests','types'));
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
            'title' => 'required',
            'type' => 'required',
            'owner' => 'required'
        ],
        [ 
            'owner.required' => 'Please select the owner'
         ]
        );
       
        if($validator->fails())
        {
            return back()->withInput()
                        ->withErrors($validator);
        }
        else{            
            $activity = Activity::find($id);
            $activity->title = $request->input('title');
            $activity->activity_type_id = $request->input('type');
            $activity->note = $request->input('note');
            $activity->description = $request->input('description');
            $activity->user_id = $request->input('owner');
            $activity->due_date = $request->input('due_date');
            $activity->due_time = $request->input('due_time');
            $activity->end_date = $request->input('end_date');
            $activity->end_time = $request->input('end_time');
            $activity->updated_at = date('Y-m-d H:i:s');  
            $result = $activity->save();   
            if($result)
            {
                DB::table('activity_guests')->where('activity_id',$id)->delete();
                if($request->guests)
                {
                    foreach($request->guests as $guest) {
                        DB::table('activity_guests')
                            ->insert(['activity_id' => $activity->id,
                                      'user_id' => $guest
                                     ]);
                    }
                }

                DB::table('activity_deals')->where('activity_id',$id)->delete();
                if($request->deals)
                {
                    foreach($request->deals as $deal) {
                        DB::table('activity_deals')
                            ->insert(['activity_id' => $activity->id,
                                      'deal_id' => $deal
                                     ]);
                    }
                }
                
                DB::table('activity_contacts')->where('activity_id',$id)->delete();
                if($request->contacts)
                {
                    foreach($request->contacts as $contact) {
                        DB::table('activity_contacts')
                            ->insert(['contact_id' => $contact,
                                      'activity_id' => $activity->id
                                     ]);
                    }
                }
                
                DB::table('activity_companies')->where('activity_id',$id)->delete();
                if($request->companies)
                {
                    foreach($request->companies as $company) {
                        DB::table('activity_companies')
                            ->insert(['company_id' => $company,
                                      'activity_id' => $activity->id
                                     ]);
                    }
                }
                return redirect()->route('activities')
                            ->with('success','Activity updated successfully');
            }  
            else
            {      
                 return redirect()->route('activities')          
                             ->with('error','Failed to update activity');
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
        //
    }
}
