@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120px">
    <div class="content-wrapper">
        <div class="page-header justify-content-between">

            <h3 class="page-title" style="margin-left: 20px">All Sales</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Reports</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> All Sales </li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    {{-- @if ($user_data->role_id==4) --}}
                    @if (0)

                    @else
                    <div>
                        <div class="card-description w-25 float-right">
                            <div class="input-group mb-3">
                                <select aria-label="Default" aria-describedby="inputGroup-sizing-default" class="form-control" name="category_id" id="category_id">
                                    <option selected disabled>-------Select-------</option>
                                    @foreach($consumer as $con)
                                    <option value="{{$con->login_id}}">{{$con->mobile_no}}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-light" id="inputGroup-sizing-default">Customer</span>
                                </div>
                            </div>


                             {{-- <button id="GetRowValue" class="btn btn-outline-primary btn-sm">To Vat</button> --}}


                        </div>
                    </div>
                    @endif


                    <div class="card-body">

                        <h4 class="card-title text-center">All Sales</h4>
                        <div class="custom-table-formatter" style="overflow-x:auto;">
                            <table id="cheack" class="table table-bordered">

                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>SL</th>
                                        <th>Order No</th>
                                        <th>Items & Qty</th>
                                        <th>Create Date & Time</th>
                                        <th>Total</th>
                                        <th>Discount</th>
                                        <th>Paid</th>
                                        <th>Created By</th>
                                        {{-- @if ($user_data->role_id==4) --}}
                                        @if (1)
                                        @else
                                        <th>Is Vat</th>
                                        @endif
                                        <th>Print</th>

                                    </tr>
                                </thead>
                                <tbody id="sell_table">
                                    @php $i=1; @endphp
                                    @foreach ($CartInfo as $user)
                                    <tr>
                                        <td value="{{$user->cart_id}}" class="also checkboxonly-{{$i}}"></td>
                                        <td style="width: 10px;">{{ $i++ }}</td>
                                        <td style="width: 60px;">{{ $user->cart_id }}</td>
                                        <td style="width: 250px; height:40px">
                                            @php
                                            $cart_item_data = \App\Models\CartItem::join('products', 'products.product_id', '=', 'cart_items.product_id')
                                            ->where('cart_items.cart_id', $user->cart_id)
                                            ->select('cart_items.quantity', 'products.product_name')
                                            ->get();
                                            @endphp
                                            @foreach ($cart_item_data as $itemdata)
                                            <div class="row pr-3 pt-2">
                                                <div class="col-12 col-lg-6 col-md-6 text-truncate">
                                                    {{ $itemdata->product_name }}
                                                </div>
                                                <div class="col-12 col-lg-6 col-md-6">
                                                    {{ $itemdata->quantity }}
                                                </div>
                                            </div>
                                            @endforeach
                                        </td>
                                        <td style="width: 60px;">{{ $user->cart_date }}</td>
                                        <td style="width: 60px;" class="text-right">{{ $user->total_cart_amount }}</td>
                                        <td style="width: 60px;" class="text-right">{{ $user->total_discount }}</td>
                                        <td style="width: 60px;" class="text-right">{{ $user->paid_amount }}</td>

                                        <td style="width: 60px;">{{ $user->created_by_name }}</td>
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
                                        <td><a target="_blank" class="brn" href="{{ route('printInvoice', $user->cart_id) }}"><img class="img-fluid" src="{{ asset('backend/printer.webp') }}" alt="print"></a>

                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Total</th>
                                        <th>{{ $CartInfo->count() }}</th>
                                        <th></th>
                                        <th></th>
                                        <th>{{ $CartInfo->sum('total_cart_amount') }}</th>
                                        <th>{{ $CartInfo->sum('total_discount') }}</th>
                                        <th>{{ $CartInfo->sum('paid_amount') }}</th>

                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>

                            </table>

                        </form>
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


<script type="text/javascript">
    $(document).ready(function() {

        $(document).on('change', '#category_id', function(e) {
            e.preventDefault();
            var category_id = $(this).val();
            // from store
            $.ajax({
                url: "CatWiseSells/" + category_id,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(data) {
                    $("#sell_table").empty();
                    var stockhtml = "";
                    $.each(data, function(key, value) {
                        stockhtml += '<tr>'
                        stockhtml += '<td value="' + value.cart_id + '" class="also checkboxonly"></td>'
                        stockhtml += '<td>' + (key + 1) + '</td>'
                        stockhtml += '<td>' + value.cart_id + '</td>'
                        stockhtml += '<td id="test-' + value.cart_id + '">'

                        $.ajax({
                            url: "product-name-quantity/" + value.cart_id,
                            type: "GET",
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            dataType: "json",
                            success: function(pro) {
                                proHtml = ""
                                $.each(pro, function(k, val) {

                                    proHtml += '<div class="row pr-3 pt-2"><div class="col-12 col-lg-6 col-md-6 text-truncate">' + val.product_name + '</div><div class="col-12 col-lg-6 col-md-6">' + val.quantity + '</div></div>'


                                });

                                $("#" + "test-" + value.cart_id).append(proHtml)
                            }
                        });

                        stockhtml += '</td>'

                        stockhtml += '<td>' + value.cart_date.split("T")[0] + ' ' + value.cart_date.split("T")[1].split(".")[0] + '</td>'
                        stockhtml += '<td class="text-right">' + value.final_total_amount + '</td>'
                        stockhtml += '<td class="text-right">' + value.total_discount + '</td>'
                        stockhtml += '<td class="text-right">' + value.paid_amount + '</td>'
                        stockhtml += '<td>' + value.created_by_name + '</td>'
                        if(value.is_vat_show==0){
                            stockhtml += '<td>No</td>'
                        }
                        else{
                            stockhtml += '<td>Yes</td>'
                        }
                        // stockhtml += '<td>' + value.created_by_name + '</td>'

                        stockhtml += '<td><a target="_blank" class="brn" href="/POSSIE/public/backoffice/printInvoice/' + value.cart_id + '"><img src="http://localhost/POSSIE/public/backend/printer.webp" alt="print"></a>'
                        stockhtml += '</tr>'
                    });
                    $("#sell_table").append(stockhtml);
                }
            });
        });

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
                url: "all_sales_report_show_vat_admin",
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
