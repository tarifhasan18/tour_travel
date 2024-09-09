@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<!-- Start Expense Modal -->
<div class="modal fade" id="editExpense" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <input type="text" id="expenseDetailsId" hidden>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputUsername1">Expense Category:</label>
                    <select class="form-select form-control" name="edit_expense_category" id="edit_expense_category"
                        aria-label="Default select example" required>
                        <option value="" selected>-----Select-----
                        </option>

                        @foreach ($expenseCategory as $expenseCategorys)
                            <option value="{{ $expenseCategorys->expense_category_id }}">
                                {{ $expenseCategorys->expense_category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1">Particulars:</label>
                    <input type="text" placeholder="Expense Name" name="edit_expense" id="edit_expense"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1">Amount:</label>
                    <input type="number" name="edit_amount" id="edit_amount" value="" class="form-control"
                        placeholder="Enter Amount">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1">Notes:</label>
                    <textarea type="text" value="" name="edit_notes" id="edit_notes" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="update_expense" class="btn btn-primary">Update Expense</button>
            </div>
        </div>
    </div>
</div>

<!-- End Expense Modal -->

<div class="main-panels" style="padding-top: 120px;">
    <div class="content-wrapper pb-0">
        <div class="content">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-5">Expenses</h4>
                                <form class="form-sample">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label style="font-size: 12px;" class="col-sm-3 col-form-label">Expense
                                                    Category:</label>
                                                <div class="col-sm-9">
                                                    <select class="form-select form-control" name="expense_category_id"
                                                        id="expense_category_id" aria-label="Default select example"
                                                        required>
                                                        <option value="" selected>-----Select----- </option>
                                                        @foreach ($expenseCategory as $expenseCategorys)
                                                            <option
                                                                value="{{ $expenseCategorys->expense_category_id }}">
                                                                {{ $expenseCategorys->expense_category_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Amount:</label>
                                                <div class="col-sm-9">
                                                    <input type="number" name="amount" id="amount" value=""
                                                        class="form-control" placeholder="Enter Amount" required="">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Notes:</label>
                                                <div class="col-sm-9">
                                                    <textarea placeholder="Notes..." name="notes" id="notes" class="form-control" rows="2"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 expense_button">
                                        <button type="button" id="add_expense"
                                            class="btn btn-primary mr-2 mt-4 text-right expense_button float-end">Save
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>


                    <div class="card mt-4 grid-margin stretch-card">
                        <div class="card-body">
                            <div class="table-responsive mt-5">
                                <table id="myTable" class="table table-striped display">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Expense Category</th>
                                            <th>Notes</th>
                                            <th class="text-right">Amount</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="expense_tbody">

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Total</td>
                                            <td class="text-right" id="sum_amount"></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="container">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="card-title tabs-style mb-5">Customer Payment(for due)</h1>
                                <form class="forms-sample">
                                    <div class="row ">
                                        <div class="col-12 d-flex">
                                            <div class="col-md-2 mt-1 mb-4">
                                                <label for="exampleInputName1">Customer Id:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-select form-control"
                                                    aria-label="Default select example">
                                                    <option selected>XYZ</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-12 d-flex">
                                            <div class="col-md-2 mt-1 mb-4">
                                                <label for="exampleInputName1">Invoice:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-select form-control"
                                                    aria-label="Default select example">
                                                    <option selected>XYZ</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-12 d-flex">
                                            <div class="col-md-2 mt-1 mb-4">
                                                <label for="exampleInputName1">Payable:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="exampleInputPassword4"
                                                    placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex">
                                            <div class="col-md-2 mt-1 mb-4">
                                                <label for="exampleInputName1">Paid:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="exampleInputPassword4"
                                                    placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex notes">
                                            <div class="col-md-2 mt-1 mb-4">
                                                <label for="exampleInputName1">Due:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" id="exampleInputPassword4"
                                                    placeholder="">
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <label for="exampleInputName1">Notes</label>
                                                <textarea class="form-control" id="exampleTextarea1" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex">
                                            <div class="col-md-2 mt-1 mb-4">
                                                <label for="exampleInputName1">Payment Method:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-select form-control"
                                                    aria-label="Default select example">
                                                    <option selected>XYZ</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex">
                                            <div class="col-md-2 mt-1 mb-4">
                                                <label for="exampleInputName1">Bank:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-select form-control"
                                                    aria-label="Default select example">
                                                    <option selected>XYZ</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 mt-1">
                                                <label for="exampleInputEmail3">Cheque no:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" id="exampleInputPassword4"
                                                    placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex">
                                            <div class="col-md-2 mt-1 mb-4">
                                                <label for="exampleInputName1">Trx No:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="exampleInputPassword4"
                                                    placeholder="">

                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-primary mr-2 float-end"> Save
                                                </button>
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
</div>
{{-- </div> --}}
@include('admin.footer')
<!-- Plugin js for this page -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
    integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
</script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        getdata();
        //get data form expenses
        function getdata() {
            $.ajax({
                type: "GET",
                url: "{{ route('fetch-expense') }}",
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $('#expense_tbody').html('');
                    var i = 1
                    var total = 0;
                    $.each(response.expense, function(key, item) {
                        $('#expense_tbody').append(
                            '<tr>\
                         <td>' + i + '</td>\
                         <td>' + item.expense_category_name + '</td>\
                         <td style="overflow-x:scroll; max-width:200px;">' + item.notes + '</td>\
                         <td class="numeric" style="text-align: end;">' + item.amount + '</td>\
                         <td style="display:flex;justify-content:center;"><button value="' + item.expense_details_id +
                            '" id="edit_expense" class="btn mr-2 btn-dark btn-sm btn-icon-text" class="text-light"><i class="mdi mdi-tooltip-edit"></i> </button><button hidden value="' +
                            item.expense_details_id + '" id="delete_expense" class="btn btn-warning btn-sm btn-icon-text" class="text-light" ><i class="mdi mdi-delete"></i></button></td>\
                     </tr>'
                        );
                        i++;
                        total += parseFloat(item.amount);
                    });
                    let formattedTotal = total.toFixed(2);
                    $('#sum_amount').text(formattedTotal);
                    // console.log(total);
                }
            });
        }
        //edit Expense
        $(document).on('click', '#edit_expense', function(event) {
            event.preventDefault();
            var expense_details_id = $(this).val();
            $('#editExpense').modal('show');
            $.ajax({
                type: "GET",
                url: "edit-expense/" + expense_details_id,
                success: function(response) {
                    if (response.status == 200) {
                        $('#edit_notes').val(response.expenseDetails.notes);
                        $('#edit_expense').val(response.expense.expense_name);
                        $('#edit_amount').val(response.expenseDetails.amount);
                        $('#expenseDetailsId').val(response.expenseDetails
                            .expense_details_id);
                        $('#edit_expense_category').val(response.expenseCategory
                            .expense_category_id)
                    }
                }
            });
        });
        //update Expense
        $(document).on('click', '#update_expense', function(event) {
            event.preventDefault();
            var expenseDetailsId = $('#expenseDetailsId').val();
            var data = {
                'expense': $('#edit_expense').val(),
                'notes': $('#edit_notes').val(),
                'amount': $('#edit_amount').val(),
                'edit_expense_category': $('#edit_expense_category').val(),
            }
            console.log(data);
            $.ajax({
                type: "PUT",
                url: "update-expense/" + expenseDetailsId,
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.status == 400) {

                        $('#editExpense').modal('hide');

                        swal("Error", response.errors, "error");
                    } else {

                        $('#editExpense').modal('hide');
                        swal("Good job!", response.success, "success");
                        $('#expense').val(''),
                            $('#amount').val(''),
                            $('#notes').val('');
                        getdata() //call expenses function
                    }
                }
            });
        });
        //post ajax in expense
        $(document).on('click', '#add_expense', function(event) {
            event.preventDefault();
            var data = {
                'date': $('#date').val(),
                'expense': $('#expense').val(),
                'notes': $('#notes').val(),
                'expense_category_id': $('#expense_category_id').val(),
                'amount': $('#amount').val(),
            }

            $.ajax({
                type: "POST",
                url: "{{ route('expense') }}",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.status == 400) {
                        swal("Error", response.errors, "error");
                    } else {
                        swal("Good job!", response.success, "success");
                        $('#expense').val(''),
                            $('#expense_category_id').val(''),
                            $('#amount').val(''),
                            $('#notes').val('');
                        getdata() //call expenses function
                    }
                }
            });
        });
        $(document).on('click', '#delete_expense', function(event) {
            event.preventDefault();
            var expense_details_id = $(this).val();
            $.ajax({
                type: "GET",
                url: "delete-expense/" + expense_details_id,
                success: function(response) {
                    if (response.status == 200) {
                        swal("Good job!", response.delete, "success");
                        getdata() //call expenses function
                    }
                }
            });
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
