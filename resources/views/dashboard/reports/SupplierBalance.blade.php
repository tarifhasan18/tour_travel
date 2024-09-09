@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120px">
    <div class="content-wrapper">
        <div class="row justify-content-center">
            <div class="col-lg-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group mb-4">
                                            <div class="input-group col-xs-12">
                                                <span class="input-group-append">
                                                    <span class="file-upload-browse btn btn-primary"> Select Supplier </span>
                                                </span>
                                                <select name="login_id" id="login_id" class="form-control">
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 text-right" id="supLedgerPrint">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header text-center">
                                        SUPPLIER LEDGER
                                    </div>
                                    <div class="card-body" id="supplier_details">
                                        <div class="text-center p-5">
                                            Please Select Customer
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>

<script type="text/javascript">
    $(document).ready(function() {

        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); // January is 0!
            const year = date.getFullYear();

            return `${day}/${month}/${year}`;
        }

        $("#login_id").empty();
        $("#login_id").append("<option selected disabled> ----select---- </option>");
        $.ajax({
            url: 'ajax-get-supplier',
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}",
            },
            dataType: "json",
            success: function(data) {
                 $.each(data, function(col, customer) {
                        $("#login_id").append('<option value="'+customer.supplier_id+'">'+customer.supplier_name+'</option>');
                 });
            }

        });

        $(document).on('change', '#login_id', function(e) {
            var login_id=$(this).val();
            $("#supplier_details").empty();
            $("#supLedgerPrint").empty();
            $.ajax({
                    url: 'ajax-get-supplier-details/'+login_id,
                    type: "GET",
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType: "json",
                    success: function(data) {
                        var supplier_id = data.supplier.supplier_id;
                        var printUrl = '/public/backoffice/print-supplier-ledger/' + supplier_id;
                        var buttonHtml = `
                            <a href="${printUrl}" target="_blank" class="btn btn-primary btn-icon-text">
                                Print <i class="mdi mdi-printer btn-icon-append"></i>
                            </a>
                        `;
                        $("#supLedgerPrint").append(buttonHtml);

                        var supplier_html='';
                        supplier_html+=`
                            <div class="container">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Name:</strong> ${data.supplier.supplier_name}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Contact:</strong> ${data.supplier.supplier_contact_person}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <p><strong>Address:</strong> ${data.supplier.supplier_address}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Mobile No.:</strong> ${data.supplier.supplier_contact_no}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 text-center">
                                        <h3>Transaction Details</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-bordered table-striped">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Invoice</th>
                                                    <th class="text-center">Payable</th>
                                                    <th class="text-center">Paid</th>
                                                    <th class="text-center">Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                        `;

                        $.each(data.payments, function(col, trx) {
                            supplier_html+=`
                                                <tr>
                                                    <td> ${formatDate(trx.created_at)} </td>
                                                    <td> ${formatDate(trx.purchase_id)} </td>
                                                    <td class="text-end"> ${trx.payable_amount !== null ? parseFloat(trx.payable_amount).toFixed(2) : 0} </td>
                                                    <td class="text-end"> ${trx.paid_amount !== null ? parseFloat(trx.paid_amount).toFixed(2) : 0} </td>
                                                    <td class="text-end"> ${trx.revised_due !== null ? parseFloat(trx.revised_due).toFixed(2) : 0} </td>
                                                </tr>
                            `;
                        });
                        supplier_html+=`
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td>Total</td>
                                                    <td class="text-end">${parseFloat(data.supplier.total_invoiced).toFixed(2)}</td>
                                                    <td class="text-end">${parseFloat(data.supplier.total_payment).toFixed(2)}</td>
                                                    <td class="text-end">${parseFloat(data.supplier.final_balance).toFixed(2)}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        `;

                        $("#supplier_details").append(supplier_html);
                    }
                });
        });
    });
</script>
@include('admin.footer')
