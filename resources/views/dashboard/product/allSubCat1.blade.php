@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120px">
    <div class="content-wrapper">
        <div class="page-header justify-content-between">
            <h3 class="page-title ml-4">All Categories</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mr-4">
                    <li class="breadcrumb-item"><a href="#">All Categories</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> All Sub Category</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="card-description btn btn-info"><a class="text-light"
                                href="{{ url('sub-cat1') }}">Add Sub Category</a></div>
                        <h4 class="card-title text-center">Sub Category Table</h4>
                        <div class="table-responsive custom-table-formatter">
                            <table id="example" class="table table-striped table-bordered">

                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Sample Image</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($SubCategoryOne as $values)
                                        <tr>
                                            <td>{{ $values->sc_one_name }}</td>
                                            <td>{{ $values->category_name }}</td>
                                            <td>
                                                <a target="_blank" href="{{ $values->sc_one_image_path }}">
                                                    <img height="30px" width="30px"
                                                        src="{{ $values->sc_one_image_path }}">
                                                </a>

                                            </td>
                                            @if ($values->is_active == 1)
                                                <td>Active</td>
                                            @else
                                                <td>Not Active</td>
                                            @endif

                                            <td><a class="btn btn-warning" class="text-light"
                                                    href="{{ url('edit-subCat1', Crypt::encryptString($values->sc_one_id)) }}">Edit</a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Sample Image</th>
                                        <th>Status</th>
                                        <th>Action</th>
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
