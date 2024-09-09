@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')

<div class="main-panels" style="padding-top: 120px">
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1" style="margin-top: 45px; ">
                <div class="card">
                    <div class="card-title">
                        <h4 class="p-3 text-center">Create New Return</h4>
                        <hr>
                    </div>
                    <div class="card-body">
                        <!--<form>-->
                        <form id="refundForm" action="{{ route('store-return') }}" method="post">
                        @if (Session::get('success'))
                             <div class="alert alert-success">
                                 {{ Session::get('success') }}
                             </div>
                        @endif
                        @if (Session::get('fail'))
                        <div class="alert alert-danger">
                            {{ Session::get('fail') }}
                        </div>
                        @endif
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Select Delivery Man
                                        <select class="form-control" id="select_consumer_id" name="consumer_id">
                                            <option>------Select------</option>
                                            @foreach($ConsumerLogin as $data)
                                                <option value="{{$data->login_id}}">{{$data->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <span class="text-danger">@error('consumer_id'){{ $message }} @enderror</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Select Invoice
                                        <select class="form-control" id="select_cart_id" name="cart_id"></select>
                                    </label>
                                    <div data-toggle="modal" data-target="#cartModal" id="cart_view_btn" class="btn btn-primary float-right pt-1">ইনভয়েস দেখুন</div>
                                    <span class="text-danger">@error('cart_id'){{ $message }} @enderror</span>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <p class="pt-3 pl-3">Invoiced Items</p>
                                    <div class="p-2" style="overflow:scroll; height:300px;">
                                        <table>
                                            <thead>
                                                <tr class="py-3">
                                                    <th class="p-3" width="40%">Product</th>
                                                    <th class="p-3" width="10%">Rate</th>
                                                    <th class="p-3" width="10%">Qty</th>
                                                    <th class="p-3" width="10%">Total</th>
                                                    <th class="p-3 text-end" width="30%">Return</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cart_items" class="clickAction">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-2">
                                <div class="form-group d-flex justify-content-between">
                                    <div data-toggle="modal" data-target="#damageReturn" id="damage_return_form" class="btn btn-primary float-right pt-1">নষ্ট পণ্য ফেরত </div>
                                    <div data-toggle="modal" data-target="#consumerDueForm" id="conumer_due_form" class="btn btn-primary float-right pt-1">ক্রেতার বকেয়া এন্ট্রি</div>
                                    <div data-toggle="modal" data-target="#deliveryManDueForm" id="delivery_man_due_form" class="btn btn-primary float-right pt-1">সরবরাহকারীর বকেয়া</div>
                                    <div id="calculate_return_btn" class="btn btn-primary float-right">ক্যালকুলেট রিটার্ণ</div>
                                </div>
                            </div>
                        </div>

                        <!--form - bottom - part-->
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table-bordered">
                                    <tr>
                                        <th colspan="2">ইনভয়েসের তথ্য</th>
                                    </tr>
                                    <tr id="original_invoice_row" style="display:none;">
                                        <td>original Invoice Amount</td>
                                        <td class="text-end p-2" id="original_invoice_amount"></td>
                                    </tr>
                                    <tr>
                                        <td>Total Quantity</td>
                                        <td class="text-end p-2" id="cart_invoice_qunatity"></td>
                                        <input type="hidden" id="cart_invoice_qunatity_input" name="cart_invoice_qunatity_input" value="0">
                                    </tr>
                                    <tr>
                                        <td>Total Amount</td>
                                        <td class="text-end p-2" id="cart_invoice_amount"></td>
                                        <input type="hidden" id="cart_invoice_amount_input" name="cart_invoice_amount_input" value="0">
                                    </tr>
                                    <tr>
                                        <td>Paid Amount</td>
                                        <td class="text-end p-2" id="cart_invoice_paid"></td>
                                        <input type="hidden" id="cart_invoice_paid_input" name="cart_invoice_paid_input" value="0">
                                    </tr>
                                    <tr>
                                        <td>Due Amount</td>
                                        <td class="text-end p-2" id="cart_invoice_due"></td>
                                        <input type="hidden" id="cart_invoice_due_input" name="cart_invoice_due_input" value="0">
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table-bordered">
                                    <tr>
                                        <th colspan="2">ইনভয়েসের পণ্য ফেরত</th>
                                    </tr>
                                    <tr>
                                        <td>Total Quantity</td>
                                        <td class="text-end p-2" id="returnCount"></td>
                                        <input type="hidden" id="returnCountInput" name="returnCountInput" value="0">
                                    </tr>
                                    <tr>
                                        <td>Total Amount (-)</td>
                                        <td class="text-end p-2" id="returnAmount"></td>
                                        <input type="hidden" id="returnAmountInput" name="returnAmountInput" value="0">
                                    </tr>
                                </table>
                                <table class="table-bordered mt-2">
                                    <tr>
                                        <th colspan="2">ক্রেতার বকেয়া</th>
                                    </tr>
                                    <tr>
                                        <td>Total Due (-)</td>
                                        <td class="text-end p-2" id="customerTotalDue"></td>
                                        <input type="hidden" id="customerTotalDueInput" name="customerTotalDueInput" value="0">
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table-bordered">
                                    <tr>
                                        <th colspan="2">নষ্ট পণ্য ফেরত</th>
                                    </tr>
                                    <tr>
                                        <td>Total Quantity</td>
                                        <td class="text-end p-2" id="totalReturnedDamagedQuantity"></td>
                                        <input type="hidden" id="totalReturnedDamagedQuantityInput" name="totalReturnedDamagedQuantityInput" value="0">
                                    </tr>
                                    <tr>
                                        <td>Total Amount (-)</td>
                                        <td class="text-end p-2" id="totalReturnedDamagedAmount"></td>
                                        <input type="hidden" id="totalReturnedDamagedAmountInput" name="totalReturnedDamagedAmountInput" value="0">
                                    </tr>
                                </table>
                                <table class="table-bordered mt-2">
                                    <tr>
                                        <th colspan="2">সরবরাহকারীর বকেয়া</th>
                                    </tr>
                                    <tr>
                                        <td>Total Due (-)</td>
                                        <td class="text-end p-2" id="totalDeliveryManDue"></td>
                                        <input type="hidden" id="totalDeliveryManDueInput" name="totalDeliveryManDueInput" value="0">
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row pt-4">
                            <table class="table-bordered">
                                <tr>
                                    <td class="text-end">Final Invoice Payable Amount : </td>
                                    <td class="text-end p-2" id="refundReceivable"></td>
                                    <input type="hidden" id="refundReceivableInput" name="refundReceivableInput" value="0">
                                    <td class="text-end">Final Cash Receivable : </td>
                                    <td class="text-end p-2" id="cashReceivable"></td>
                                    <input type="hidden" id="cashReceivableInput" name="cashReceivableInput" value="0">
                                    <input type="hidden" id="flag" name="flag" value="0">
                                    <!--<td class="text-end">Cash Received (Tk.) </td>-->
                                    <!--<td class="text-end p-2">-->
                                    <!--    <input type="number" id="amountReceived" class="form-control" name="amountReceived" min='0' />-->
                                    <!--</td>-->
                                </tr>
                            </table>
                        </div>
                        <!--Delivery man due modal start-->
                        <div class="modal fade" id="deliveryManDueForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delivery Man Due Entry</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="row p-2 ">
                                        <div class="col-md-5">
                                            <label>Due Amount</label>
                                            <input type="number" class="form-control" id="deliveryManDueAmount" name="deliveryManDueAmount" min="0"/>
                                        </div>
                                        <div class="col-md-2 pt-4">
                                            <div id="add_delivery_man_due_btn" class="btn btn-primary float-right"> ADD </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="isSalaryAdjustable" class="mt-4">
                                                <input type="checkbox" id="isSalaryAdjustable" name="isSalaryAdjustable"/> Adjust From Salary
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Delivery man due modal end-->
                        <div class="form-group">
                            <a class="btn btn-primary mt-2" class="text-light" href="{{route('all-return')}}">Back</a>
                            <button type="submit" id="submit_return_btn" class="btn btn-primary mt-2 float-right">Submit</button>
                        </div>
                        <br>
                    </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

   <!-- Modal Forms Definition Start -->
   <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Invoice Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="cart_view_modal" class="modal-body" style="scroll">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="damageReturn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Damage Return Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="row p-2 ">
                <div class="col-md-4 overflow-hidden">
                    <label class="d-block">Select Product</label>
                    <select class="form-control product-list" id="products" name="products">
                        <option>------Select------</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Quantity</label>
                    <input type="number" class="form-control" id="damageProductReturnQuantity" name="damageProductReturnQuantity" min="0"/>
                </div>
                <div class="col-md-3">
                    <label>Rate</label>
                    <input type="number" class="form-control" id="damageProductReturnAmount" name="damageProductReturnAmount" min="0"/>
                </div>
                <div class="col-md-2 pt-4">
                    <div id="add_damage_product_btn" class="btn btn-primary float-right"> ADD </div>
                </div>
            </div>

            <div class="modal-body table-responsive" style="scroll">
                <table class="table table-bordered border-primary">
                    <thead>
                        <tr>
                            <th class="d-none">id</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="damage_items_modal">

                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between px-3">
                <p>Damage Item Count: <span id="damage_item_count">5</span></p>
                <p>Damage Item Amount: <span id="damage_item_amount">5</span></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="consumerDueForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Customer Due Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row p-2 ">
                <div class="col-md-4 overflow-hidden">
                    <label class="d-block">Select Consumer</label>
                    <select class="form-control product-list" id="customer" name="customer">
                        <option>------Select------</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Due Amount</label>
                    <input type="number" class="form-control" id="customerDueAmount" name="customerDueAmount" min="0"/>
                </div>
                <div class="col-md-2 pt-4">
                    <div id="add_customer_due_btn" class="btn btn-primary float-right"> ADD </div>
                </div>
            </div>
            <div class="modal-body table-responsive" style="scroll">
                <table class="table table-bordered border-primary">
                    <thead>
                        <tr>
                            <th class="d-none">id</th>
                            <th>Customer Name</th>
                            <th>Due Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="customer_due_modal">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal Forms Definition End -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>

<script>
    $(document).ready(function() {

        $('.product-list').select2();

        $('body').addClass('sidebar-icon-only');

        //get product name and id and load
        $.ajax({
            url: 'get-products',
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data) {
                $.each(data, function(col, product) {

                    $("#products").append('<option value="'+ product.product_id +'">' + product.product_name + '</option>');
                });
            }
        });

        //get customer name and id and load
        $.ajax({
            url: 'get-all-customer',
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data) {
                $.each(data, function(col, consumer) {
                    $("#customer").append('<option value="'+ consumer.login_id +'">' + consumer.consumer_name + '</option>');
                });
            }
        });

        function get_damaged_items(deliveryManID,cartID) {
            if(!deliveryManID) return;
            if(!cartID) return;
            $('#damage_items_modal').empty();
            $.ajax({
                url: 'get-damage-item/'+deliveryManID+'/'+cartID,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success: function(data) {
                    var viewHtml="";
                    var totalKaunt = 0;
                    var toalBhalue = 0;
                    $.each(data, function(key, value){
                        totalKaunt += parseInt(value.quantity);
                        toalBhalue += parseFloat(value.total);
                        viewHtml+=`
                            <tr>
                                <td class="d-none">${value.damage_item_id}</td>
                                <td>${value.product_name}</td>
                                <td>${value.quantity}</td>
                                <td>${value.rate}</td>
                                <td>${value.total}</td>
                                <td><a value='${value.damage_item_id}' id='delete_tempcart'><i class='fa fa-trash' aria-hidden='true'></i></a></td>
                            </tr>
                        `;
                    });
                    $('#damage_items_modal').append(viewHtml);

                    $('#damage_item_count').text(totalKaunt);
                    $('#damage_item_amount').text(toalBhalue.toFixed(2));

                    $('#totalReturnedDamagedQuantity').text(totalKaunt);
                    $('#totalReturnedDamagedQuantityInput').val(totalKaunt);



                    $('#totalReturnedDamagedAmount').text(toalBhalue.toFixed(2));
                    $('#totalReturnedDamagedAmountInput').val(toalBhalue.toFixed(2));

                    calculate();
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors
                    // alert('AJAX Error:', error);
                    alert('ডাটা খুঁজে পাওয়া যায়নি।');
                }
            });
        }


        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); // January is 0!
            const year = date.getFullYear();

            return `${day}/${month}/${year}`;
        }

        function calculate()
        {
            var invoiceDue =0;
            var returnAmount = 0;
            var damageAmount = 0;
            var customerDue = 0;
            var deliveryMandDue = 0;
            var paidAmount = 0;
            var totalInvoiceReturn = 0;
            var totalPaymentDue = 0;
            var finalInvoicePayable = 0;
            var finalCashPayable = 0;


            var invoiceDue = parseFloat($('#cart_invoice_due_input').val()) || 0;
            var returnAmount = parseFloat($('#returnAmountInput').val()) || 0;
            var damageAmount = parseFloat($('#totalReturnedDamagedAmountInput').val()) || 0;
            var customerDue = parseFloat($('#customerTotalDueInput').val()) || 0;
            var deliveryManDue = parseFloat($('#totalDeliveryManDueInput').val()) || 0;
            var paidAmount = parseFloat($('#cart_invoice_paid_input').val()) || 0;

            // // Example usage of the parsed values
            // console.log('Invoice Due:', invoiceDue);
            // console.log('Return Amount:', returnAmount);
            // console.log('Damage Amount:', damageAmount);
            // console.log('Customer Due:', customerDue);
            // console.log('Delivery Man Due:', deliveryManDue);
            // console.log('Paid Amount:', paidAmount);

            totalInvoiceReturn = returnAmount+damageAmount;
            totalPaymentDue = customerDue + deliveryManDue;
            finalInvoicePayable = invoiceDue - paidAmount - totalInvoiceReturn;
            finalCashPayable = invoiceDue - paidAmount - totalInvoiceReturn - totalPaymentDue;

            // console.log('Total Invoice Return:', totalInvoiceReturn);
            // console.log('Total Payment Due:', totalPaymentDue);
            // console.log('Final Invoice Payable:', finalInvoicePayable);
            // console.log('Final Cash Payable:', finalCashPayable);

            // $('#revised_invoice_amount').text(finalInvoicePayable.toFixed(2));
            // $('#revised_invoice_amount_input').val(finalInvoicePayable.toFixed(2));

            $('#refundReceivable').text(finalInvoicePayable.toFixed(2));
            $('#refundReceivableInput').val(finalInvoicePayable.toFixed(2));

            $('#cashReceivable').text(finalCashPayable.toFixed(2));
            $('#cashReceivableInput').val(finalCashPayable.toFixed(2));

        }

        $('#select_consumer_id').on('change', function() {
            var consumer_id = $(this).val();

            if(consumer_id) {
                $.ajax({
                    url: 'get-return-cart/'+consumer_id,
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data)
                    {
                        if(data){
                            $('#select_cart_id').empty();
                            $('#cart_items').empty();
                            $("#get_total_amount").val('');
                            $("#get_non_refundAble").val('');
                            $("#get_refundAble_amount").val('');
                            $('#select_cart_id').append('<option hidden>Choose Cart</option>');
                            $.each(data, function(key, value){
                                $('select[name="cart_id"]').append('<option value="'+ value.cart_id +'">' + value.cart_id+'-'+ formatDate(value.cart_date)+ '</option>');
                            });
                        }else{
                            $('#select_cart_id').empty();
                        }
                }
            });
            }else{
                $('#select_cart_id').empty();
            }
        });

        window.ItemDataHelper = function(temp_cart_item) {
            var html = `
                <tr class='py-3' value='${temp_cart_item.cart_item_id}'>
                    <td class='p-3' width='40%'>
                        <input name='cart_item_id[]' type='hidden' value='${temp_cart_item.cart_item_id}'/>
                        ${temp_cart_item.product_name}
                    </td>
                    <td class='p-3' width='10%'>${temp_cart_item.unit_sales_cost}</td>
                    <td class='p-3' width='10%'>${temp_cart_item.quantity}</td>
                    <td class='p-3' width='10%'>${temp_cart_item.net_amount}</td>
                    <td width='30%'>
                        <input type="hidden" name="sales_quantity[]" value="${temp_cart_item.quantity}">
                        <input type="hidden" name="item_sales_price[]" value="${temp_cart_item.unit_sales_cost}">
                        <input type="hidden" name="item_stock_id[]" value="${temp_cart_item.stock_id}">
                        <input type="hidden" name="item_product_id[]" value="${temp_cart_item.product_id}">
                        <input class='form-control text-right sales_quantity' name="return_quantity[]" sales_price='${temp_cart_item.unit_sales_cost}' cart_item_id='${temp_cart_item.cart_item_id}' sales_quantity='${temp_cart_item.quantity}'
                           value='0'
                           type='number'
                           step='0.01'
                           name='quantity[]'
                           min='0'
                           max='${temp_cart_item.quantity}'>
                    </td>
                </tr>`;

            return html;
        }


        $('#select_cart_id').on('change', function() {
            var cart_id = $(this).val();
            var delivery_man_id = $('#select_consumer_id').val();
            // get_damaged_items(delivery_man_id,cart_id);
            // get_customer_dues(delivery_man_id,cart_id);
            $('#cart_items').empty();
            if(cart_id)
            {
                $.ajax({
                    url: 'get-return-item/'+cart_id,
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data)
                    {   //console.log(data);
                        var total_quantity = 0;
                        var final_payable = 0;
                        var flag = 0;

                        $('#cart_view_modal').empty();
                        $('#items').empty();

                        var calculateReturnBtn = document.getElementById("calculate_return_btn");
                        var damageReturnForm = document.getElementById("damage_return_form");
                        var dueEntryForm = document.getElementById("conumer_due_form");
                        var deliveryManDueForm = document.getElementById("delivery_man_due_form");

                        if(data.cartInfo.final_total_amount == data.cartInfo.due_amount)
                        {
                            calculateReturnBtn.style.display = 'block';
                            damageReturnForm.style.display = 'block';
                            dueEntryForm.style.display = 'block';
                            deliveryManDueForm.style.display = 'block';
                        }
                        else
                        {
                            calculateReturnBtn.style.display = 'none';
                            damageReturnForm.style.display = 'none';
                            dueEntryForm.style.display = 'none';
                            deliveryManDueForm.style.display = 'none';
                            flag = 1;
                        }

                        //Start - setting the invoice view.
                        var viewHtml="";
                        viewHtml+='<div class="row px-5 py-3"><div class="col-6">Order No</div><div class="col-6">'+data.cartInfo.cart_id+'</div></div>'
                        viewHtml+='<div class="row px-5 py-3"><div class="col-6">Date</div><div class="col-6">'+data.cartInfo.cart_date+'</div></div>'
                        viewHtml+='<div class="row px-5 py-3"><div class="col-6">Items</div><div class="col-6" id="items"></div></div>'
                        viewHtml+='<div class="row px-5 py-3"><div class="col-6">Total Cart Amount</div><div class="col-6">'+data.cartInfo.total_cart_amount+'</div></div>'
                        viewHtml+='<div class="row px-5 py-3"><div class="col-6">Vat</div><div class="col-6">'+data.cartInfo.vat_amount	+'</div></div>'
                        viewHtml+='<div class="row px-5 py-3"><div class="col-6">Discount</div><div class="col-6">'+data.cartInfo.total_discount+'</div></div>'
                        viewHtml+='<div class="row px-5 py-3"><div class="col-6">Payable</div><div class="col-6">'+data.cartInfo.total_payable_amount+'</div></div>'
                        viewHtml+='<div class="row px-5 py-3"><div class="col-6">Paid</div><div class="col-6">'+data.cartInfo.paid_amount+'</div></div>'
                        viewHtml+='<div class="row px-5 py-3"><div class="col-6">Due</div><div class="col-6">'+data.cartInfo.due_amount+'</div></div>'

                        $('#cart_view_modal').append(viewHtml);

                        $.each(data.CartItem, function(key, item){
                            if(flag == 0)
                            {
                                $('#cart_items').append(ItemDataHelper(item));
                            }
                            $('#items').append("<p>"+item.product_name+" - Qty# "+item.quantity+"</p>");
                            total_quantity=Math.floor(total_quantity+item.quantity);
                        });
                        //End - setting the invoice view.

                        $("#cart_invoice_qunatity").text(total_quantity||0);
                        $("#cart_invoice_qunatity_input").val(total_quantity||0);
                        $("#cart_invoice_amount").text(data.cartInfo.final_total_amount.toFixed(2));
                        $("#cart_invoice_amount_input").val(data.cartInfo.final_total_amount.toFixed(2));
                        $("#cart_invoice_paid").text((data.cartInfo.paid_amount || 0).toFixed(2));
                        $("#cart_invoice_paid_input").val((data.cartInfo.paid_amount || 0).toFixed(2));
                        $("#cart_invoice_due").text((data.cartInfo.due_amount||0).toFixed(2));
                        $("#cart_invoice_due_input").val((data.cartInfo.due_amount||0).toFixed(2));

                        if(flag == 1)
                        {
                            document.getElementById("original_invoice_row").style.display = '';
                            $('#original_invoice_amount').text(data.CartReturnInfo.cart_total_amount || 0);
                            $("#returnCount").text(data.CartReturnInfo.total_return_qunatity || 0);
                            $("#returnAmount").text(data.CartReturnInfo.refund_amount || 0);
                            $('#totalReturnedDamagedQuantity').text(data.CartReturnInfo.damage_return_quantity || 0);
                            $('#totalReturnedDamagedAmount').text(data.CartReturnInfo.damage_return_amount || 0);
                            $('#customerTotalDue').text(data.CartReturnInfo.total_customer_due || 0);
                            $('#totalDeliveryManDue').text(data.CartReturnInfo.delivery_man_due || 0);
                            $('#totalDeliveryManDueInput').val(data.CartReturnInfo.delivery_man_due || 0);
                            $("#refundReceivable").text(data.CartReturnInfo.new_total_amount||0);
                            $("#refundReceivableInput").val(data.CartReturnInfo.new_total_amount||0);
                            $("#cashReceivable").text(data.CartReturnInfo.delivery_man_due||0);
                            $("#cashReceivableInput").val(data.CartReturnInfo.delivery_man_due||0);

                            $("#flag").val('1');
                        }
                        else
                        {
                            document.getElementById("original_invoice_row").style.display = 'none';
                            $('#original_invoice_amount').text('0');

                            $("#returnCount").text('0');
                            $("#returnCountInput").val('0');

                            $("#returnAmount").text('0');
                            $("#returnAmountInput").val('0');

                            get_damaged_items(delivery_man_id,cart_id);
                            get_customer_dues(delivery_man_id,cart_id);

                            $('#totalDeliveryManDue').text('0');
                            $("#totalDeliveryManDueInput").val('0');
                            $("#flag").val('0');
                        }

                    }
                });
            }
        });

        document.getElementById("add_damage_product_btn").addEventListener("click", function() {
            var selectedCartID = $('#select_cart_id').val();
            var deliveryManID =  $('#select_consumer_id').val();
            var selectedProductID = $('#products').val();
            var totalAmount;

            if(selectedCartID == null)
            {
                alert("অনুগ্রহ করে ইনভয়েস সিলেক্ট করুন।");
                return;
            }

            if(selectedProductID == "------Select------")
            {
                alert("অনুগ্রহ করে পণ্য সিলেক্ট করুন। ");
                return;
            }

            if ($('#damageProductReturnQuantity').length > 0) {
                var selectedProductQuantity = $('#damageProductReturnQuantity').val();

                if (!selectedProductQuantity) {
                    alert('অনুগ্রহ করে ক্ষতিগ্রস্ত পণ্য রিটার্ন পরিমাণ চেক করুন। ');
                    return;
                }
            } else {
                alert('ক্ষতিগ্রস্ত পণ্য রিটার্ন পরিমাণ দেওয়া হয় নাই।');
                return;
            }

            if ($('#damageProductReturnAmount').length > 0) {
                var selectedProductRate = $('#damageProductReturnAmount').val();

                if (!selectedProductRate) {
                    alert('অনুগ্রহ করে ক্ষতিগ্রস্ত পণ্যের মূল্য চেক করুন".');
                    return;
                }
            } else {
                alert('Input " ক্ষতিগ্রস্ত পণ্যের মূল্য দেওয়া হয় নাই। ');
                return;
            }

            $.ajax({
                url: 'store-damage/'+selectedCartID+'/'+selectedProductID+'/'+selectedProductQuantity+'/'+selectedProductRate+'/'+deliveryManID,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success: function(data) {
                    if (data.status) {
                        get_damaged_items(deliveryManID,selectedCartID);
                    } else {
                        // Handle the case where status is false
                        alert('Error:', data.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors
                    alert('AJAX Error:', error);
                }
            });

        });

        document.getElementById("calculate_return_btn").addEventListener("click", function() {
            //check invoice selection
            var selectedInvocieValue = $("#select_cart_id").val();
            if(selectedInvocieValue==null || selectedInvocieValue=="Choose Cart")
            {
                alert("ইনভয়েস সিলেক্ট করা হয় নাই।");
                return;
            }

            // Get all input elements with class "sales_quantity"
            var salesQuantityInputs = document.querySelectorAll(".sales_quantity");
            var newTotal = 0;
            var errorFlag = false;
            var returnQuantityTotal = 0;
            var returnAmountTotal = 0;

            // Loop through each input element
            salesQuantityInputs.forEach(function(input) {
                var salesQuantity = parseFloat(input.getAttribute("sales_quantity"));
                var rate = parseFloat(input.getAttribute("sales_price"));
                var returnQuantity = parseFloat(input.value);

                // Check if return quantity is greater than sales quantity
                if (returnQuantity > salesQuantity) {
                    errorFlag = true;
                    input.classList.add("is-invalid");
                    alert("রিটার্ন পরিমাণ বিক্রীত পরিমাণ হতে বেশী দেয়া যাবে না");
                } else {
                    input.classList.remove("is-invalid");

                    var rowTotal = (salesQuantity - returnQuantity) * rate;
                    var rowReturn = returnQuantity * rate;

                    returnQuantityTotal += returnQuantity;
                    newTotal += rowTotal;
                    returnAmountTotal += rowReturn;
                }
            });

            if (errorFlag) {
                // If error flag is true, do not update the total
                $("#returnCount").text("0");
                $("#returnCountInput").val("0");
                $("#returnAmount").text("0");
                $("#returnAmountInput").val("0");
            } else {
                $("#returnCountInput").val(returnQuantityTotal);
                $("#returnCount").text(returnQuantityTotal);
                $("#returnAmountInput").val(returnAmountTotal.toFixed(2));
                $("#returnAmount").text(returnAmountTotal.toFixed(2));
            }
            calculate();
        });

        document.getElementById("submit_return_btn").addEventListener("click", function() {
            if (!confirm("আপনি কি নিশ্চিত?")) {
                event.preventDefault();
                return;
            }
            var salesQuantityInputs = document.querySelectorAll(".sales_quantity");
            var returnCount = parseFloat(document.getElementById("returnCountInput").value);

            var cashReceivable = parseFloat(document.getElementById("cashReceivableInput").value);
            var totalReturnQuantity = 0;
            var newTotal = 0;
            var errorFlag = false;

            if (cashReceivable === 0) {
                alert("ক্রেতার বকেয়া 'কাস্টমার পেমেন্ট' থেকে পেমেন্ট করুন।");
                event.preventDefault();
                return;
            }

            salesQuantityInputs.forEach(function(input) {
                var salesQuantity = parseFloat(input.getAttribute("sales_quantity"));
                var salesPrice = parseFloat(input.getAttribute("sales_price"));
                var returnQuantity = parseFloat(input.value);

                // Check if return quantity is greater than sales quantity
                if (returnQuantity > salesQuantity) {
                    errorFlag = true;
                    input.classList.add("is-invalid");
                } else {
                    input.classList.remove("is-invalid");
                    var rowTotal = (salesQuantity - returnQuantity) * salesPrice;
                    newTotal += rowTotal;
                    totalReturnQuantity += returnQuantity;
                }
            });

            if (totalReturnQuantity !== returnCount) {
                errorFlag = true;
                alert("অনুগ্রহ করে রিটার্ন সংখ্যা চেক করুন এবং ক্যালকুলেট বোতাম ক্লিক করুন।");
                event.preventDefault();
                return;
            }

            if (errorFlag) {
                return;
            } else {
                document.getElementById("refundForm").submit();
            }
        });

        //-------- Delete Temp Cart ---------
        $('#damage_items_modal').on('click', '#delete_tempcart', function(e){
            e.preventDefault();
            var temp_item_id = $(this).attr('value');
            var cart_id = $('#select_cart_id').val();
            var delivery_man_id = $('#select_consumer_id').val();
            $.ajax({
                url: "delete_temp_damage_return_item/" + temp_item_id,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(data) {
                    get_damaged_items(delivery_man_id, cart_id);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });

        function get_customer_dues(deliveryManID,selectedCartID) {
            $('#customer_due_modal').empty();
            var totalCustomerDue = 0;
            $.ajax({
                url: 'get-temp-due-item/'+deliveryManID+'/'+selectedCartID,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success: function(data) {
                    var viewHtml="";
                    $.each(data, function(key, value){
                        totalCustomerDue += parseFloat(value.amount) || 0;
                        viewHtml+=`
                            <tr>
                                <td class="d-none">${value.due_id}</td>
                                <td>${value.consumer_name}</td>
                                <td>${value.amount}</td>
                                <td><a value='${value.due_id}' id='delete_temp_Customer_Due'><i class='fa fa-trash' aria-hidden='true'></i></a></td>
                            </tr>
                        `;
                    });
                    $('#customer_due_modal').append(viewHtml);
                    // console.log(totalCustomerDue);
                    $('#customerTotalDue').text(totalCustomerDue);
                    $('#customerTotalDueInput').val(totalCustomerDue);
                    calculate();
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors
                    // alert('AJAX Error:', error);
                    alert('ডাটা খুঁজে পাওয়া যায়নি।');
                }
            });
        }

        document.getElementById("add_customer_due_btn").addEventListener("click", function() {
            var selectedCartID = $('#select_cart_id').val();
            var deliveryManID =  $('#select_consumer_id').val();
            var selectedCustomerID = $('#customer').val();

            if(selectedCartID == null)
            {
                alert("অনুগ্রহ করে ইনভয়েস সিলেক্ট করুন।");
                return;
            }

            if(selectedCustomerID == "------Select------")
            {
                alert("অনুগ্রহ করে গ্রাহক সিলেক্ট করুন। ");
                return;
            }

            if ($('#customerDueAmount').length > 0) {
                var amount = $('#customerDueAmount').val();

                if (!amount) {
                    alert('অনুগ্রহ করে বকেয়া টাকা ইনপুট দিন।');
                    return;
                }
            } else {
                alert('অনুগ্রহ করে বকেয়া টাকা ইনপুট দিন।');
                return;
            }

            $.ajax({
                url: 'store-customer-due/'+selectedCartID+'/'+selectedCustomerID+'/'+amount+'/'+deliveryManID,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success: function(data) {
                    if (data.status) {
                        get_customer_dues(deliveryManID,selectedCartID);
                    } else {
                        // Handle the case where status is false
                        alert('Error:', data.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors
                    alert('AJAX Error:', error);
                }
            });

        });

        $('#consumerDueForm').on('click', '#delete_temp_Customer_Due', function(e){
            e.preventDefault();
            var temp_item_id = $(this).attr('value');
            var cart_id = $('#select_cart_id').val();
            var delivery_man_id = $('#select_consumer_id').val();

            $.ajax({
                url: "delete_temp_due_item/" + temp_item_id,
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(data) {
                    get_customer_dues(delivery_man_id, cart_id);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });


        $('#deliveryManDueForm').on('click', '#add_delivery_man_due_btn', function(e){
            var selectedCartID = $('#select_cart_id').val();
            if(selectedCartID == null)
            {
                alert("অনুগ্রহ করে ইনভয়েস সিলেক্ট করুন।");
                return;
            }

            if ($('#deliveryManDueAmount').val() > 0) {
                var amount = $('#deliveryManDueAmount').val();

                if (!amount) {
                    alert('অনুগ্রহ করে বকেয়া টাকা ইনপুট দিন।');
                    return;
                }
            } else {
                alert('অনুগ্রহ করে বকেয়া টাকা ইনপুট দিন।');
                return;
            }

            var existing_paid_amount = 0;
            existing_paid_amount = parseFloat($('#cart_invoice_paid_input').val()) || 0;
            var delivery_man_due_amount = 0;
            delivery_man_due_amount = parseFloat($('#deliveryManDueAmount').val()) || 0;
            const checkbox = document.getElementById('isSalaryAdjustable');
            var calculate_paid_amount = 0;

            if (checkbox.checked) {
                calculate_paid_amount = existing_paid_amount + delivery_man_due_amount;
                $('#cart_invoice_paid').text(calculate_paid_amount);
                $('#cart_invoice_paid_input').val(calculate_paid_amount);
                $('#totalDeliveryManDue').text('0');
                $('#totalDeliveryManDueInput').val(0);
            } else {
                $('#cart_invoice_paid').text('0');
                $('#cart_invoice_paid_input').val('0');
                $('#totalDeliveryManDue').text(delivery_man_due_amount);
                $('#totalDeliveryManDueInput').val(delivery_man_due_amount);
            }

            calculate();
        });

    });
</script>


@include('admin.footer')
