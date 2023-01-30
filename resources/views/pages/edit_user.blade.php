@extends('../layout/' . $layout)

@section('subhead')
    <title>CRUD Form - Rubick - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Add User</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-8">
            <!-- BEGIN: Form Layout -->
           <form method="post"  action="{{url('users/update/'.$user->id)}}"> 
            @csrf
            <div class="intro-y box p-5">
                <div>
                    <label for="crud-form-1" class="form-label">User Name</label>
                    <input id="crud-form-1" name="name" type="text" class="form-control w-full" placeholder="User Name" value="{{$user->name}}" required>
                     @error('name') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3">
                    <label for="crud-form-3" class="form-label">Email</label>
                    <div class="input-group">
                        <div id="input-group-email" class="input-group-text">@</div>
                        <input type="text" name="email" value="{{$user->email}}" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="input-group-email" required>
                    </div>
                   
                    @error('email') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3">
                    <label for="crud-form-2" class="form-label">Roles</label>
                    <select data-placeholder="Select the role" class="tom-select w-full" name="roles[]" id="crud-form-2" multiple>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}" @if(in_array($role->id, $userRole)) selected @endif>{{ $role->name }}</option>
                       @endforeach
                    </select>
                     @error('roles') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                </div>
                <div class="mt-3">
                    <label>Active Status</label>
                    <div class="form-switch mt-2">
                        <input type="checkbox" name="active" class="form-check-input" value="1" {{  ($user->active == 1 ? ' checked' : '') }}>
                    </div>
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
