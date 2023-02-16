@extends('../layout/' . $layout)

@section('subhead')
    <title>CRM</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Create Deal</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-9">
            <!-- BEGIN: Form Layout -->
          <form method="post" action="{{url('deals/update/'.$deal->id)}}">
            @csrf
            <div class="intro-y box p-5">
                <div class="mt-3">
                    <label for="crud-form-1" class="form-label">Deal Name<span style="color:red;">*</span></label>
                    <input id="crud-form-1" name="name" type="text" class="form-control w-full" placeholder="Deal Name" value="{{$deal->name}}" required>
                    @error('name') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>  
                
                <div class="mt-3">
                    <label for="crud-form-3" class="form-label">Pipeline<span style="color:red;">*</span></label>
                    <select data-placeholder="Select the pipeline" name="pipeline" class="tom-select w-full" required>
                        @foreach($pipeline as $pipe)
                         <option value="{{ $pipe->id }}" <?php if($pipe->id==$deal->pipeline_id) {?> selected <?php };?>>{{ $pipe->name }}</option>
                        @endforeach
                    </select>
                    @error('pipeline') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3">
                    <label for="crud-form-3" class="form-label">Stages<span style="color:red;">*</span></label>
                    <select data-placeholder="Select the stage" name="stage" class="tom-select w-full" required>
                        @foreach($stages as $stage)
                         <option value="{{ $stage->id }}" <?php if($stage->id==$deal->stage_id) {?> selected <?php };?>>{{ $stage->name }}</option>
                        @endforeach
                    </select>
                    @error('stage') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3">
                    <label for="crud-form-5" class="form-label">Amount</label>
                    <div class="input-group mt-2 sm:mt-0">
                        <div id="input-group-4" class="input-group-text">BHD</div>
                        <input type="number" step="any" name="amount" class="form-control" placeholder="Amount" aria-describedby="input-group-4" value="{{$deal->amount}}" required>
                    </div> 
                    @error('amount') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3">
                    <label for="crud-form-1" class="form-label">Expected Close Date<span style="color:red;">*</span></label>
                    <input id="crud-form-1" name="expected_close_date" type="date" class="form-control w-full" placeholder="Deal Name" value="{{$deal->expected_close_date}}" required>
                </div>
                <div class="mt-3">
                    <label for="crud-form-3" class="form-label">Owner<span style="color:red;">*</span></label>
                    <select data-placeholder="Select the owner" name="owner" class="tom-select w-full" required>
                        <option value="">Please select the owner</option>
                        @foreach($owners as $owner)
                         <option value="{{ $owner->id }}" <?php if($owner->id==$deal->user_id) {?> selected <?php };?>>{{ $owner->name }}</option>
                        @endforeach
                    </select>
                    @error('owner') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>
    
                <div class="mt-3">
                    <label for="crud-form-3" class="form-label">Companies</label>
                    <select data-placeholder="Select the companies" name="companies[]" class="tom-select w-full" multiple>
                        @foreach($companies as $company)
                         @foreach($company_deals as $comp)
                          <option value="{{$company->id}}" @if($company->id == $comp->company_id)selected="selected"@endif>{{$company->name}}</option>
                         @endforeach 
                        @endforeach
                    </select>
                    @error('companies') <span class="error" style="color:red;">{{ $message }}</span> @enderror
               </div>

                <div class="mt-3">
                    <label for="crud-form-3" class="form-label">Contacts</label>
                    <select data-placeholder="Select the contacts" name="contacts[]" class="tom-select w-full" multiple>
                        @foreach($contacts as $contact)
                         @foreach($deal_contacts as $cont)
                          <option value="{{$contact->id}}" @if($contact->id == $cont->contact_id)selected="selected"@endif>{{$contact->first_name.' '.$contact->last_name}}</option>
                         @endforeach 
                        @endforeach
                    </select>
                    @error('contacts') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>
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
