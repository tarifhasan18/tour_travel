@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120px">
    <div class="content-wrapper">
        <div class="page-header justify-content-between">
            <h3 class="page-title ml-4">Accounts Payable</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mr-4">
                    <li class="breadcrumb-item"><a href="#">Reports</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> Accounts Payable </li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Accounts Payable</h4>
                        <div  class="custom-table-formatter" style="overflow-x:scroll;">
                            <table id="example_id" class="table table-bordered">

                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Pur. No.</th>
                                        <!--<th>Items & Qty</th>-->
                                        <th>Date & Time</th>
                                        <th>Total</th>
                                        <th>Discount</th>
                                        <th>Vat</th>
                                        <th>Payable</th>
                                        <th>Paid</th>
                                        <th>Due</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @foreach ($PurchaseInfo as $user)
                                        <tr>
                                            <td style="width: 10px;">{{ $i++ }}</td>
                                            <td style="width: 60px;">{{ $user->purchase_id }}</td>
                                            {{--<td style="width: 250px;">
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
                                                    <div class="col-12 mt-2">
                                                        {{ $itemdata->purchase_price }}
                                                    </div>
                                                </div>
                                                @endforeach
                                            </td>--}}
                                            <td style="width: 60px;">{{ $user->pur_date }}</td>
                                            <td style="width: 60px;">{{ $user->total_item_price	 }}</td>
                                            <td style="width: 60px;">{{ $user->discount }}</td>
                                            <td style="width: 60px;">{{ $user->total_vat }}</td>
                                            <td style="width: 60px;">{{ $user->total_payable }}</td>
                                            @php
                                                    $pay = \App\Models\SupplierPayment::where('purchase_id', $user->purchase_id)
                                                        ->first();
                                            @endphp
                                            <td style="width: 60px;">{{ $pay->paid_amount }}</td>
                                            <td style="width: 60px;">{{ $pay->revised_due }}</td>
                                            <td><a target="_blank" class="brn"
                                                    href="#"><img
                                                        style="width: 40px; height:30px"
                                                        src="{{ asset('backend/printer.webp') }}"
                                                        alt="print"></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>SL</th>
                                        <th>Pur. No.</th>
                                        <!--<th>Items & Qty</th>-->
                                        <th>Date & Time</th>
                                        <th>Total</th>
                                        <th>Discount</th>
                                        <th>Vat</th>
                                        <th>Payable</th>
                                        <th>Paid</th>
                                        <th>Due</th>
                                        <th>Action</th>
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
