@extends('../layout/' . $layout)

@section('subhead')
    <title>CRUD Data List - Rubick - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <h2 class="intro-y text-lg font-medium mt-10">Products</h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{url('products/add')}}"><button class="btn btn-primary shadow-md mr-2">Add New Product</button></a>
           
            <div class="hidden md:block mx-auto text-slate-500">Showing 1 to 10 of 150 entries</div>
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
                        <th class="whitespace-nowrap">PRODUCT NAME</th>
                        <th class="text-center whitespace-nowrap">SKU</th>
                         <th class="text-center whitespace-nowrap">UNIT PRICE</th>
                         <th class="text-center whitespace-nowrap">TAX RATE</th>
                        <th class="text-center whitespace-nowrap">STATUS</th>
                        <th class="text-center whitespace-nowrap">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="intro-x">
                            <td>
                                <span class="font-medium whitespace-nowrap">{{ $product->name }}</span>
                            </td>
                            <td class="text-center">{{ $product->sku }}</td>
                            <td class="text-center">BHD {{ $product->unit_price }}</td>
                            <td class="text-center">{{ $product->tax_rate }}%</td>
                            <td class="w-40">
                                <div class="flex items-center justify-center {{ $product->is_active ? 'text-success' : 'text-danger' }}">
                                    <i data-feather="check-square" class="w-4 h-4 mr-2"></i> {{ $product->is_active  ? 'Active' : 'Inactive' }}
                                </div>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a class="flex items-center mr-3" href="{{ url('products/edit/'.$product->id) }}">
                                        <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit
                                    </a>
                                    <a href="{{url('products/delete/'.$product->id)}}"><button class="flex items-center text-danger" type="button" data-tw-toggle="modal">
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
   <!-- BEGIN: Modal Content -->
    <div id="programmatically-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-10 text-center">
                    <!-- BEGIN: Hide Modal Toggle -->
                    <a id="programmatically-hide-modal" href="javascript:;" class="btn btn-primary mr-1">Hide Modal</a>
                    <!-- END: Hide Modal Toggle -->
                    <!-- BEGIN: Toggle Modal Toggle -->
                    <a id="programmatically-toggle-modal" href="javascript:;" class="btn btn-primary mr-1">Toggle Modal</a>
                    <!-- END: Toggle Modal Toggle -->
                </div>
            </div>
        </div>
    </div>
    <!-- END: Modal Content -->

    <div class="modal fade" id="Mymodal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button> 
                <h4 class="modal-title">Notification</h4>                                                             
            </div> 
            <div class="modal-body">
                Are you sure you want to continue?
            </div>   
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                               
            </div>
        </div>                                                                       
    </div>                                          
</div>
@endsection
@push('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
@endpush
@push('scripts')
<script>
$(document).ready(function(){
    $('#MybtnModal').click(function(){
        alert('ok');
        // $('#Mymodal').modal('show')
    });
});
</script>
@endpush