@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120px">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" style="margin-top: 10px;">
                <div class="card">
                    <div>
                        <div class="row pt-3 px-3">
                            <div class="col-md-6">
                                <div class="mt-2 h5 text-right">SALES INVOICE</div>
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

                        <form action="{{ route('store-sales') }}" method="post"
                            enctype="multipart/form-data">
                            @if (Session::get('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                            @endif

                            @csrf

                            <div class="row">
                                <div class="col-md-7 card p-2">
                                    <div class="">CATEGORIES</div>
                                    <hr>
                                    <div class="row" style="overflow:scroll; height:250px;"
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

                                            <select data-placeholder="Barcode" class="form-control select2-plugin" name="barcode_search" id="barcode_search"></select>

                                    </div>
                                    <div class="row" style="overflow:scroll; height:70%;">
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
                                                            width="40%" class="p-3">Product Name</th>
                                                        <th style="padding: 0.75rem;
                                                        vertical-align: top;
                                                        border-top: 1px solid #dee2e6;"
                                                            width="20%" class="p-3">Location</th>
                                                        <th style="padding: 0.75rem;
                                                        vertical-align: top;
                                                        border-top: 1px solid #dee2e6;"
                                                            width="20%" class="p-3">In Stock</th>
                                                        <th style="padding: 0.75rem;
                                                        vertical-align: top;
                                                        border-top: 1px solid #dee2e6;"
                                                            width="25%" class="p-3" id="type_name">Sales Price</th>
                                                        <th style="padding: 0.75rem;
                                                        vertical-align: top;
                                                        border-top: 1px solid #dee2e6;"
                                                            width="10%" class="p-3">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="sales-cat-wise-items">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div>ORDERS</div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="float-right">{{ date('d-M-Y') }}</div>
                                                        </div>
                                                    </div>
                                                    {{-- <hr>
                                                    <div class="row mt-3">
                                                        <div class="col-3">Barcode</div>
                                                        <div class="col-9">
                                                            <select data-placeholder="Barcode" class="form-control select2-plugin" name="barcode" id="barcode"></select>
                                                        </div>
                                                    </div> --}}


                                                    <div class="row mt-3">
                                                        <div class="col-3">Sales Type</div>
                                                        <div class="col-9">
                                                            <select class="form-control" name="sales_type"
                                                                type="text" id="sales_type">
                                                                {{-- <!--<option value="1" selected>Retail</option>--> --}}
                                                                <option value="2">Delivery</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <p class="pt-3 pl-3">SOLD ITEMS</p>
                                                <div class="p-2" style="overflow:scroll; height:300px;">
                                                    <table>
                                                        <thead>
                                                            <tr class="py-3">
                                                                <th class="p-3" width="40%">Product</th>
                                                                <th class="p-3" width="10%">Price
                                                                </th>
                                                                <th class="p-3" width="30%">Qty</th>
                                                                <th class="p-3" width="10%">Total
                                                                </th>
                                                                <th class="p-3" width="10%"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="temp-cart-items" class="clickAction">

                                                        </tbody>

                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <p class="pt-3 pl-2">TRANSACTION DETAILS</p>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>
                                                                Quantity of <span id="no_of_items"></span>
                                                                Items
                                                            </td>
                                                            <td id="total_quantity">
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <p class="card-text">Subtotal</p>
                                                            </td>
                                                            <td id="subtotal" class="text-right pr-2">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p class="card-text">Vat</p>
                                                            </td>
                                                            <td id="vat" class="text-right pr-2">

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Discount
                                                            </td>
                                                            <td id="discount" class="text-right pr-2">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Payable</td>
                                                            <td id="total" class="text-right pr-2"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Paid Amount
                                                            </td>
                                                            <td id="paid" class="text-right pr-2"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Due Amount
                                                            </td>
                                                            <td id="due" class="text-right pr-2"></td>
                                                        </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row py-3" id="hide_suspense">
                                        <div class="col-12">
                                            <div class="btn btn-warning float-right p-2" id="add_suspense">
                                                Suspend
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row mt-3">
                                                <div class="col-6">Select Delivery Man<span style="color: red;">*</span></div>
                                                <div class="col-6">
                                                    <select class="form-control" name="delivery_man"
                                                        type="text" id="delivery_man" required>
                                                        <option value='' selected disabled>- Select Delivery Man -</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- <!--<table class="table table-bordered">-->
                                            <!--    <thead>-->
                                                    <!--<tr>-->
                                                    <!--    <td>-->
                                                    <!--        Customer Mobile No-->
                                                    <!--    </td>-->
                                                    <!--    <td>-->
                                                    <!--        <input -->
                                                    <!--            class="form-control" -->
                                                    <!--            name="mobile_no"-->
                                                    <!--            type="text"-->
                                                    <!--            placeholder="Customer Mobile No" required -->
                                                    <!--        />-->
                                                    <!--    </td>-->
                                                    <!--</tr>-->
                                            <!--    </thead>-->
                                            <!--    <tbody id="add_payment_table">-->
                                            <!--        <tr>-->
                                            <!--            <td>-->
                                            <!--                Payment Type-->
                                            <!--            </td>-->
                                            <!--            <td>-->
                                            <!--                <select name="payment_method_id"-->
                                            <!--                    id="payment_type_id" class="form-control">-->
                                            <!--                    <option value="1">Cash</option>-->
                                            <!--                    <option value="2">Bank</option>-->
                                            <!--                    <option value="3">Others</option>-->
                                            <!--                </select>-->
                                            <!--            </td>-->
                                            <!--        </tr>-->
                                            <!--        <tr id="type_wise"></tr>-->
                                            <!--        <tr id="checque_no"></tr>-->
                                            <!--        <tr>-->
                                            <!--            <td>-->
                                            <!--                Discount-->
                                            <!--            </td>-->
                                            <!--            <td>-->
                                            <!--                <input class="form-control" type="text"-->
                                            <!--                    id="disc" name="discount"-->
                                            <!--                    min="1">-->
                                            <!--            </td>-->
                                            <!--        </tr>-->
                                            <!--        <tr>-->
                                            <!--            <td>-->
                                            <!--                Paid Amount-->
                                            <!--            </td>-->
                                            <!--            <td>-->
                                            <!--                <input class="form-control" type="text"-->
                                            <!--                    id="paid_amount" name="paid_amount"-->
                                            <!--                    min="1">-->
                                            <!--            </td>-->
                                            <!--        </tr>-->
                                            <!--        <tr>-->
                                            <!--            <td>-->

                                            <!--            </td>-->
                                            <!--            <td class="text-right" id="sales_payment_add_button">-->
                                            <!--                <div class="btn btn-primary" id="add_payment">Add-->
                                            <!--                    Payment</div>-->
                                            <!--            </td>-->
                                            <!--        </tr>-->

                                            <!--    </tbody>-->

                                            <!--</table>-->

                                            <!--<table class="table table-bordered">-->
                                            <!--    <thead>-->
                                            <!--        <tr>-->
                                            <!--            <th></th>-->
                                            <!--            <th>Type</th>-->
                                            <!--            <th>Payable</th>-->
                                            <!--            <th>Paid</th>-->
                                            <!--            <th>Due</th>-->
                                            <!--            <th>Change</th>-->
                                            <!--        </tr>-->
                                            <!--    </thead>-->
                                            <!--    <tbody id="temp_payment">-->

                                            <!--    </tbody>-->
                                            <!--</table>--> --}}

                                            <div class="row mt-5">
                                                <div class="col-6"><a
                                                        href="{{ route('delete_sales_form') }}"
                                                        class="btn btn-danger">Delete</a></div>
                                                <div class="col-6 text-right"><button
                                                        class="btn btn-success">Complete</button></div>
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
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>


<!--update bar code ajax  09/03/24-->

<script type="text/javascript">
$(document).ready(function() {
    $('.select2-plugin').select2();

    $.ajax({
        url: "get_all_barcode",
        method: "GET",
        dataType: "json",
        success: function(barcodes) {
            // console.log('hello');
            // console.log(barcodes)
            // console.log('hello');
            // Assuming you have an input field with the id 'categoryInput'
            $("#barcode_search").empty();
            $("#barcode").empty();
            var stdhtml = "<option disabled selected> Barcode </option>";
            $.each(barcodes, function(key, value) {
                stdhtml += '<option value="' + value.barcode + '">' + value.barcode + '</option>';
            });
            $("#barcode").append(stdhtml);
            $("#barcode_search").append(stdhtml);
        },
        error: function(error) {
            console.log(error)
            console.error('Error fetching categories', error);
        }
    });
})
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('body').addClass('sidebar-icon-only');

    window.TempTransactionHelper = function(data) {
        $('#discount').empty();
        $('#total').empty();
        $('#paid').empty();
        $('#due').empty();
        $('#vat').empty();

        $('#discount').append(parseFloat(data.TempPaymentdata.discount_amount).toFixed(2));
        $('#total').append(parseFloat(data.TempPaymentdata.total_payable).toFixed(2));
        $('#paid').append(parseFloat(data.TempPaymentdata.paid_amount).toFixed(2));
        $('#due').append(parseFloat(data.TempPaymentdata.due_amount).toFixed(2));
        $('#vat').append(parseFloat(data.TempPaymentdata.vat).toFixed(2));
    }

    window.TempPaymentHtmlHelper = function(data) {

        $('#sales_payment_add_button').empty();
        var temp_payment_html = '<tr>'
        temp_payment_html += '<td>'
        temp_payment_html += '<a cart_temporary_payment_id="' + data.TempPaymentdata
            .cart_temporary_payment_id +
            '" id="delete_temp_payment"><i class="fa fa-trash" aria-hidden="true"></i><a>'
        temp_payment_html += '</td>'
        temp_payment_html += '<td>' + data.TempPaymentdata.payment_method_id + '</td>'
        temp_payment_html += '<td>' + data.TempPaymentdata.total_payable + '</td>'
        temp_payment_html += '<td>' + data.TempPaymentdata.paid_amount + '</td>'
        temp_payment_html += '<td>' + data.TempPaymentdata.due_amount + '</td>'
        if(data.TempPaymentdata.change_amount<0){
            temp_payment_html += '<td>0</td>'
        }
        else{
            temp_payment_html += '<td>' + data.TempPaymentdata.change_amount + '</td>'
        }
        temp_payment_html += '</tr>'

        $('#temp_payment').append(temp_payment_html);
    }

    window.ItemDataHelper = function(data) {

        var temp_cart_items_html = "";

        if (data.status == true) {
            var i = 1;
            $('#temp-cart-items').empty();
            $.each(data.cart_temporary_data, function(col, temp_cart_item) {
                var product_image = temp_cart_item.product_image.split(",")[0];
                temp_cart_items_html += "<tr class='py-3' value='" + temp_cart_item
                    .temp_cart_item_id + "'>"
                temp_cart_items_html +=
                    "<td class='p-3' width='40%'><input i='" + i++ +
                    "' id='temp_cart_id' name='temp_cart_id' type='hidden' value='" +
                    temp_cart_item
                    .temp_cart_id + "'/>"
                temp_cart_items_html += temp_cart_item.product_name
                temp_cart_items_html += "</td>"
                    if(data.sales_type == 1){
                        temp_cart_items_html +="<td class='p-3' width='10%'><a id='sales_sales_price'>"+temp_cart_item.sales_price+"</a></td>"
                        temp_cart_items_html += "<td class='p-3' width='30%' class='text-right'>"
                        temp_cart_items_html += "<input class='form-control text-right'sales_sales_price='" +
                            temp_cart_item.sales_price + "' temp_cart_item_id='" + temp_cart_item.temp_cart_item_id + "' data='sales_quantity" + i + "' value='" +
                            temp_cart_item.quantity +
                            "' type='text' id='sales_quantity' name='quantity' min='1'>"
                        temp_cart_items_html += "</td>"
                    }else if(data.sales_type == 2){
                        temp_cart_items_html +="<td class='p-3' width='10%'><a id='sales_sales_price'>"+temp_cart_item.wholesale_price+"</a></td>"
                        temp_cart_items_html += "<td class='p-3' width='30%'>"
                        temp_cart_items_html += "<input required type='number' step='0.01' class='form-control' " +
                                                    "sales_sales_price='" + temp_cart_item.wholesale_price + "' " +
                                                    "temp_cart_item_id='" + temp_cart_item.temp_cart_item_id + "' " +
                                                    "data='sales_quantity" + i + "' " +
                                                    "value='" + temp_cart_item.quantity + "' " +
                                                    "id='sales_quantity' name='quantity' min='0' " +
                                                    "max='" + temp_cart_item.temp_quantity + "'>"

                        temp_cart_items_html += "</td>"
                    }

                temp_cart_items_html += "<td class='p-3' width='10%'><a id='sales_quantity" + i + "' value='" + temp_cart_item.sales_price + "'>" +
                                        parseFloat(temp_cart_item.temp_net_amount).toFixed(2) + "</a></td>"
                temp_cart_items_html += "<td width='10%'>"
                temp_cart_items_html += "<a value='" + temp_cart_item
                    .temp_cart_item_id +
                    "' id='delete_tempcart'><i class='fa fa-trash' aria-hidden='true' style='color:red'></i><a/>"
                temp_cart_items_html += "</td>"
                temp_cart_items_html += "</tr>"
            });

            $('#no_of_items').empty();
            $('#total_quantity').empty();
            $('#subtotal').empty();
            $('#discount').empty();
            $('#total').empty();
            $('#paid').empty();
            $('#due').empty();
            $('#vat').empty();

        }

        return temp_cart_items_html;
    }

    window.ItemTransactionHelper = function(data) {

        $('#no_of_items').empty();
        $('#total_quantity').empty();
        $('#subtotal').empty();
        $('#discount').empty();
        $('#total').empty();
        $('#paid').empty();
        $('#due').empty();
        $('#vat').empty();

        $('#no_of_items').append(data.transaction_data.items);
        $('#total_quantity').append(parseFloat(data.transaction_data.quantity).toFixed(2));
        $('#subtotal').append(parseFloat(data.transaction_data.subtotal).toFixed(2));
        $('#discount').append(parseFloat(data.transaction_data.discount_amount).toFixed(2));
        $('#total').append(parseFloat(data.transaction_data.total_payable).toFixed(2));
        $('#paid').append(parseFloat(data.transaction_data.paid_amount).toFixed(2));
        $('#due').append(parseFloat(data.transaction_data.due_amount).toFixed(2));
        $('#vat').append(parseFloat(data.transaction_data.vat).toFixed(2));
        // $('#paid_amount').attr("value", data.transaction_data.due_amount);
        $('#paid_amount').attr("value", 0);
        $('#paid_amount').attr("temp_cart_id",data.transaction_data.temp_cart_id);
        // $('#disc').val(parseFloat(data.transaction_data.total_discount).toFixed(2));

        // return console.log(data.transaction_data);
    }

    //-------- Fetch All Suspended Items ---------
    window.GetSuspenseDataHelper = function() {
        $.ajax({
            url: "get-suspended-items",
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data) {
                $("#suspended_items").empty();
                $("#suspended_items").append(
                    "<option selected disabled>SUSPENDED ITEMS</option>"
                );
                $.each(data.suspend_data, function(col, items) {
                    var suspended_items_html =
                        "<option value='" + items
                        .temp_cart_id +
                        "'>" + items.temp_cart_id +
                        "</option/>";
                    $("#suspended_items").append(
                        suspended_items_html);
                });
            }
        });
    }
    GetSuspenseDataHelper();

    //-------- Fetch All categery with Ajax---------
    $.ajax({
        url: '{{ route('get-ajax-category') }}',
        type: "GET",
        data: {
            "_token": "{{ csrf_token() }}"
        },
        dataType: "json",
        success: function(data) {
            $.each(data, function(col, category) {
                var catImage = category.sample_image;
                var category_html = '<div class="col-3 col-lg-3 col-md-3 mb-1">'
                category_html += '<a value="' + category.category_id +
                    '" id="sales-category" class="btn">'
                // category_html +=
                //     '<img height="70px" width="75px" src="{{ asset('backend/images/CategoryWise/') }}' +
                //     '/' + catImage + '" alt="' + catImage + '">'
                category_html +=
                '<img height="70px" width="75px" src="{{ asset('backend/images/CategoryWise/') }}' +
                '/' + catImage + '" >'
                category_html += '<div>'
                category_html += '<div>' + category.category_name + '</div>'
                category_html += '</a></div></div>'


                $('#all-category').append(category_html);
            });



        }
    });

    //-------- Fetch All delivery man with Ajax---------
    $.ajax({
        url: '{{ route('get-ajax-deliveryman') }}',
        type: "GET",
        data: {
            "_token": "{{ csrf_token() }}"
        },
        dataType: "json",
        success: function(data) {
            $.each(data, function(col,sr) {
                var delivery_html = "<option value='"+sr.login_id+"'>"+sr.full_name+"</option>";
                $('#delivery_man').append(delivery_html);
            });



        }
    });

    //-------- Fetch Temp Cart Data On Reload---------
    var SESSION = {
        "LoggedUser": "<?php echo session()->get('LoggedUser'); ?>",
    };

    var login_id = SESSION.LoggedUser;
    var st=$("#sales_type").val();
    $.ajax({
        url: "get_sales_temp_cart_data/" + login_id +"/"+st,
        type: "GET",
        data: {
            "_token": "{{ csrf_token() }}"
        },
        dataType: "json",
        success: function(data) {
            $('#temp-cart-items').append(ItemDataHelper(data));
            ItemTransactionHelper(data);
            if (data.IsPaymentExists) {
                TempPaymentHtmlHelper(data);
                TempTransactionHelper(data);
            }

        }
    });
    //--------End Fetch Temp Cart Data On Reload---------

    //--------Fetch Sub Category on category selection ----------
    $(document).on('click', '#sales-category', function(e) {
        var category_id = $(this).attr('value');
        $('#sales-cat-wise-items').empty();
        $('#all-sub-category').empty();
        $.ajax({
            url: 'sales-sub-category/'+category_id,
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data) {
                $.each(data, function(col, category) {
                    var catImage = category.sc_one_image;
                    var category_html = '<div class="col-3 col-lg-3 col-md-3 mb-1">'
                    category_html += '<a value="' + category.sc_one_id +
                        '" id="get-sales-subcategory" class="btn">'
                    // category_html +=
                    //     '<img height="70px" width="75px" src="{{ asset('backend/images/CategoryWise/') }}' +
                    //     '/' + catImage + '" alt="' + catImage + '">'
                    category_html += '<div>'
                    category_html += '<div>' + category.sc_one_name + '</div>'
                    category_html += '</a></div></div>'
                    $('#all-sub-category').append(category_html);
                });
            }
        });
    });

    //--------Fetch Items with Sub Category selection ----------
    $(document).on('click', '#get-sales-subcategory', function(e) {
        var sc_one_id = $(this).attr('value');
        var sales_type = $("#sales_type").val();
        $('#sales-cat-wise-items').empty();
        $.ajax({
            url: "sales-cat-wise-items/" + sc_one_id,
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data) {
                $.each(data, function(col, categoryWiseItem) {
                    var product_html = "<tr class='p-3'>"
                    product_html += "<td width='40%' class='p-3'>"
                    product_html += categoryWiseItem.product_name
                    product_html += "</td>"
                    product_html += "<td width='20%' class='p-3'>"
                    product_html += categoryWiseItem.store_name
                    product_html += "</td>"
                    product_html += "<td width='20%' class='p-3'>"
                    product_html += categoryWiseItem.final_quantity
                    product_html += "</td>"
                    if(sales_type == 1){
                        product_html += "<td width='25%' class='p-3'>"
                        product_html += categoryWiseItem.sales_price
                        product_html += "</td>"
                    }else if(sales_type == 2){
                        product_html += "<td width='25%' class='p-3'>"
                        product_html += categoryWiseItem.wholesale_price
                        product_html += "</td>"
                    }
                    product_html += "<td width='10%' class='p-3'>"
                    product_html += "<a product_id='"+categoryWiseItem.product_id+"' stock_id='"+categoryWiseItem.stock_id+"' id='sales-product-item' value='" +
                        categoryWiseItem.purchase_details_id +
                        "' class='btn btn-success'>add</a>"
                    product_html += "</td>"
                    product_html += "</tr>"

                    $('#sales-cat-wise-items').append(product_html);
                });
            }
        });

    });

    //-------- barcode search------------
    $(document).on('change', '#barcode_search', function(e) {
        var barcode = $(this).val();
        // console.log(barcode);
        var sales_type = $("#sales_type").val();
        $('#sales-cat-wise-items').empty();
        $.ajax({
            url: "sales-barcode-wise-items/" + barcode,
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data) {
                // console.log(data);
                $.each(data, function(col, categoryWiseItem) {
                    var product_html = "<tr class='p-3'>"
                    product_html += "<td width='40%' class='p-3'>"
                    product_html += categoryWiseItem.product_name
                    product_html += "</td>"
                    product_html += "<td width='20%' class='p-3'>"
                    product_html += categoryWiseItem.store_name
                    product_html += "</td>"
                    product_html += "<td width='20%' class='p-3'>"
                    product_html += categoryWiseItem.final_quantity
                    product_html += "</td>"
                    if(sales_type == 1){
                        product_html += "<td width='25%' class='p-3'>"
                        product_html += categoryWiseItem.sales_price
                        product_html += "</td>"
                    }else if(sales_type == 2){
                        product_html += "<td width='25%' class='p-3'>"
                        product_html += categoryWiseItem.wholesale_price
                        product_html += "</td>"
                    }
                    product_html += "<td width='10%' class='p-3'>"
                    product_html += "<a product_id='"+categoryWiseItem.product_id+"' stock_id='"+categoryWiseItem.stock_id+"' id='sales-product-item' value='" +
                        categoryWiseItem.purchase_details_id +
                        "' class='btn btn-success'>add</a>"
                    product_html += "</td>"
                    product_html += "</tr>"

                    $('#sales-cat-wise-items').append(product_html);
                });
            }
        });

    });

    //-------- Fetch Sub Categery with Category Id---------
    $(document).on('click', '#sales-subcat', function(e) {
        var sc_one_id = $(this).attr('value');
        // console.log(sc_one_id);
        $('#sales-cat-wise-items').empty();
        $.ajax({
            url: "sales-cat-wise-items/" + sc_one_id,
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data) {
                $.each(data, function(col, categoryWiseItem) {

                    var product_html = "<tr class='p-3'>"
                    product_html += "<td width='50%' class='p-3'>"
                    product_html += categoryWiseItem.product_name
                    product_html += "</td>"
                    product_html += "<td class='p-3'>"
                    product_html += categoryWiseItem.sales_price
                    product_html += "</td>"
                    product_html += "<td class='p-3'>"
                    product_html += "<a id='sales-product-item' value='" +
                        categoryWiseItem.product_id +
                        "' class='btn btn-success'>add</a>"
                    product_html += "</td>"
                    product_html += "</tr>"

                    $('#sales-cat-wise-items').append(product_html);
                });
            }
        });

    });

    //-------- Add Product To Temp Cart---------
    $(document).on('click', '#sales-product-item', function(e) {

        var purchase_details_id = $(this).attr('value');
        var stock_id = $(this).attr('stock_id');
        var product_id = $(this).attr('product_id');
        var temp_cart_id = $("#temp_cart_id").val();
        var sales_type = $("#sales_type").val();
        var msg;

        console.log(purchase_details_id, stock_id, product_id, temp_cart_id, sales_type);

        if (temp_cart_id) {
            msg = temp_cart_id;
        } else {
            msg = false;
        }
        $('#add-sales-items-to-temp').empty();
        $.ajax({
            url:'{{ route('add-sales-items-to-temp')}}',
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "purchase_details_id": purchase_details_id,
                "stock_id": stock_id,
                "temp_cart_id": temp_cart_id,
                "sales_type": sales_type,
                "product_id": product_id,
                "msg": msg
            },
            dataType: "json",
            success: function(data) {

                if(data.stock_error == true){
                    swal(data.message,data.in_stock+' Products Available','error');
                    return ;
                }

                $('#temp-cart-items').append(ItemDataHelper(data));
                ItemTransactionHelper(data);
            }
        });

    });

    //-------- Adjust Price On Sales Type Change---------
    $(document).on('change', '#sales_type', function(e) {
        e.preventDefault();
        var sales_type_id = $(this).val();
        var temp_cart_id = $("#temp_cart_id").val();
        $('#sales-cat-wise-items').empty();
        var msg;
        if (temp_cart_id) {
            msg = temp_cart_id;
        } else {
            msg = false;
        }

        if (sales_type_id == 2 ) {
            $("#type_name").empty();
            $("#type_name").append("Wholesale Price");
        } else {
            $("#type_name").empty();
            $("#type_name").append("Sales Price");
        }

        $.ajax({
            url: "sales-type-wise-price/" + sales_type_id+'/'+msg,
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data) {
                $('#temp-cart-items').append(ItemDataHelper(data));
                ItemTransactionHelper(data);
            }
        });
    });

    //-------- Adjust Price On Sales Quantity Change---------
    $(".clickAction").on('change', '#sales_quantity', function(e) {
        var data_id = "";
        var sales_price = ""
        var sales_quantity = $(this).val();

        var sales_price = $(this).attr('sales_sales_price');
        var temp_cart_item_id = $(this).attr('temp_cart_item_id');
        var data_id = $(this).attr('data');
        var sales_type = $("#sales_type").val();
        $("#" + data_id).empty()
        if(sales_quantity<=0){
            swal("Qnt Should Be Grater Then Zero","Fail","error");
            $('#no_of_items').empty();
            $('#total_quantity').empty();
            $('#subtotal').empty();
            $('#discount').empty();
            $('#total').empty();
            $('#paid').empty();
            $('#due').empty();
            $('#vat').empty();
            $('#paid_amount').attr("value", 0);
            // $('#disc').attr("value", 0);
            return ;
        }
       else
       { $.ajax({
            url: "price_calculation/" + temp_cart_item_id + "/" + sales_quantity + "/" +
                sales_price +"/"+sales_type,
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data) {
                var new_sales = data.cart_temporary_item.temp_net_amount;
                $("#" + data_id).append(new_sales);
                ItemTransactionHelper(data);
            }
        });}

    });

    // //-------- change paid amount on discount change ---------
    // $(document).on('blur', '#disc', function(e) {
    //     var paid_amount = $('#paid_amount').val();
    //     var discount = $(this).val();
    //     var subtotal = $('#subtotal').text();
    //     var vat = $('#vat').text();
    //     if(discount<0){
    //         swal("Discount Should Be Positive","Validation Error","error");
    //         $("#disc").attr('value', 0).focus();
    //         return ;
    //     }
    //     else if(discount>(parseInt(subtotal)+parseInt(vat)))
    //     {
    //         swal("Discount Amount Can Not Exceed The Payable Amount","Validation Error","error");
    //         $("#disc").attr('value', 0).focus();
    //         return ;
    //     }

    //     else if(/%$/.test(discount)){
    //       var getDiscountValue = parseFloat(discount)/100;   //input value  value =  0.1/100 = 0.1

    //         var dis = parseInt(subtotal)*getDiscountValue;
    //         // $('#paid_amount').attr("value", parseInt(subtotal)+parseInt(vat)-dis);
    //         $('#paid_amount').attr("value", 0);
    //     }
    //     else{
    //         // $('#paid_amount').attr("value", parseInt(subtotal)+parseInt(vat)-discount);
    //         $('#paid_amount').attr("value", 0);
    //     }


    // });

    //-------- Delete Temp Cart ---------
    $(".clickAction").on('click', '#delete_tempcart', function(e) {
        e.preventDefault();
        var temp_cart_item_id = $(this).attr('value');
        var sales_type = $("#sales_type").val();
        $.ajax({
            url: "delete_sales_temp_cart_item/" + temp_cart_item_id+"/"+sales_type,
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data) {
                if (data.transaction_data === null) {
                    location.reload();
                }
                else
                {
                    $('#temp-cart-items').append(ItemDataHelper(data));
                    ItemTransactionHelper(data);
                }
            }
        });
    });

    //-------- Create Temp Payment ---------
    $(document).on('click', '#add_payment', function(e) {

        e.preventDefault();
        var paid_amount = $('#paid_amount').val();
        // var discount = $('#disc').val();
        var subtotal = $('#subtotal').text();
        // if(/%$/.test(discount)){
        //     var getDiscountValue = parseFloat(discount)/100;   //input value  value =  0.1/100 = 0.1
        //     var dis = parseInt(subtotal)*getDiscountValue;
        //     discount = dis;
        // }
        var vat = $('#vat').text();


        // if(!discount){
        //     discount=0;
        // }
        // //check negative value
        // else if(discount<0){
        //     swal("Discount Should Be Positive","Fail","error");
        //     $("#disc").attr('value', 0).focus();
        //     return ;
        // }
        // else if(discount>(parseInt(subtotal)+parseInt(vat)))
        // {
        //     swal("Discount Amount Can Not Exceed The Payable Amount","Validation Error","error");
        //     $("#disc").attr('value', 0).focus();
        //     return ;
        // }

        if(paid_amount<0){
            swal("Paid Amount Should Be Positive","Validation Error","error");
            $("#paid_amount").attr('value', 0).focus();
            return ;
        }
        var payment_type_id = $('#payment_type_id').val();
        var bank_name = $('#bank_name').val();
        var cheque_no = $('#cheque_no').val();
        var transaction_no = $('#transaction_no').val();
        if(payment_type_id == 2){
            if(!bank_name){
                swal('Bank name field is Required !!','Validation Error','error');
                $("#bank_name").attr('value', '').focus();
                return ;
            }
            if(!cheque_no){
                swal('Cheque No field is Required !!','Validation Error','error');
                $("#cheque_no").attr('value', '').focus();
                return ;
            }
        }else if(payment_type_id == 3){
            if(!transaction_no){
                swal('Transaction No field is Required !!','Validation Error','error');
                $("#transaction_no").attr('value', '').focus();
                return ;
            }
        }
        var temp_cart_id = $("#paid_amount").attr("temp_cart_id");
        var sales_type = $("#sales_type").val();

        $.ajax({
            url: '{{ route('store-sales-temp-payment') }}',
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "paid_amount": paid_amount,
                "discount": discount,
                "payment_type_id": payment_type_id,
                "temp_cart_id": temp_cart_id,
                "sales_type": sales_type
            },
            dataType: "json",
            success: function(data) {
                TempPaymentHtmlHelper(data);
                TempTransactionHelper(data);
            }
        });
    });

    //-------- Suspend a cart ---------
    $(document).on('click', '#add_suspense', function(e) {
        e.preventDefault();

        var temp_cart_id = $("#temp_cart_id").val();
        var waiter_id = 1;
        var sales_type = $("#sales_type").val();
        $.ajax({
            url: "add_suspense/" + temp_cart_id + '/' + waiter_id + '/' + sales_type,
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data) {

                GetSuspenseDataHelper();

                $('#temp-cart-items').empty();
                $('#no_of_items').empty();
                $('#total_quantity').empty();
                $('#subtotal').empty();
                $('#discount').empty();
                $('#total').empty();
                $('#paid').empty();
                $('#due').empty();
                $('#vat').empty();
                $('#paid_amount').attr("value", 0);
                // $('#disc').attr("value", 0);
                $("#table_no").attr('value', "");
                $("#barcode").attr('value', null).focus();
            }
        });
    });

    //-------- Fetch Suspended Item Wise Data ---------
    $(document).on('change', '#suspended_items', function(e) {

        var cart_item_id = $(this).val();
        $("#table_no").attr('value', "");
        $.ajax({
            url: "get_suspended_data/" + cart_item_id,
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data) {
                // console.log(data);
                GetSuspenseDataHelper();
                $('#temp-cart-items').append(ItemDataHelper(data));
                ItemTransactionHelper(data);
            }
        });

    });

    //-------- Insert Data To temp Cart With barcode------------
    $(document).on('change', '#barcode', function(e) {
        e.preventDefault();
        var barcode = $(this).val();

        var temp_cart_id = $("#temp_cart_id").val();
        var sales_type = $("#sales_type").val();
        var msg;
        if (temp_cart_id) {
            msg = temp_cart_id;
        } else {
            msg = false;
        }
        $('#add-sales-items-to-temp').empty();
        $.ajax({
            url: "add-sales-items-with-barcode/" + barcode + '/' + msg+"/"+sales_type,
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data) {
                if(data.barcode_error){
                    swal(data.message,"Error","error");
                    retun;
                }
                $('#temp-cart-items').append(ItemDataHelper(data));
            }
        });
    });

    //-------- Delete temporary payment------------
    $(document).on('click', '#delete_temp_payment', function(e) {
        e.preventDefault();
        var cart_temporary_payment_id = $(this).attr("cart_temporary_payment_id");

        $.ajax({
            url: "delete_temporary_payment/" + cart_temporary_payment_id,
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data) {
                if (data.deleted) {
                    var add_payment_button =
                        '<div class="btn btn-primary" id="add_payment">Add Payment</div>'
                    $('#sales_payment_add_button').append(add_payment_button);
                    $('#temp_payment').empty();

                    TempTransactionHelper(data);
                }

            }
        });
    });

    //-------- Payment Type change function ------------
    $("#payment_type_id").on("change",function(){
        $("#type_wise").empty();
        $("#checque_no").empty();
        var mode_type = $(this).val();
        var mfd="";
        var mfc="";
        if(mode_type == 2){
                    mfd+='<td>Bank Name:</td>'
                    mfd+='<td>'
                    mfd+='<input placeholder="Bank Name" type="text" id="bank_name" class="form-control mt-2" name="bank_name" />'
                    mfd+='</td>'

                    mfc+='<td>Checque No</td>'
                    mfc+='<td>'
                    mfc+='<input placeholder="Checque No" type="text" id="cheque_no" class="form-control mt-2" name="cheque_no"/>'
                    mfc+='</td>'
                $("#type_wise").append(mfd);
                $("#checque_no").append(mfc);
        }else if(mode_type == 3){
                    mfd+='<td>Transaction No</td>'
                    mfd+='<td>'
                    mfd+='<input placeholder="Transaction No" type="text" id="transaction_no" class="form-control mt-2" name="transaction_no"/>'
                    mfd+='</td>'

                $("#type_wise").append(mfd);
        }
    });

});

function test() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>
@include('admin.footer')
