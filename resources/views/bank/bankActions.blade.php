@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top:120px">
    <div class="m-3">
        <!--Bank Section Start---->
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                        <div class="col-12 h4 text-center">
                           Bank Infos<hr>
                        </div>
                        <div class="col-6 col-md-12 col-lg-12 mb-3">
                            <div id="add_new_bank" class="btn">Add New bank</div>
                        </div>
                        <hr>
                        <div class="col-6 col-md-12 col-lg-12 mb-3">
                            <div id="all_banks" class="btn">All Banks</div>
                        </div>
                        <hr>
                        <div class="col-6 col-md-12 col-lg-12 mb-3">
                            <div id="add_new_deposit" class="btn">Deposit / Withdraw</div>
                        </div>
                        <hr>
                        <div class="col-6 col-md-12 col-lg-12 mb-3">
                            <div id="transactions" class="btn">Daily Transactions</div>
                        </div>
                        <hr>
                        {{-- <div class="col-6 col-md-12 col-lg-12 mb-3">
                            <div id="reports" class="btn">Reports</div>
                        </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center h4" id="page_title"></div>
                    </div>
                </div>
                <div class="card mt-1">
                    <div class="card-body overflow-auto">
                        <div id="page_body"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/simple-icons/3.2.0/tata.js"></script>

<script type="text/javascript">
$(document).ready(function() {

    $('body').addClass('sidebar-icon-only');

    $("#page_title").empty();
    $("#page_body").empty();

    //Add New Bank
    $("#add_new_bank").on("click",function(){

        $("#page_title").empty();
        $("#page_body").empty();

        $("#page_title").append("Add New Bank");

        var add_bank_body_html="";
        add_bank_body_html+='<form action="{{route("insert-bank")}}" method="post" enctype="multipart/form-data">'
        add_bank_body_html+='@if (session()->has("fail"))'
        add_bank_body_html+='<div class="alert alert-danger">{{session()->get("fail")}}</div>'
        add_bank_body_html+='@endif'
        add_bank_body_html+='@csrf'
           add_bank_body_html+='<div class="row">'
            add_bank_body_html+='<div class="col-md-6">'
              add_bank_body_html+='<div class="form-group row">'
                add_bank_body_html+='<label class="col-sm-3 col-form-label">Bank Name:</label>'
                add_bank_body_html+='<div class="col-sm-9">'
                  add_bank_body_html+='<input required type="text" class="form-control" name="bank_name" placeholder="Enter Bank Name" value="">'
                add_bank_body_html+='</div>'
              add_bank_body_html+='</div>'
            add_bank_body_html+='</div>'
            add_bank_body_html+='<div class="col-md-6">'
              add_bank_body_html+='<div class="form-group row">'
                add_bank_body_html+='<label class="col-sm-3 col-form-label">Select Status</label>'
                add_bank_body_html+='<div class="col-sm-9">'
                  add_bank_body_html+='<select  class="form-control" name="is_active" required>'
                    add_bank_body_html+='<option value=""  selected="true" disabled="disabled">-----------Select----------</option>'
                    add_bank_body_html+='<option value="1">Active</option>'
                    add_bank_body_html+='<option value="0">Not Active</option>'
                add_bank_body_html+='</select>'
                add_bank_body_html+='</div></div></div></div>'
          add_bank_body_html+='<div class="form-group">'
              add_bank_body_html+='<button type="submit" class="btn btn-primary mt-2 float-right">Submit</button>'
          add_bank_body_html+='</div><br></form>';

        $("#page_body").append(add_bank_body_html);
    });

    window.GetBanksDataHelper = function() {
        $("#page_title").empty();
        $("#page_body").empty();

        $("#page_title").append("Bank List");
        var i=1;
        var all_banks_html="";
        all_banks_html+='<div class="table-responsive">'
        all_banks_html+='<table id="myTable" class="table table-striped display">'
          all_banks_html+='<thead><tr ><th>S.N</th><th>Bank Name</th><th>Current Balance</th><th>Action</th></tr></thead>'
          all_banks_html+='<tbody id="banks_data">'
          all_banks_html+='</tbody></table></div>';
        $("#page_body").append(all_banks_html);

        var all_banks_data="";
        $.ajax({
        url: '{{ route('ajax-all-bank') }}',
        type: "GET",
        data: {
            "_token": "{{ csrf_token() }}"
        },
        dataType: "json",
        success: function(data) {
                $.each(data, function(col, bank) {
                    var url = '{{ route("edit-bank", ":id") }}';
                    url = url.replace(':id', bank.bank_id);

                    all_banks_data+='<tr>'
                        all_banks_data+='<td>'+ i++; +'</td>'
                        all_banks_data+='<td>'+bank.bank_name+'</td>'
                        all_banks_data+='<td>'+bank.balance+'</td>'
                        all_banks_data+='<td>'
                        all_banks_data+='<a class="btn btn-warning" class="text-light" href="'+url+'">'
                            all_banks_data+='<i class="fa fa-edit"></i>'
                            all_banks_data+='</a>'
                        all_banks_data+='</td>'
                    all_banks_data+='</tr>'
                });
                $("#banks_data").append(all_banks_data);
            }
        });
    }

    window.GetTransactionDataHelper = function() {
        $.ajax({
            url: '{{ route('ajax-all-transactions') }}',
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function(data) {
                $("#page_title").empty();
                $("#page_body").empty();

                $("#page_title").append("Transactions Today");
                var trx="";
                trx+='<table id="example" class="table table-bordered">'
                    trx+='<thead class="">'
                        trx+='<tr>'
                            trx+='<th>SL</th>'
                            trx+='<th>Bank</th>'
                            trx+='<th>Trx Type</th>'
                            trx+='<th>Trx Mode</th>'
                            trx+='<th>prev Balance</th>'
                            trx+='<th>Amount</th>'
                            trx+='<th>Curr Balance</th>'
                        trx+='</tr></thead><tbody id="trx"></tbody></table>'
                $("#page_body").append(trx);
                var trxdt="";
                var j=1;
                    $.each(data, function(col, bank) {
                        if(bank.trx_type==1){
                        trxdt+='<tr style="background-color:#bff5da;">'
                        }else{
                            trxdt+='<tr style="background-color:#f7dada;">'
                        }
                            trxdt+='<td>'+ j++ +'</td>'
                            trxdt+='<td>'+bank.bank_name+'</td>'
                            if(bank.trx_type==1){
                            trxdt+='<td>Deposit</td>'
                            }else{
                                trxdt+='<td>Withdraw</td>'
                            }
                            if(bank.trx_mode==1){
                            trxdt+='<td>Cash</td>'
                            }else if(bank.trx_mode==2){
                                trxdt+='<td>Checque</td>'

                            }else if(bank.trx_mode == 3){
                                trxdt+='<td>ATM</td>'

                            }else if(bank.trx_mode == 4){
                                trxdt+='<td>Others</td>'
                            }
                            trxdt+='<td>'+bank.prev_balance+'</td>'
                            trxdt+='<td>'+bank.amount+'</td>'
                            trxdt+='<td>'+bank.current_balance+'</td>'
                        trxdt+='</tr>'
                    });
                    $("#trx").append(trxdt);
                }
        });
    }
    GetTransactionDataHelper();
    //All Banks
    $("#all_banks").on("click",function(){
        GetBanksDataHelper();
    });

     //Deposit
    $("#add_new_deposit").on("click",function(){

        $("#page_title").empty();
        $("#page_body").empty();

        $("#page_title").append("Deposit / Withdraw");

        var add_bank_body_html="";
           add_bank_body_html+='<div class="row">'
                add_bank_body_html+='<div class="col-md-6">'
                add_bank_body_html+='<div class="form-group row">'
                    add_bank_body_html+='<div class="col-12 col-md-4 col-lg-4 col-form-label">Bank Name:</div>'
                    add_bank_body_html+='<div class="col-12 col-md-8 col-lg-8">'
                    add_bank_body_html+='<select id="bank_id" class="form-control mt-2" name="bank_id"></select>'
                    add_bank_body_html+='</div>'
                add_bank_body_html+='</div>'
                add_bank_body_html+='</div>'
                add_bank_body_html+='<div class="col-md-6">'
                add_bank_body_html+='<div class="form-group row">'
                    add_bank_body_html+='<div class="col-12 col-md-4 col-lg-4 col-form-label">Trx Type</div>'
                    add_bank_body_html+='<div class="col-12 col-md-8 col-lg-8">'
                    add_bank_body_html+='<select id="trx_type" class="form-control mt-2" name="trx_type">'
                    add_bank_body_html+='<option selected disabled>---------Select---------</option>'
                    add_bank_body_html+='<option value="1">Deposit</option><option value="2">Withdraw</option>'
                    add_bank_body_html+='</select>'
                    add_bank_body_html+='</div>'
                add_bank_body_html+='</div>'
                add_bank_body_html+='</div>'
            add_bank_body_html+='</div>'
           add_bank_body_html+='<div class="row">'
            add_bank_body_html+='<div class="col-md-6">'
                add_bank_body_html+='<div class="form-group row">'
                    add_bank_body_html+='<div class="col-12 col-md-4 col-lg-4 col-form-label">Trx Mode</div>'
                    add_bank_body_html+='<div class="col-12 col-md-8 col-lg-8">'
                    add_bank_body_html+='<select id="trx_mode" class="form-control mt-2" name="trx_mode">'
                    add_bank_body_html+='<option selected disabled>---------Select---------</option>'
                    add_bank_body_html+='<option value="1">Cash</option><option value="2">Cheque</option><option value="3">ATM</option><option value="4">Others</option>'
                    add_bank_body_html+='</select>'
                    add_bank_body_html+='</div>'
                add_bank_body_html+='</div>'
                add_bank_body_html+='</div>'
                add_bank_body_html+='<div class="col-md-6">'
                add_bank_body_html+='<div class="form-group row">'
                    add_bank_body_html+='<div class="col-12 col-md-4 col-lg-4 col-form-label">Amount</div>'
                    add_bank_body_html+='<div class="col-12 col-md-8 col-lg-8">'
                    add_bank_body_html+='<input type="number" id="amount" class="form-control mt-2" name="amount" />'
                    add_bank_body_html+='</div>'
                add_bank_body_html+='</div>'
                add_bank_body_html+='</div>'
            add_bank_body_html+='</div><div id="mode_fields" class="row"></div>'
          add_bank_body_html+='<div class="form-group text-right">'
              add_bank_body_html+='<button id="submit_wd_form" type="submit" class="btn btn-primary mt-2">Submit</button>'
          add_bank_body_html+='</div><br>';

        $("#page_body").append(add_bank_body_html);

        var abd="";
        abd+="<option selected disabled>---------Select---------</option>"
        $.ajax({
        url: '{{ route('ajax-all-bank') }}',
        type: "GET",
        data: {
            "_token": "{{ csrf_token() }}"
        },
        dataType: "json",
        success: function(data) {
                $("#bank_id").empty();
                $.each(data, function(col, bank) {
                    abd+='<option value="'+bank.bank_id+'">'+bank.bank_name+'</option>'
                });
                $("#bank_id").append(abd);
            }
        });



        $("#trx_mode").on("change",function(){
        $("#mode_fields").empty();
        var mode_type = $(this).val();
        var mfd="";
        if(mode_type == 2){
                mfd+='<div class="col-md-6">'
                mfd+='<div class="form-group row">'
                    mfd+='<div class="col-12 col-md-4 col-lg-4 col-form-label">Bank Name:</div>'
                    mfd+='<div class="col-12 col-md-8 col-lg-8">'
                    mfd+='<input type="text" id="bank_name" class="form-control mt-2" name="bank_name"/>'
                    mfd+='</div>'
                mfd+='</div>'
                mfd+='</div>'
                mfd+='<div class="col-md-6">'
                mfd+='<div class="form-group row">'
                    mfd+='<div class="col-12 col-md-4 col-lg-4 col-form-label">Cheque No</div>'
                    mfd+='<div class="col-12 col-md-8 col-lg-8">'
                    mfd+='<input type="text" id="cheque_no" class="form-control mt-2" name="cheque_no" />'
                    mfd+='</div>'
                mfd+='</div>'
                mfd+='</div>';

                $("#mode_fields").append(mfd);
        }else if(mode_type == 4){
                mfd+='<div class="col-md-6">'
                mfd+='<div class="form-group row">'
                    mfd+='<div class="col-12 col-md-4 col-lg-4 col-form-label">Transaction No</div>'
                    mfd+='<div class="col-12 col-md-8 col-lg-8">'
                    mfd+='<input type="text" id="transaction_no" class="form-control mt-2" name="transaction_no"/>'
                    mfd+='</div>'
                mfd+='</div>'
                mfd+='</div>'
                mfd+='</div>';

                $("#mode_fields").append(mfd);
        }
    });

    $("#submit_wd_form").on("click",function(){

        var bank_id = $("#bank_id").val();
        var trx_type = $("#trx_type").val();
        var trx_mode = $("#trx_mode").val();
        var amount = $("#amount").val();
        var bank_name = $("#bank_name").val();
        var cheque_no = $("#cheque_no").val();
        var transaction_no = $("#transaction_no").val();

        if(!bank_id){
            swal("Please Select Bank","Fail","error");
            return ;
        }
        if(!trx_type){
            swal("Please Select Transaction Type","Fail","error");
            return ;
        }
        if(!trx_mode){
            swal("Please Select Transaction Mode","Fail","error");
            return ;
        }
        if(!amount){
            swal("Please Select Amount","Fail","error");
            return ;
        }

        $.ajax({
                url: '{{ route('ajax-store-dw-data')}}',
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "bank_id": bank_id,
                    "trx_type": trx_type,
                    "trx_mode": trx_mode,
                    "amount": amount,
                    "bank_name": bank_name,
                    "cheque_no": cheque_no,
                    "transaction_no": transaction_no,
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if(data.status==false){
                        swal(data.message,"Error","error");
                        return ;
                    }else{
                        GetTransactionDataHelper();
                        swal("Congratulations!!","Transaction Done Successfully !!","success");
                    }
                }
            });
        });

    });

    $("#transactions").on("click",function(){
        GetTransactionDataHelper();
    });
});
</script>
@include('admin.footer')
