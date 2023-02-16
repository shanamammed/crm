@extends('../layout/' . $layout)

@section('subhead')
    <title>CRUD Form - Rubick - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Update Product</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-8">
          <!-- BEGIN: Form Layout -->
          <form method="post" action="{{url('products/update/'.$product->id)}}">  
            @csrf
            <div class="intro-y box p-5">
                <div>
                    <label for="crud-form-1" class="form-label">Product Name<span style="color:red;">*</span></label>
                    <input id="crud-form-1" name="name" type="text" class="form-control w-full" placeholder="Product Name" value="{{$product->name}}" required>
                </div>  
                @error('name') <span class="error" style="color:red;">{{ $message }}</span> @enderror<br>
                <div>
                    <label for="crud-form-1" class="form-label">SKU</label>
                    <input id="crud-form-1" name="sku" type="text" class="form-control w-full" placeholder="SKU" value="{{$product->sku}}">
                </div>
                 @error('sku') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                <div class="mt-3">
                    <label for="crud-form-1" class="form-label">Description</label>
                    <textarea class="form-control" type="text" name="description" placeholder="Description">{{$product->description}}</textarea>
                </div>
                 @error('description') <span class="error" style="color:red;">{{ $message }}</span> @enderror <br>
                <div class="mt-3">
                    <label for="crud-form-4" class="form-label">Weight</label>
                    <div class="input-group">
                        <input id="crud-form-4" name="weight" type="text" class="form-control" placeholder="Weight" aria-describedby="input-group-2" value="{{$product->weight}}">
                        <div id="input-group-2" class="input-group-text">kg/lots</div>
                    </div>
                </div> 
                @error('weight') <span class="error" style="color:red;">{{ $message }}</span> @enderror<br>
                <div class="mt-3">                    
                    <div class="sm:grid grid-cols-3 gap-2">
                        <div class="input-group mt-2 sm:mt-0">
                            <label for="crud-form-1" class="form-label">Unit Price<span style="color:red;">*</span></label>
                            <div id="input-group-4" class="input-group-text">BHD</div>
                            <input type="number" step="any" name="unit_price" class="form-control" placeholder="Unit Price" aria-describedby="input-group-4" value="{{$product->unit_price}}" required>
                        </div> 
                        @error('unit_price') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                        <div class="input-group mt-2 sm:mt-0">
                            <label for="crud-form-1" class="form-label">Direct Price</label>
                            <div id="input-group-5" class="input-group-text">BHD</div>
                            <input type="number" step="any" name="diret_price" class="form-control" placeholder="Direct Price" aria-describedby="input-group-5" value="{{$product->direct_cost}}">
                        </div>
                         @error('direct_price') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                    </div>
                </div><br>
                <div class="mt-3">                  
                    <div class="sm:grid grid-cols-3 gap-2">
                        <div class="input-group mt-2 sm:mt-0">
                            <label class="form-label">Tax Rate</label>
                            <div id="input-group-4" class="input-group-text">%</div>
                            <input type="text" name="tax_rate" class="form-control" placeholder="Tax Rate" aria-describedby="input-group-4" value="{{$product->tax_rate}}">
                        </div>
                         @error('tax_rate') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                        <div class="input-group mt-2 sm:mt-0">
                            <label class="form-label">Tax label</label>&nbsp;
                            <div class="input-group">
                                <input id="crud-form-4" type="text" class="form-control" placeholder="Tax lable" name="tax_label" value="TAX" aria-describedby="input-group-2" value="{{$product->tax_label}}">
                            </div>
                        </div>
                         @error('tax_label') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                    </div>
                </div><br>
                <div class="mt-3">
                    <label>Active Status</label>
                    <div class="form-switch mt-2">
                        <input type="checkbox" class="form-check-input" name="active"  {{ $product->is_active ? 'checked' : '' }}/>
                    </div>
                </div>
                 @error('active') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                <div class="text-right mt-5">
                    <button type="button" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button type="submit" class="btn btn-primary w-24">Save</button>
                </div>
            </div>
          </form>  
          <!-- END: Form Layout -->
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ mix('dist/js/ckeditor-classic.js') }}"></script>
@endsection
