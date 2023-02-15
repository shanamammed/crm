@extends('../layout/' . $layout)

@section('subhead')
    <title>CRM</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Add Contact</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-9">
            <!-- BEGIN: Form Layout -->
          <form method="post" action="{{url('contacts/store')}}">
            @csrf
            <div class="intro-y box p-5">
                <div>
                    <label for="crud-form-1" class="form-label">Fist Name<span style="color:red;">*</span></label>
                    <input id="crud-form-1" name="first_name" type="text" class="form-control w-full" placeholder="First Name" required>
                    @error('first_name') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div><br>
                <div>
                    <label for="crud-form-1" class="form-label">Last Name<span style="color:red;">*</span></label>
                    <input id="crud-form-1" name="last_name" type="text" class="form-control w-full" placeholder="Last Name" required>
                    @error('last_name') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div><br>
                <div>
                    <label for="crud-form-5" class="form-label">Email Address</label>
                    <input id="crud-form-2" name="email" type="text" class="form-control w-full" placeholder="Email Address" required>
                    @error('email') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div><br>
                <div>
                    <label for="crud-form-2" class="form-label">Phone</label>
                     <table id="contact-phone" width="90%;">
                      <tr>
                        <td><input type="text" class="form-control phones" name="phones[]" id="phones"></td>
                        <!-- <td>
                            <select>
                                <option value="Mobile">Mobile</option>
                                <option value="Work">Work</option>
                                <option value="Other">Other</option>
                            </select>
                        </td> -->
                        <td style="text-align:center;"> - </td>
                      </tr>
                    </table>
                    <!-- <div class="text-center">
                      <button type="button" class="btn btn-link" onclick="addRowSize()"><i style="font-size:25px;" class="fas fa-plus-circle"></i></button>
                    </div> -->
                    @error('domain') <span class="error" style="color:red;">{{ $message }}</span> @enderror
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
                    <label for="crud-form-3" class="form-label">Source</label>
                    <select data-placeholder="Select the source" name="source" class="tom-select w-full">
                        <option value="">Please select the source</option>
                        @foreach($sources as $source)
                         <option value="{{ $source->id }}" >{{ $source->name }}</option>
                        @endforeach
                    </select>
                    @error('source') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3">
                    <label for="crud-form-3" class="form-label">Deals</label>
                    <select data-placeholder="Select the deal" name="deals[]" class="tom-select w-full" multiple>
                        @foreach($deals as $deal)
                        <option value="{{$deal->id}}" selected>{{$deal->name}}</option>
                        @endforeach
                    </select>
                    @error('deals') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3">
                    <label for="crud-form-3" class="form-label">Companies</label>
                    <select data-placeholder="Select the contact" name="companies[]" class="tom-select w-full" multiple>
                        @foreach($companies as $company)
                        <option value="{{$company->id}}" selected>{{$company->name}}</option>
                        @endforeach
                    </select>
                    @error('companies') <span class="error" style="color:red;">{{ $message }}</span> @enderror
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
    <script type="text/javascript">
        function addRowSize()
        {
            var col1 = "<tr><td><input type='text' class='form-control' name='phones[]' required></td></tr";
            // var col2 = "<td><input type='text' class='form-control' name='types[]' required></td>";
            // var col3 = "<td><a class='btn btn-link' onclick='deleteRow(this);'><i style='font-size:25px; color:red;' class='fa fa-trash'></i></a></td></tr>";
            var row = col1;
            $('#contact-phone').append(row);
        }
    </script>
@endsection
