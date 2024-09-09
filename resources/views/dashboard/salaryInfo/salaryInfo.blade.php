@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')

{{-- Modal For Add Salary  Type Start --}}
<div class="modal fade" id="salary-info-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Salary Info</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('salary-info-add')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Employee Name</label>
                            <select class="form-control" name="back_office_login_id" required id="exampleFormControlSelect1">
                              <option disabled selected value="">----Select Employee Name---</option>
                              @foreach ($getBackOfficeEmployee as $getBackOfficeEmployees)
                              <option  value="{{$getBackOfficeEmployees->login_id}}">{{ $getBackOfficeEmployees->full_name}}-Employee ID ({{ $getBackOfficeEmployees->office_user_id}})</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Salary Type</label>
                            <select class="form-control" name="salary_type_id" required id="exampleFormControlSelect1">
                              <option disabled selected value="">----Select Salary Type---</option>
                              @foreach ($getsalaryType as $getsalaryTypes)
                              <option  value="{{$getsalaryTypes->salary_type_id}}">{{ $getsalaryTypes->salary_type_name}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Salary Amount</label>
                            <input type="number" min="0" required class="form-control" value="0" name="salary_amount" id="exampleFormControlInput1" placeholder="Salary Amount">
                        </div>
                    </div>
                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Due</label>
                            <input type="number" min="0" required class="form-control" value="0" name="due" id="exampleFormControlInput1" placeholder="Due">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Paid</label>
                            <input type="number" min="0" required class="form-control" value="0" name="paid" id="exampleFormControlInput1" placeholder="paid">
                        </div>
                    </div> --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Status</label>
                            <select class="form-control" name="is_active" required id="exampleFormControlSelect1">
                              <option value="">Select Salary Type</option>
                              <option selected value="1">Active</option>
                              <option value="0">Deactive</option>
                            </select>
                        </div>
                    </div>
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

<div class="main-panels" style="padding-top: 120px">
    <div class="content-wrapper">
        <div class="page-header justify-content-between">
            <h3 class="page-title ml-4">Salary Info</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mr-4">
                    <li class="breadcrumb-item"><a href="#">Salary Info</a></li>
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
                        <button data-toggle="modal" data-target="#salary-info-modal" class="btn btn-outline-primary btn-sm">Add Salary Info</button>
                     </div>
                    <div class="card-body">
                        <h4 class="card-title text-center">Salary Information</h4>
                        <div class="custom-table-formatter table-responsive">
                            <table id="example" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Employee</th>
                                        <th>Salary Type</th>
                                        <th class="text-end">Salary Amount</th>
                                        <th class="text-end">Due</th>
                                        <th class="text-end">Paid</th>
                                        <th class="text-center">Status</th>
                                        <!--<th>Action</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($getSalaryInfo as $getSalaryInfos)
                                    <tr>
                                        <td >{{$loop->index+1}}</td>
                                        <td >{{ $getSalaryInfos->full_name }}({{ $getSalaryInfos->office_user_id }})</td>
                                        <td >{{ $getSalaryInfos->salary_type_name }}</td>
                                        <td class="text-end">{{ $getSalaryInfos->salary_amount }}</td>
                                        <td class="text-end">{{ $getSalaryInfos->due }}</td>
                                        <td class="text-end">{{ $getSalaryInfos->paid }}</td>
                                        <td class="text-center">
                                            @if ($getSalaryInfos->is_active==1)
                                                <span class="badge badge-pill badge-success">Active</span>
                                            @else
                                                <span class="badge badge-pill badge-danger">Deactive</span>
                                            @endif
                                        </td>
                                        {{-- <!--<td><a href="{{route('backoffice.salary-info-edit',encrypt($getSalaryInfos->salary_info_id))}}" class="btn btn-outline-primary">Edit</a></td>--> --}}
                                    </tr>

                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                      <th>Unit Name</th>
                                      <th>Unit Symbol</th>
                                      <th>Is Fractional</th>
                                      <th>Status</th>
                                      <th>Action</th>
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
