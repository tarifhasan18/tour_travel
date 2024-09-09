<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.links')
    <style>

        .invoice-body {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }

        .invoice-body h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2em;
            color: #333;
        }

        .section-container {
            display: flex;
            justify-content: space-between;
        }

        .left-section, .right-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .left-section {
            width: 49%;
            height: auto;
        }

        .right-section {
            width: 49%;
            height: auto;
        }

        .section {
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #fafafa;
            max-height: 500px;
            overflow-y: auto;
            height: 300px;
        }

        .section h2 {
            margin-bottom: 15px;
            font-size: 1.5em;
            color: #555;
        }

        #category, #subcategory, #products {
            max-height: 500px; /* Adjust as needed */
        }

        #purchased-products, #total-purchase-info, #payment-info {
            max-height: 550px; /* Adjust as needed */
        }
        .category_items{
            float: left;
            padding: 10px;
            background-color: blue;
            color: white;
            margin: 10px;
        }
    </style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    @include('admin.sidebar')
    @include('admin.navbar')
    <div class="container">
        <div class="page-inner">
            <div class="main-panel">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12" style="margin-top: 10px;">
                            <div class="card">
                                <div>
                                    <div class="row pt-3 px-3">
                                        <div class="col-md-6">
                                            <div class="mt-2 h5 text-right">PURCHASE INVOICE</div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mt-2 float-right">
                                                <select class="p-2 form-control" name="suspended_items"
                                                    id="suspended_items">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="overflow-x:scroll;">

                                    <form action="{{ route('backoffice.store-purchase-form') }}" method="post"
                                        enctype="multipart/form-data">
                                        @if (Session::get('success'))
                                            <div class="alert alert-success">
                                                {{ Session::get('success') }}
                                            </div>
                                        @endif

                                        @csrf

                                        <div class="row">
                                            <div class="col-md-6 col-lg-6 card p-2">
                                                <div class="">CATEGORIES</div>
                                                <hr>
                                                <div class="row" style="overflow:scroll; height:200px;"
                                                    id="all-category"></div>
                                                <hr />
                                                <div class="">SUB CATEGORIES</div>
                                                <hr>
                                                <div class="row" style="overflow:scroll; height:200px;"
                                                    id="all-sub-category"></div>
                                                <hr />
                                                <div class="">PRODUCTS</div>
                                                <hr>
                                                <div class="search d-flex justify-content-between">
                                                        <input
                                                            style="padding-right: 25px;
                                                        background: url('https://static.thenounproject.com/png/101791-200.png') no-repeat right;
                                                        background-size: 20px;"
                                                            class="form-control" type="text" id="myInput" onkeyup="test()"
                                                            placeholder="Search for Product">

                                                            <select data-placeholder="Barcode" class="form-control select2-plugin" name="barcode_search" id="purchase_barcode_search"></select>

                                                    </div>
                                                <div class="row" style="overflow:scroll; height:600px;">
                                                    <div class="col-12">
                                                        <table id="myTable"
                                                            style="width: 100%;
                                                        margin-bottom: 1rem;
                                                        color: #212529;">
                                                            <thead>
                                                                <tr class="p-3">
                                                                    <th style="padding: 0.75rem;
                                                                    vertical-align: top;
                                                                    border-top: 1px solid #dee2e6;"
                                                                        width="60%" class="p-3">Product Name</th>
                                                                    <th style="padding: 0.75rem;
                                                                    vertical-align: top;
                                                                    border-top: 1px solid #dee2e6;"
                                                                        width="40%" class="p-3">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="sales-cat-wise-items">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row" >
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div class="card-body" style="background-color: teal; color: white;">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div>Purchased Products</div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="float-right">{{ date('d-M-Y') }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div class="p-2" style="overflow:scroll; height:300px;">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="30%">Name</th>
                                                                            <th>Unit Price</th>
                                                                            <th>Qty</th>
                                                                            <th>Total</th>
                                                                            <th>Actions</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="temp-cart-items" class="clickAction">

                                                                    </tbody>

                                                                </table>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <table class="table table-bordered">
                                                            <tbody id="purchse_details_table">
                                                                <tr>
                                                                    <td style="text-align:right; background-color:#1e5a07; color: white; width:70%">
                                                                        Purchased &nbsp; <span id="items" style="color:#FF0000;">0</span> &nbsp; products. Total item count :
                                                                    </td>
                                                                    <td id="quantity" class="text-end" style="background-color: grey; color:white; padding-right:10px;">
                                                                        0
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align:right;background-color:#3366CC;color: white;">
                                                                        SubTotal :
                                                                    </td>
                                                                    <td class="text-end" id="subtotal" style="background-color: grey; color:white;padding-right:10px;">
                                                                        0
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align:right;background-color:#FFA500;color: white;">
                                                                        VAT :
                                                                    </td>
                                                                    <td class="text-end" id="vat" style="background-color: grey; color:white;padding-right:10px;">
                                                                        0
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align:right;background-color:#800080;color: white;">
                                                                        Discount :
                                                                    </td>
                                                                    <td class="text-end" id="discount" style="background-color: grey; color:white;padding-right:10px;">
                                                                        0
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align:right;background-color:#008000;color: white;">
                                                                        Payable :
                                                                    </td>
                                                                    <td class="text-end" id="Payable" style="background-color: grey; color:yellow;padding-right:10px;">
                                                                        0
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <br>
                                                        <h4 style="color: #4B49AC; text-decoration: underline;" class="text-center">Payment Information</h4>
                                                        <table class="table table-bordered">
                                                            <tbody id="add_payment_table">
                                                                <tr>
                                                                    <td style="background-color: grey; color:white;">
                                                                        Payment Type
                                                                    </td>
                                                                    <td style="background-color: #eeeeee; padding-right: 20px;">
                                                                        <select name="payment_method_id"
                                                                            id="payment_type_id" class="form-control text-dark">
                                                                            <option value="1">Cash</option>
                                                                            <option value="2">Bank</option>
                                                                            <option value="3">Others</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr id="type_wise"></tr>
                                                                <tr id="checque_no"></tr>
                                                                <tr>
                                                                    <td style="background-color: grey; color:white;">
                                                                        Paid Amount
                                                                    </td>
                                                                    <td style="background-color: #eeeeee; padding-right: 20px;">
                                                                        <input class="form-control  text-dark" id="paid_amount" name="paid_amount"
                                                                            type="text"
                                                                            placeholder="Paid Amount"/>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="background-color: grey; color:white;">
                                                                        Reference No (If Any)
                                                                    </td>
                                                                    <td style="background-color: #eeeeee; padding-right: 20px;">
                                                                        <input class="form-control  text-dark" name="ref_no"
                                                                            type="text" list="suggesstion-box"
                                                                            id="ref_no"
                                                                            placeholder="Reference No"/>

                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td style="background-color: grey; color:white;">
                                                                        Supplier
                                                                    </td>
                                                                    <td style="background-color: #eeeeee; padding-right: 20px;">
                                                                        <div class="row">
                                                                            <div class="col-md-7 col-lg-7">
                                                                                <select name="supplyer_id"
                                                                                id="supplyer_id" class="form-control  text-dark">
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-5 col-lg-5">
                                                                                <div class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#exampleModal">
                                                                                    <i class="fa fa-plus"></i>
                                                                                </div>
                                                                                <!-- Modal -->
                                                                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog" role="document">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                        <h5 class="modal-title" id="exampleModalLabel">Add Supplyer</h5>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div class="form-group">
                                                                                                <label for="supplier_name">Supplier Name</label>
                                                                                                <input id="supplier_name" type="text" class="form-control my-2" name="supplier_name" placeholder="Enter Supplier Name" value="{{ old('supplier_name') }}">
                                                                                                <span class="text-danger">@error('supplier_name'){{ $message }} @enderror</span>
                                                                                            </div>

                                                                                            <div class="form-group">
                                                                                                <label for="supplier_address">Supplier Address</label>
                                                                                                <input id="supplier_address" type="text" class="form-control my-2" name="supplier_address" placeholder="Enter Supplier Address" value="{{ old('supplier_address') }}">
                                                                                                <span class="text-danger">@error('supplier_address'){{ $message }} @enderror</span>
                                                                                            </div>

                                                                                            <div class="form-group">
                                                                                                <label for="supplier_contact_person">Supplier Contact Person</label>
                                                                                                <input id="supplier_contact_person" type="text" class="form-control my-2" name="supplier_contact_person" placeholder="Supplier Contact Person" value="{{ old('supplier_contact_person') }}">
                                                                                                <span class="text-danger">@error('supplier_contact_person'){{ $message }} @enderror</span>
                                                                                            </div>

                                                                                            <div class="form-group">
                                                                                                <label for="supplier_contact_no">Supplier Contact No</label>
                                                                                                <input id="supplier_contact_no" type="text" class="form-control my-2" name="supplier_contact_no" placeholder="Supplier Contact No" value="{{ old('supplier_contact_no') }}">
                                                                                                <span class="text-danger">@error('supplier_contact_no'){{ $message }} @enderror</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                        <button type="button" class="btn btn-primary" data-dismiss="modal" id="save_supplier">Save changes</button>
                                                                                        </div>
                                                                                    </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="background-color: grey; color:white;">
                                                                        Location
                                                                    </td>
                                                                    <td style="background-color: #eeeeee; padding-right: 20px;">
                                                                        <div class="row">
                                                                            <div class="col-md-7 col-lg-7">
                                                                                <select name="store_id"
                                                                                id="store_id" class="form-control  text-dark">
                                                                            </select>
                                                                            </div>
                                                                            <div class="col-md-5 col-lg-5">
                                                                                <div class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#LocationModal">
                                                                                    <i class="fa fa-plus"></i>
                                                                                </div>
                                                                                <!-- Modal -->
                                                                                <div class="modal fade" id="LocationModal" tabindex="-1" role="dialog" aria-labelledby="LocationModalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                    <h5 class="modal-title" id="LocationModalLabel">Add Location</h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <div class="form-group">
                                                                                            <label for="store_name">Location Name</label>
                                                                                            <input id="store_name" type="text" class="form-control my-2" name="store_name" placeholder="Enter Supplier Name" value="{{ old('store_name') }}">
                                                                                            <span class="text-danger">@error('supplier_name'){{ $message }} @enderror</span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="save_location">Save changes</button>
                                                                                    </div>
                                                                                </div>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="background-color: grey; color:white;">
                                                                        Notes
                                                                    </td>
                                                                    <td style="background-color: #eeeeee; padding-right: 20px;">
                                                                        <textarea class="form-control  text-dark" name="notes" id="notes" cols="30" rows="5"></textarea>
                                                                    </td>
                                                                </tr>

                                                            </tbody>

                                                        </table>
                                                        <div class="row mt-5">
                                                            <div class="col-6"><a
                                                                    href="{{ route('backoffice.delete_purchase_form') }}"
                                                                    class="btn btn-danger">Delete</a></div>
                                                            <div class="col-6 text-right"><p id="complete_purchase"
                                                                    class="btn btn-success">Complete</p></div>
                                                            {{-- <div class="col-6 text-right"><button
                                                                    class="btn btn-success">Complete</button></div> --}}
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.footer')
</body>
</html>
