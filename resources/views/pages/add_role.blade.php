@extends('../layout/' . $layout)

@section('subhead')
    <title>CRM-SayG</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Add Role</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Vertical Form -->
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">Add Role</h2>
                   <!--  <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                        <label class="form-check-label ml-0" for="show-example-6">Show example code</label>
                        <input id="show-example-6" data-target="#vertical-form" class="show-code form-check-input mr-0 ml-3" type="checkbox">
                    </div> -->
                </div>
                <div id="vertical-form" class="p-5">
                 <form method="post" action="{{ url('roles/store') }}"> 
                    @csrf
                    <div class="preview">
                        <div>
                            <label for="vertical-form-1" class="form-label">Role Name</label>
                            <input id="vertical-form-1" name="name" type="text" class="form-control" placeholder="Role Name" required><br>
                             @error('name') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mt-3">
                             <label>Permissions</label>
                             @foreach($permissions as $permission)
                            <div class="form-check mt-2">
                               <!--  <input id="checkbox-switch-{{$permission->id}}" class="form-check-input" type="checkbox" value="{{ $permission->id }}" name="permission[]" >
                                <label class="form-check-label" for="checkbox-switch-1">{{ $permission->name }}</label> -->
                                <label>{{ Form::checkbox('permission[]', $permission->id, true, array('class' => 'name')) }}
                                {{ $permission->name }}</label>
                            </div>
                            @endforeach
                            <br>
                            @error('permission') <span class="error" style="color:red;">{{ $message }}</span> @enderror
                        </div>
                        <button class="btn btn-primary mt-5" type="submit">Submit</button>
                    </div>
                  </form>    
                </div>
            </div>
            <!-- END: Vertical Form -->
        </div>
    </div>
@endsection
