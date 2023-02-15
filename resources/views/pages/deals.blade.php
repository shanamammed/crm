@extends('../layout/' . $layout)

@section('subhead')
    <title>CRUD Data List - Rubick - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <h2 class="intro-y text-lg font-medium mt-10">DEALS</h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{url('deals/add')}}"><button class="btn btn-primary shadow-md mr-2">Add New Deal</button></a>
            
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
                        <th class="whitespace-nowrap">OWNER</th>
                        <th class="whitespace-nowrap">DEAL NAME</th>
                        <th class="whitespace-nowrap">STAGE</th>
                        <th class="text-center whitespace-nowrap">AMOUNT</th>
                        <th class="text-center whitespace-nowrap">EXPECTED CLOSE DATE</th>
                        <th class="text-center whitespace-nowrap">STATUS</th>
                        <th class="text-center whitespace-nowrap">ACTION</th>
                    </tr>
                </thead>

                <tbody>
                   @if(count($deals)>0)   
                    @foreach ($deals as $deal)
                        <tr class="intro-x">
                            <td class="w-40">
                                <div class="flex">
                                    <div class="w-10 h-10 image-fit zoom-in">
                                        <img alt="SayG" class="tooltip rounded-full" src="{{ asset('dist/images/default.jpg') }}" title="{{ $deal->owner_name }}">
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">{{ $deal->name }}</td>
                            <td class="text-center">{{ $deal->stage }}</td>
                            <td class="text-center">BHD. {{ $deal->amount }}
                            </td>
                            <td class="text-center">{{ date('d M Y',strtotime($deal->expected_close_date)) }}</td>
                            <td class="text-center">{{ $deal->status  ? 'Open' : 'Closed' }}</td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a class="flex items-center mr-3" href="{{ url('deals/edit/'.$deal->id) }}">
                                        <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit
                                    </a>
                                    <a href="{{url('deals/delete/'.$deal->id)}}"><button class="flex items-center text-danger" type="button">
                                        <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                    </button></a>
                                    <!-- <a id="programmatically-show-modal" href="javascript:;" class="btn btn-primary mr-1 mb-2">Show Modal</a> -->
                                    <!-- <button type="button" id="MybtnModal" class="btn btn-primary">Open Modal Using jQuery</button> -->
                                    <!-- </button> -->
                                    <!-- <button id="notification-with-buttons-below-toggle" class="btn btn-primary">Show Notification</button> -->
                                </div>
                            </td>
                        </tr>
                    @endforeach
                   @else
                   <tr><td class="text-center" colspan="6">No data found</td></tr> 
                   @endif
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
    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-feather="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">Do you really want to delete these records? <br>This process cannot be undone.</div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                        <button type="button" class="btn btn-danger w-24">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->
@endsection
