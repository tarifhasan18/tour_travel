@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120px">
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
                    <div class="card-title">
                        <h4 class="p-3 text-center">Edit  Salary Type</h4>
                        <hr>
                    </div>
                    <div class="card-body">

                      <form action="{{url('salary-type-update',$findsalaryType->salary_type_id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                         <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Salary Type Name:</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control my-2" name="salary_type_name" placeholder="Salary Type Name" value="{{$findsalaryType->salary_type_name}}" required="">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                  <select required="" class="form-control mt-2" name="is_active">
                                    <option value="" selected="true" disabled="disabled">-----------Select----------</option>
                                    @if ($findsalaryType->is_active==1)
                                    <option selected="" value="1">Active</option>
                                    <option  value="0">Deactive</option>
                                    @else
                                    <option  value="1">Active</option>
                                    <option selected="" value="0">Deactive</option>
                                    @endif

                                </select>
                                </div>
                              </div>
                            </div>

                          </div>

                          <div class="form-group ">
                            <a class="btn btn-primary mt-2 float-right" href="{{url('salary-type')}}">Back</a>
                            <button type="submit" class="btn btn-primary mt-2">Submit</button>
                          </div>

                          <br>
                      </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>


@include('admin.footer')

