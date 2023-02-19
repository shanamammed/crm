<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\admin\Deal;
use App\Models\admin\Contact;
use App\Models\admin\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->can('deal-list')) 
        {    
            $deals = Deal::select('deals.id','deals.name','amount','deals.status',
                'expected_close_date','users.name as owner_name','deals.created_at','stages.name as stage')
                ->join('users','users.id','=','deals.user_id')
                ->join('stages','stages.id','=','deals.stage_id','left')
                ->orderBy('deals.id','desc')
                ->get();
            return view('pages.deals',compact('deals'));
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
        $pipeline = DB::table('pipelines')->select('id','name')->get();
        $stages   = DB::table('stages')->select('id','name')->get();
        $user     = auth::user()->id;
        $owners   = User::select('id','name')->where('active','1')
                       ->orderBy('name','asc')->get();
        $companies = Company::select('id','name')
                      ->orderBy('name','asc')->get();
        $contacts = Contact::select('id','first_name','last_name')
                      ->orderBy('first_name','asc')->get();
        return view('pages.add_deal',compact('owners','companies','contacts','user','stages','pipeline')); 
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
            'stage' => 'required',
            'pipeline' => 'required',
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
            $deal = new Deal;
            $deal->name = $request->input('name');
            $deal->pipeline_id = $request->input('pipeline');
            $deal->stage_id = $request->input('stage');
            $deal->amount = $request->input('amount');
            $deal->user_id = $request->input('owner');
            $deal->owner_assigned_date = date('Y-m-d H:i:s');
            $deal->expected_close_date = $request->input('expected_close_date');
            $deal->created_by = auth::user()->id;
            $deal->created_at = date('Y-m-d H:i:s');  
            $result = $deal->save();                    
            if($result)
            {
                if($request->contacts)
                {
                    foreach($request->contacts as $contact) {
                        DB::table('deal_contacts')
                            ->insert(['contact_id' => $contact,
                                      'deal_id' => $deal->id
                                     ]);
                    }
                }

                if($request->companies)
                {
                    foreach($request->companies as $company) {
                        DB::table('deal_companies')
                            ->insert(['company_id' => $company,
                                      'deal_id' => $deal->id
                                     ]);
                    }
                }
                return redirect()->route('deals')
                            ->with('success','Deal created successfully');
            }  
            else
            {      
                 return redirect()->route('deals')          
                             ->with('error','Failed to create deal');
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
        $deal    = Deal::find($id);
        $user    = auth::user()->id;
        $pipeline = DB::table('pipelines')->select('id','name')->get();
        $stages   = DB::table('stages')->select('id','name')->get();
        $owners   = User::select('id','name')->where('active','1')->orderBy('name','asc')->get();
        $companies = Company::select('id','name')->orderBy('name','asc')->get();
        $company_deals = DB::table('deal_companies')->select('company_id')->where('deal_id',$id)->get();
        $contacts = Contact::select('id','first_name','last_name')->orderBy('first_name','asc')->get();
        $deal_contacts = DB::table('deal_contacts')->select('contact_id')->where('deal_id',$id)->get();
        return view('pages.edit_deal',compact('deal','user','owners','companies','contacts','deal_contacts','company_deals','stages','pipeline'));
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
            'stage' => 'required',
            'pipeline' => 'required',
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
            $deal = Deal::find($id);
            $deal->name = $request->input('name');
            $deal->pipeline_id = $request->input('pipeline');
            $deal->stage_id = $request->input('stage');
            $deal->amount = $request->input('amount');
            $deal->user_id = $request->input('owner');
            $deal->expected_close_date = $request->input('expected_close_date');
            $deal->updated_at = date('Y-m-d H:i:s');  
            $result = $deal->save();                    
            if($result)
            {
                DB::table('deal_contacts')->where('deal_id',$id)->delete();
                if($request->contacts)
                {
                    foreach($request->contacts as $contact) {
                        DB::table('deal_contacts')
                            ->insert(['contact_id' => $contact,
                                      'deal_id' => $deal->id
                                     ]);
                    }
                }
                
                DB::table('deal_companies')->where('deal_id',$id)->delete();
                if($request->companies)
                {
                    foreach($request->companies as $company) {
                        DB::table('deal_companies')
                            ->insert(['company_id' => $company,
                                      'deal_id' => $deal->id
                                     ]);
                    }
                }
                return redirect()->route('deals')
                            ->with('success','Deal updated successfully');
            }  
            else
            {      
                 return redirect()->route('deals')          
                             ->with('error','Failed to update deal');
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
        Deal::find($id)->delete();
        return redirect()->route('deals')
                        ->with('success','Deal deleted successfully');
    }
}
