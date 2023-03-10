@extends('../layout/' . $layout)

@section('subhead')
    <title>CRUD Data List - Rubick - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <h2 class="intro-y text-lg font-medium mt-10">Users</h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
       
       <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        @can('user-create')    
            <a href="{{url('users/add')}}"><button class="btn btn-primary shadow-md mr-2">Add New User</button></a>
        @endcan   
            <div class="hidden md:block mx-auto text-slate-500"></div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-slate-500">
                    <input type="text" class="form-control w-56 box pr-10" placeholder="Search...">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>
                </div>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">USER NAME</th>
                        <th class="text-center whitespace-nowrap">EMAIL</th>
                        <th class="text-center whitespace-nowrap">STATUS</th>
                       @canany(['user-edit', 'user-delete'])  
                        <th class="text-center whitespace-nowrap">ACTIONS</th>
                       @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="intro-x">
                            <td>
                                <span class="font-medium whitespace-nowrap">{{ $user->name }}</span>
                            </td>
                            <td class="text-center">{{ $user->email }}</td>
                            <td class="w-40">
                                <div class="flex items-center justify-center {{ $user->active ? 'text-success' : 'text-danger' }}">
                                    <i data-feather="check-square" class="w-4 h-4 mr-2"></i> {{ $user->active  ? 'Active' : 'Inactive' }}
                                </div>
                            </td>
                            @canany(['user-edit', 'user-delete']) 
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    @can('user-edit')
                                    <a class="flex items-center mr-3" href="{{ url('users/edit/'.$user->id) }}">
                                        <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit
                                    </a>
                                    @endcan
                                    <!-- <button class="flex items-center text-danger" type="button" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal" id="notification-with-buttons-below-toggle">
                                        <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                    </button> -->
                                    @can('user-delete')
                                    <a class="flex items-center text-danger" type="button" onclick="return confirm('Are you sure to delete this user?')" href="{{ url('users/delete/'.$user->id) }}"><i data-feather="trash-2" class="w-4 h-4 mr-1"></i>Delete</a>
                                    @endcan
                                    <!-- <button id="notification-with-buttons-below-toggle" class="btn btn-primary">Show Notification</button> -->
                                </div>
                            </td>
                            @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            <nav class="w-full sm:w-auto sm:mr-auto">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <i class="w-4 h-4" data-feather="chevrons-left"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <i class="w-4 h-4" data-feather="chevron-left"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">...</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">...</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <i class="w-4 h-4" data-feather="chevron-right"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <i class="w-4 h-4" data-feather="chevrons-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <select class="w-20 form-select box mt-3 sm:mt-0">
                <option>10</option>
                <option>25</option>
                <option>35</option>
                <option>50</option>
            </select>
        </div>
        <!-- END: Pagination -->
    </div>
    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="notification-with-buttons-below-content" class="toastify-content hidden flex">
        <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
        <div class="ml-4 mr-5 sm:mr-20">
           <form action="{{ url('users/delete/'.$user->id) }}"> 
                <div class="font-medium">Delete User</div>
                <div class="text-slate-500 mt-1">Are you sure to delete?</div>
                <div class="mt-2.5">
                    <a class="btn btn-primary py-1 px-2 mr-2" href="">Yes</a>
                    <a class="btn btn-outline-secondary py-1 px-2" href="">No</a>
                </div>
           </form>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->
@endsection
