@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120px">
    <div class="content-wrapper">
        <div class="page-header justify-content-between">
            <h3 class="page-title ml-4">All Items</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mr-4">
                    <li class="breadcrumb-item"><a href="#">Iten</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> All Items </li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="card-description btn btn-info"><a class="text-light"
                                href="{{ url('product') }}">Add item</a></div>
                        <h4 class="card-title text-center">Item List</h4>
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
                        <div class="custom-table-formatter" style="overflow-x:scroll;">
                            <table id="example" class="table table-striped table-bordered">

                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Product Sub Category</th>
                                        <th>Unit</th>
                                        <th>Barcode</th>
                                        <th>Action</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Product as $values)
                                        <tr>
                                            <td>
                                                <div class="row" style="width: 200px;">
                                                    <div class="col-12 text-truncate">
                                                        {{ $values->product_name }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $values->sc_one_name }}</td>
                                            <td>{{ $values->unit_name }}</td>
                                            <td>
                                                @if ($values->barcode == null)
                                                    <a class="btn" class="text-light"
                                                        href="{{ url('create-barcode', Crypt::encryptString($values->product_id)) }}"><i
                                                            class="fa fa-barcode"></i></a>
                                                @else
                                                    <a target="_blank" class="brn"
                                                        href="{{ url('print-barcode', Crypt::encryptString($values->product_id)) }}"><img
                                                            style="margin-left:10px; height:29px; width:30px"
                                                            src="{{ asset('backend/printer.webp') }}"
                                                            alt="print"></a>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn" class="text-light"
                                                    href="{{ url('edit-product', Crypt::encryptString($values->product_id)) }}"><i
                                                        class="fa fa-edit"></i></a>
                                            </td>
                                            @if ($values->is_active == 1)
                                                <td>Active</td>
                                            @else
                                                <td>Not Active</td>
                                            @endif

                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Product Sub Category</th>
                                        <th>Unit</th>
                                        <!--<th>Barcode</th>-->
                                        <th>Action</th>
                                        <th>Status</th>
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
