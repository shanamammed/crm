@extends('../layout/' . $layout)

@section('subhead')
    <title>CRM</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Edit Company</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-9">
            <!-- BEGIN: Form Layout -->
          <form method="post" action="{{url('companies/update/'.$company->id)}}">
            @csrf
            <div class="intro-y box p-5">
                <div>
                    <label for="crud-form-1" class="form-label">Company Name<span style="color:red;">*</span></label>
                    <input id="crud-form-1" name="name" type="text" class="form-control w-full" placeholder="Company Name" value="{{$company->name}}" required>
                    @error('name') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div><br>
                <div>
                    <label for="crud-form-2" class="form-label">Company Domain</label>
                    <input id="crud-form-2" name="domain" type="text" class="form-control w-full" placeholder="Company Domain" value="{{$company->domain}}" required>
                    @error('domain') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div><br>
                <div>
                    <label for="crud-form-5" class="form-label">Email Address</label>
                    <input id="crud-form-2" name="email" type="text" class="form-control w-full" placeholder="Email Address" value="{{$company->email}}" required>
                    @error('email') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3">
                    <label for="crud-form-3" class="form-label">Owner</label>
                    <select data-placeholder="Select the owner" name="owner" class="tom-select w-full" required>
                        <option value="">Please select the owner</option>
                        @foreach($owners as $owner)
                         <option value="{{ $owner->id }}" <?php if($owner->id=='1') {?> selected <?php };?>>{{ $owner->name }}</option>
                        @endforeach
                    </select>
                    @error('owner') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3">
                    <label for="crud-form-3" class="form-label">Deals</label>
                    <select data-placeholder="Select the deal" name="deals[]" class="tom-select w-full" multiple>
                        @foreach($deals as $deal)
                        <option @if (in_array($deal->id, $company_deals)) {{"selected"}} @endif value={{$deal->id}}>{{$deal->name}}</option>
                        @endforeach
                    </select>
                    @error('deals') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3">
                    <label for="crud-form-3" class="form-label">Contacts</label>
                    <select data-placeholder="Select the contact" name="contacts[]" class="tom-select w-full" multiple>
                        @foreach($contacts as $contact)
                         <option @if (in_array($contact->id, $company_contacts)) {{"selected"}} @endif value={{$contact->id}}>{{$contact->name}}</option>
                        @endforeach
                    </select>
                    @error('contacts') <span class="error" style="color:red;">{{ $message }}</span> @enderror
               </div>
               <div class="mt-3">
                    <label>Active Status</label>
                    <div class="form-switch mt-2">
                        <input type="checkbox" class="form-check-input" name="active"  {{ $company->is_active ? 'checked' : '' }}/>
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
