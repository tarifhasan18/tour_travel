@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
{{-- Modal For Add Salary  Type Start --}}
<div class="modal fade" id="salary-type-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Salary Type</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{url('salary-type-add')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label for="exampleFormControlInput1">Salary Type Name</label>
                  <input type="text" required class="form-control" name="salary_type_name" id="exampleFormControlInput1" placeholder="Salary Type Name">
                </div>
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Status</label>
                  <select class="form-control" name="is_active" required id="exampleFormControlSelect1">
                    <option value="">Select Salary Type</option>
                    <option selected value="1">Active</option>
                    <option value="0">Deactive</option>
                  </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                  </div>
              </form>
        </div>

      </div>
    </div>
  </div>
{{-- Modal For Add Salary  Type End --}}

<div class="main-panels" style="padding-top: 120px;">
    <div class="content-wrapper">
        <div class="page-header justify-content-between">
            <h3 class="page-title ml-4">Salary Type</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mr-4">
                    <li class="breadcrumb-item"><a href="#">Salary Type</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Home </li>
                </ol>
            </nav>
        </div>
        @if (session()->has('success'))
        <div class="alert alert-info" role="alert">
            <strong>{{session()->get('success')}}</strong>
          </div>
        @endif
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="text-end mt-3 mr-4">
                        <button data-toggle="modal" data-target="#salary-type-modal" class="btn btn-outline-primary btn-sm">Add Salary Type</button>
                     </div>
                    <div class="card-body">
                        <h4 class="card-title text-center">Salary type</h4>
                        <div>
                            <table id="cheack" class="table table-bordered">

                                <thead>
                                    <tr>

                                        <th>SL</th>
                                        <th>Salary Type Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($salaryTypes as $salaryType)
                                    <tr>
                                        <td >{{$loop->index+1}}</td>
                                        <td >{{ $salaryType->salary_type_name }}</td>
                                        <td >@if ($salaryType->is_active==1)
                                            <span class="badge badge-pill badge-success">Active</span>
                                        @else
                                        <span class="badge badge-pill badge-danger">Deactive</span>
                                        @endif</td>
                                        <td><a href="{{url('salary-type-edit',encrypt($salaryType->salary_type_id))}}" class="btn btn-outline-primary">Edit</a></td>
                                    </tr>

                                    @endforeach
                                </tbody>
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
