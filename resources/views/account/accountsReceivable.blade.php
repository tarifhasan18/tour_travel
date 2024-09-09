@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120px">
    <div class="content-wrapper">
        <div class="page-header d-flex justify-content-between align-items-center">
            <h3 class="page-title" style="margin-left: 20px">Accounts Receivable</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Reports</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> Accounts Receivable </li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Accounts Receivable</h4>
                        <div class="custom-table-formatter" style="overflow-x:scroll;">
                            <table id="example" class="table table-bordered">

                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Invoice</th>
                                        <!--<th>Items & Qty</th>-->
                                        <th class="text-nowrap">Create Date & Time</th>
                                        <th>Total</th>
                                        <th>Discount</th>
                                        <th>Paid</th>
                                        <th>Due</th>
                                        <th>Created By</th>
                                        <th>Print</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @foreach ($CartInfo as $user)
                                        <tr>
                                            <td style="width: 10px;">{{ $i++ }}</td>
                                            <td style="width: 60px;">{{ $user->cart_id }}</td>
                                            {{--<td style="width: 250px;">
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
                                            </td>--}}
                                            <td style="width: 60px;">{{ $user->cart_date }}</td>
                                            <td style="width: 60px;">{{ $user->total_cart_amount }}</td>
                                            <td style="width: 60px;">{{ $user->total_discount }}</td>
                                            <td style="width: 60px;">{{ $user->paid_amount }}</td>
                                            <td style="width: 60px;">{{ $user->due_amount }}</td>

                                            <td style="width: 60px;">{{ $user->created_by_name }}</td>
                                            <td><a target="_blank" class="brn"
                                                    href="{{ route('printInvoice', $user->cart_id) }}"><img
                                                        style="width:40px"
                                                        src="{{ asset('backend/printer.webp') }}"
                                                        alt="print"></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th>{{ $CartInfo->count() }}</th>
                                        <th></th>
                                        <!--<th></th>-->
                                        <th>{{ $CartInfo->sum('total_cart_amount') }}</th>
                                        <th>{{ $CartInfo->sum('total_discount') }}</th>
                                        <th>{{ $CartInfo->sum('paid_amount') }}</th>
                                        <th>{{ $CartInfo->sum('due_amount') }}</th>

                                        <th></th>
                                        <th></th>
                                    </tr>
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

@include('admin.footer')
