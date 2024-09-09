@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<style>
    .daily-purchese-table-box th, .daily-purchese-table-box td{
        font-size: 12px !important;
    }
</style>
<div class="main-panels" style="padding-top: 120px">
    <div class="content-wrapper">
        <div class="page-header justify-content-between">
            <h3 class="page-title ml-4">Daily Purchase</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mr-4">
                    <li class="breadcrumb-item"><a href="#">Reports</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> Daily Purchase </li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    {{-- @if ( $user_data->role_id==4) --}}
                    @if (0)

                    @else
                    <div class="text-end mt-3 mr-4">
                        {{-- <button id="GetRowValue" class="btn btn-outline-primary btn-sm">To Vat</button> --}}
                     </div>
                    @endif
                    <div class="card-body">
                        <h4 class="card-title text-center">Daily Purchase</h4>
                        <div class="custom-table-formatter" class="daily-purchese-table-box" style="overflow-x:auto;">
                            <table id="cheack" class="table table-bordered">

                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>SL</th>
                                        <th class="text-nowrap">Pur No</th>
                                        <th class="text-nowrap">Items & Qty</th>
                                        <th class="text-nowrap">Pur Date & Time</th>
                                        <th class="text-nowrap">Total</th>
                                        <th class="text-nowrap">Discount</th>
                                        <th class="text-nowrap">Vat</th>
                                        <th class="text-nowrap">Payable</th>
                                        <th class="text-nowrap">Paid</th>
                                        {{-- @if ($user_data->role_id==4) --}}
                                        @if (1)

                                        @else
                                        <th>Is Vat</th>
                                        @endif
                                        <th>Due</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @foreach ($PurchaseInfo as $user)
                                    <tr>
                                        <td value="{{$user->purchase_id}}" class="also checkboxonly-{{$i}}"></td>
                                        <td style="width: 10px;">{{ $i++ }}</td>
                                        <td style="width: 60px;">{{ $user->purchase_id }}</td>
                                        <td style="width: 250px;">
                                            @php
                                            $cart_item_data = \App\Models\PurchaseDetail::join('products', 'products.product_id', '=', 'purchase_details.product_id')
                                            ->where('purchase_details.purchase_id', $user->purchase_id)
                                            ->select('purchase_details.quantity', 'products.product_name')
                                            ->get();
                                            @endphp
                                            @foreach ($cart_item_data as $itemdata)
                                            <div class="row pr-3 pt-2">
                                                <div class="col-12">
                                                    {{ $itemdata->product_name }}
                                                </div>
                                                <div class="col-12 mt-2">
                                                    {{ $itemdata->quantity }}
                                                </div>
                                                <div class="col-12 mt-2 text-right">
                                                    {{ $itemdata->purchase_price }}
                                                </div>
                                            </div>
                                            @endforeach

                                        </td>
                                        <td style="width: 60px;">{{ $user->pur_date }}</td>
                                        <td style="width: 60px;" class="text-right">{{ $user->total_item_price	 }}</td>
                                        <td style="width: 60px;" class="text-right">{{ $user->discount }}</td>
                                        <td style="width: 60px;" class="text-right">{{ $user->total_vat }}</td>
                                        <td style="width: 60px;" class="text-right">{{ $user->total_payable }}</td>
                                        @php
                                        $pay = \App\Models\SupplierPayment::where('purchase_id', $user->purchase_id)
                                        ->first();
                                        @endphp
                                        <td style="width: 60px;" class="text-right">{{ $pay->paid_amount }}</td>

                                        {{-- @if ($user_data->role_id==4) --}}
                                        @if (1)

                                        @else
                                        <td>@if ( $user->is_vat_show == 0)
                                            No
                                        @else
                                            Yes
                                        @endif</td>
                                        @endif

                                        </td>
                                        <td style="width: 60px;" class="text-right">{{ $pay->revised_due }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>

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
    $(document).ready(function () {
        $(document).on('click', '#GetRowValue', function() {
            var selectedRowIds = [];

            $('#cheack tbody input[type="checkbox"]:checked').each(function() {
                var rowId = $(this).closest('tr').find('td:nth-child(1)').attr('value'); // Assuming the ID is in the third column (index 2)
                selectedRowIds.push(rowId);
            });

            // Retrieve IDs from all pages
            if ($('#cheack').DataTable().page.info().pages > 1) {
                var currentPage = $('#cheack').DataTable().page();
                $('#cheack').DataTable().page.len(-1).draw(); // Show all rows on a single page
                $('#cheack tbody input[type="checkbox"]:checked').each(function() {
                    var rowId = $(this).closest('tr').find('td:nth-child(1)').attr('value'); // Assuming the ID is in the third column (index 2)
                    if (!selectedRowIds.includes(rowId)) {
                        selectedRowIds.push(rowId);
                    }
                });
                $('#cheack').DataTable().page.len(10).draw(); // Restore original page length
                $('#cheack').DataTable().page(currentPage).draw(); // Return to original page
            }

            // console.log(selectedRowIds);

            $.ajax({
                url: "all-purchase-report-for-vat",
                method: "GET",
                data:{
                    'selectedRowIds':selectedRowIds,
                },
                dataType: "json",
                success: function (response) {
                    // $('#tableVaue').empty();
                    swal("Success!", "SuccessFully Add For Vat Show", response.success)
                    // console.log(response.status);
                }
            });
        });

    });
</script>
@include('admin.footer')
