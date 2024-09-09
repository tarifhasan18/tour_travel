@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top:120px ">
    <div class="content-wrapper pb-0">
        <!--Expense Section Start---->
        <div class="card">
            <div class="card-body">
                <div class="card-description"><a class="text-light btn btn-info" href="{{ url('add-expense-category')}}">Add New Expense Category</a></div><br>

                @if (session()->has('success'))
                    <div class="alert alert-success">{{session()->get('success')}}</div>
                @endif

                @if (session()->has('update'))
                    <div class="alert alert-success">{{session()->get('update')}}</div>
                @endif

                <div class="table-responsive">
                    <table id="cheack" class="table table-striped display">
                        <thead>
                            <tr >
                                <th>S.N</th>
                                <th>Expense Category Name</th>
                                <th>Default</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $all_expense_category_datas  as $item )
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{ $item->expense_category_name}}</td>
                                @if ($item->is_default==1)
                                    <td>Default</td>
                                @else
                                    <td>Not Default</td>
                                @endif
                                @if ($item->is_active==1)
                                    <td>Active</td>
                                @else
                                    <td>Disabled</td>
                                @endif
                                <td>
                                    @if ($item->is_default != 1)
                                        <a class="btn btn-warning" class="text-light" href="{{url('edit-expense-category',$item->expense_category_id)}}">Edit</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--Expense Section End---->
    </div>
</div>

{{-- </div> --}}

@include('admin.footer')
