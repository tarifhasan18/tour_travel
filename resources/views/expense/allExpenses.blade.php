@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120px">
    <div class="content-wrapper pb-0">
<!--Bank Section Start---->


<div class="card">
    <div class="card-body">
        {{-- @if ($user_data->role_id !== 4) --}}
        {{-- @if (0) --}}
            <div class="card-description d-flex justify-content-between"><a class="text-light btn btn-info" href="{{ route('expense')}}">Add Expense</a>
            <button id="newId" class="btn btn-outline-primary btn-sm">To Vat</button> </div>
        {{-- @endif --}}

        @if (session()->has('success'))
            <div class="alert alert-success">{{session()->get('success')}}</div>
        @endif

        @if (session()->has('update'))
            <div class="alert alert-success">{{session()->get('update')}}</div>
        @endif
      </p>
      <div class="table-responsive">
        <table id="cheack" class="table table-striped display">
          <thead>
            <tr>
              <th></th>
              <th>S.N</th>
              {{-- <th>Voucher No</th>
              <th>Expense Name</th> --}}
              <th>Expense Category</th>
              {{-- <th>Date</th> --}}
              {{-- @if ($user_data->role_id !==4)
              <th>Is Vat</th>
              @endif --}}
              <th class="text-end">Amount</th>
            </tr>
          </thead>
          <tbody>
            @foreach ( $expense as $data )
            <tr>
                <td value="{{$data->expense_id}}"></td>
                <td>{{$loop->index+1}}</td>
                {{-- <td>{{ $data->expense_id}}</td>
                <td>{{ $data->expense_name}}</td> --}}
                <td>{{ $data->expense_category_name}}</td>
                {{-- <td>{{ $data->date}}</td> --}}
                {{-- @if ($user_data->role_id !== 4)
                <td>@if ( $data->is_vat_show == 0)
                        No
                    @else
                        Yes
                    </td>
                    @endif
                @endif --}}


                <td class="text-end">{{ $data->amount}}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
              <th></th>
              <th>S.N</th>
              {{-- <th>Voucher No</th>
              <th>Expense Name</th> --}}
              <th>Expense Category</th>
              {{-- <th>Date</th> --}}
              <th class="text-end">Amount</th>
            </tr>
        </tfoot>

        </table>
      </div>
    </div>
  </div>



<!--Bank Section End---->
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function () {
        $(document).on('click', '#newId', function() {
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
                url: "all-expenses-vat-show",
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
