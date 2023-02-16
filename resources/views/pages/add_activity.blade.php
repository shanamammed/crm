@extends('../layout/' . $layout)

@section('subhead')
    <title>CRM</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Create Activity</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-9">
            <!-- BEGIN: Form Layout -->
          <form method="post" action="{{url('activities/store')}}">
            @csrf
            <div class="intro-y box p-5">
                <div class="mt-3">
                    <label for="crud-form-1" class="form-label">Title<span style="color:red;">*</span></label>
                    <input id="crud-form-1" name="title" type="text" class="form-control w-full" placeholder="Title" required>
                    @error('title') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3">
                    <label for="crud-form-3" class="form-label">Activity Type<span style="color:red;">*</span></label>
                    <select data-placeholder="Select the type" name="type" class="tom-select w-full" required>
                        @foreach($types as $type)
                         <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('type') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3">
                    <label for="crud-form-2" class="form-label">Due date & time</label>
                     <table width="100%;">
                      <tr>
                        <td><input type="date" class="form-control phones" name="due_date" value="{{ date('Y-m-d') }}" required></td>
                        <td style="text-align:center;"> - </td>
                        <td><input type="time" class="form-control phones" name="due_time"></td>
                      </tr>
                    </table>
                    @error('due_date') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3">
                    <label for="crud-form-2" class="form-label">End date & time</label>
                     <table width="100%;">
                      <tr>
                        <td><input type="date" class="form-control phones" name="end_date" value="{{ date('Y-m-d') }}" required></td>
                        <td style="text-align:center;"> - </td>
                        <td><input type="time" class="form-control phones" name="end_time"></td>
                      </tr>
                    </table>
                    @error('end_date') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div><br>
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
                    <label>Notes</label>
                    <div class="mt-2">
                        <div class="editor">
                            <p><textarea name="note"></textarea></p>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="crud-form-3" class="form-label">Guests</label>
                    <select data-placeholder="Select the owner" name="guests[]" class="tom-select w-full" multiple>
                        @foreach($owners as $owner)
                         <option value="{{ $owner->id }}" >{{ $owner->name }}</option>
                        @endforeach
                    </select>
                    @error('guests') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3">
                    <label>Description</label>
                    <div class="mt-2">
                        <div class="editor">
                            <p><textarea name="description"></textarea></p>
                        </div>
                    </div>
                </div>
                
            </div><br>

            <div class="intro-y box p-5">
                <div class="mt-3">
                    <label for="crud-form-3" class="form-label">Deals</label>
                    <select data-placeholder="Select the deal" name="deals[]" class="tom-select w-full" multiple>
                        @foreach($deals as $deal)
                        <option value="{{$deal->id}}">{{$deal->name}}</option>
                        @endforeach
                    </select>
                    @error('deals') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3">
                    <label for="crud-form-3" class="form-label">Companies</label>
                    <select data-placeholder="Select the companies" name="companies[]" class="tom-select w-full" multiple>
                        @foreach($companies as $company)
                        <option value="{{$company->id}}">{{$company->name}}</option>
                        @endforeach
                    </select>
                    @error('companies') <span class="error" style="color:red;">{{ $message }}</span> @enderror
               </div>
               <div class="mt-3">
                    <label for="crud-form-3" class="form-label">Contacts</label>
                    <select data-placeholder="Select the contacts" name="contacts[]" class="tom-select w-full" multiple>
                        @foreach($contacts as $contact)
                        <option value="{{ $contact->id }}" >{{ $contact->first_name.' '.$contact->last_name }}</option>
                        @endforeach
                    </select>
                    @error('contacts') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>
            </div><br>

            <div class="intro-y box p-5">
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
