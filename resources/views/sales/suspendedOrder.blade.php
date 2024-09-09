@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120">
    <div class="content-wrapper">
        <div class="class=page-header d-flex justify-content-between align-items-center">
            <h3 class="page-title" style="margin-left: 20px">Suspended Orders</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Orders</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> Suspended Orders </li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Suspended Orders</h4>
                        <div class="custom-table-formatter">
                            <table id="example" class="table table-striped table-bordered">

                                <thead>
                                    <tr>
                                        <th>Order No</th>
                                        <th>Create on</th>
                                        <th>Delivery Man</th>
                                        <th>Served By</th>
                                        <th>Created By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($CartTemporary as $user)
                                        <tr>
                                            <td>{{ $user->temp_cart_id }}</td>
                                            <td>{{ $user->create_date }}</td>
                                            <td>{{ $user->table_no }}</td>
                                            <td>{{ $user->waiter_name }}</td>
                                            <td>{{ $user->created_by_name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
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
