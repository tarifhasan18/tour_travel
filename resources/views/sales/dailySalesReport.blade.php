@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')

<div class="main-panels" style="padding-top: 120px">
    <div class="content-wrapper">
        <div class="page-header justify-content-between">
            <h3 class="page-title" style="margin-left: 20px">Daily Sales</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Reports</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> Daily Sales </li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    {{-- @if ($user_data->role_id==4) --}}
                    @if (0)

                    @else
                    <div class="text-end mt-3 mr-4">
                        <button id="addVat" class="btn btn-outline-primary btn-sm">To Vat</button>
                    </div>
                    @endif


                    <div class="card-body">
                        <h4 class="card-title text-center">Daily Sales</h4>
                        <div  class="custom-table-formatter" style="overflow-x:scroll;">
                            <table id="dailychecked" class="table table-bordered">

                                <thead>
                                    <tr>
                                        <th class="text-nowrap"></th>
                                        <th class="text-nowrap">SL</th>
                                        <th class="text-nowrap">Order No</th>
                                        <th class="text-nowrap">Items & Qty</th>
                                        <th class="text-nowrap">Create Date & Time</th>
                                        <th class="text-nowrap">Total</th>
                                        <th class="text-nowrap">Discount</th>
                                        <th class="text-nowrap">Paid</th>
                                        <th class="text-nowrap">Created By</th>
                                        {{-- @if ($user_data->role_id==4) --}}
                                        @if (0)
                                        @else
                                        <th>Is Vat</th>
                                        @endif
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @foreach ($CartInfo as $user)
                                    <tr>
                                        <td value="{{$user->cart_id}}" class="also checkboxonly-{{$i}}"></td>
                                        <td style="width: 10px;">{{ $i++ }}</td>
                                        <td style="width: 60px;">{{ $user->cart_id }}</td>
                                        <td style="width: 250px;">
                                            @php

                                            $cart_item_data = \App\Models\CartItem::join('products', 'products.product_id', '=', 'cart_items.product_id')
                                            ->where('cart_items.cart_id', $user->cart_id)
                                            ->select('cart_items.quantity', 'products.product_name')
                                            ->get();

                                            @endphp

                                            @foreach ($cart_item_data as $itemdata)
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="text-nowrap">
                                                    {{ $itemdata->product_name }} :

                                                </div>
                                                <div class="text-nowrap ps-1">
                                                    {{ $itemdata->quantity }}
                                                </div>
                                            </div>
                                            @endforeach
                                        </td>



                                        <td style="width: 60px;">{{ $user->cart_date }}</td>

                                        <td style="width: 60px;" class="text-right">{{ $user->total_cart_amount }}</td>
                                        <td style="width: 60px;" class="text-right">{{ $user->total_discount ?? 0  }}</td>
                                        <td style="width: 60px;" class="text-right">{{ $user->paid_amount }}</td>

                                        <td style="width: 60px;">{{ $user->created_by_name }}</td>


                                        {{-- @if ($user_data->role_id==4) --}}
                                        @if (0)
                                        @else
                                        <td>@if ( $user->is_vat_show == 0)
                                            No
                                            @else
                                            Yes
                                            @endif</td>

                                        @endif

                                        </td>
                                        <td><a target="_blank" class="brn" href="{{ route('printInvoice', $user->cart_id) }}"><img class="img-fluid" src="{{ asset('backend/printer.webp') }}" alt="print"></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    {{-- <tr>
                                            <th>Total</th>
                                            <th>{{ $CartInfo->count() }}</th>
                                    <th></th>
                                    <th></th>
                                    <th>{{ $CartInfo->sum('total_cart_amount') }}</th>
                                    <th>{{ $CartInfo->sum('total_discount') }}</th>
                                    <th>{{ $CartInfo->sum('paid_amount') }}</th>

                                    <th></th>
                                    <th></th>
                                    </tr> --}}
                                    {{-- <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr> --}}
                                </tfoot>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {
        $(document).on('click', '#addVat', function() {
            var selectedRowIds = [];

            $('#dailychecked tbody input[type="checkbox"]:checked').each(function() {
                var rowId = $(this).closest('tr').find('td:nth-child(1)').attr('value'); // Assuming the ID is in the third column (index 2)
                selectedRowIds.push(rowId);
            });

            // Retrieve IDs from all pages
            if ($('#dailychecked').DataTable().page.info().pages > 1) {
                var currentPage = $('#dailychecked').DataTable().page();
                // console.log('Hello');
                $('#dailychecked').DataTable().page.len(-1).draw(); // Show all rows on a single page
                $('#dailychecked tbody input[type="checkbox"]:checked').each(function() {
                    var rowId = $(this).closest('tr').find('td:nth-child(1)').attr('value'); // Assuming the ID is in the third column (index 2)
                    if (!selectedRowIds.includes(rowId)) {
                        selectedRowIds.push(rowId);
                    }
                });
                $('#dailychecked').DataTable().page.len(10).draw(); // Restore original page length
                $('#dailychecked').DataTable().page(currentPage).draw(); // Return to original page
            }

            console.log(selectedRowIds);

            $.ajax({
                url: "all_sales_report_show_vat_admin",
                method: "GET",
                data: {
                    'selectedRowIds': selectedRowIds,
                },
                dataType: "json",
                success: function(response) {
                    // $('#tableVaue').empty();
                    swal("Success!", "SuccessFully Add For Vat Show", response.success)
                    // console.log(response.status);
                }
            });
        });

    });
</script>
@include('admin.footer')
