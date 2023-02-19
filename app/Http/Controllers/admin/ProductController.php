<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\admin\Product;
use DB;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('product-list')) 
        {
            $products = Product::orderBy('id','DESC')->paginate(10);
            return view('pages.products',compact('products'))
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
        return view('pages.add_product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(),  [
            'name' => 'required',
            'unit_price' => 'required|numeric',
            'direct_price' => 'nullable|numeric',
        ]);
        if($validator->fails())
        {
            return back()->withInput()
                        ->withErrors($validator);
        }
        else{
            $input  = $request->all();
            $input['created_by'] = $user->id;
            $input['is_active']  = isset($request->active) ? "1" : "0";
            $result = Product::create($input);
        
            return redirect()->route('products')
                            ->with('success','Product created successfully');
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
        $product = Product::find($id);
        return view('pages.edit_product',compact('product'));
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
        $user = auth()->user();
        $validator = Validator::make($request->all(),  [
            'name' => 'required',
            'unit_price' => 'required|numeric',
            'direct_price' => 'nullable|numeric',
        ]);
        if($validator->fails())
        {
            return back()->withInput()
                        ->withErrors($validator);
        }
        else{
            $product = Product::find($id);
            $product->name = $request->name;
            $product->sku  = $request->sku;
            $product->unit_price  = $request->unit_price;
            $product->direct_cost = $request->direct_price;
            $product->unit        = $request->weight;
            $product->tax_rate    = $request->tax_rate;
            $product->tax_label   = $request->tax_label;            
            $product->is_active   = isset($request->active) ? "1" : "0";
            $result = $product->save();
        
            return redirect()->route('products')
                            ->with('success','Product updated successfully');
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
        Product::find($id)->delete();
        return redirect()->route('products')
                        ->with('success','Product deleted successfully');
    }
}
