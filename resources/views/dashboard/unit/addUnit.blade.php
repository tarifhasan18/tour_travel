@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120px">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-2" style="margin-top: 45px; ">
                <div class="card">
                    <div class="card-title">
                        <h4 class="p-3 text-center">Add New Unit</h4>
                        <hr
                    </div>
                    <div class="card-body">

                      <form action="{{ url('create-unit') }}" method="post">
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

                        @csrf
                          <div class="form-group">
                              <label for="unit_name">Unit Name</label>
                              <input type="text" class="form-control my-2" name="unit_name" placeholder="Enter Unit Name" value="{{ old('unit_name') }}">
                              <span class="text-danger">@error('unit_name'){{ $message }} @enderror</span>
                          </div>

                          <div class="form-group">
                              <label for="unit_symbol">Unit Symbol</label>
                              <input type="text" class="form-control my-2" name="unit_symbol" placeholder="Enter Unit Symbol" value="{{ old('unit_symbol') }}">
                              <span class="text-danger">@error('unit_symbol'){{ $message }} @enderror</span>
                          </div>

                          <div class="form-group">
                              <label for="is_fractional">Is Fractional</label>
                              <select class="form-control my-2" name="is_fractional">
                                  <option selected="true" disabled="disabled">-----------Select----------</option>
                                  <option value="1">Yes</option>
                                  <option value="0">No</option>
                              </select>
                              <span class="text-danger">@error('is_fractional'){{ $message }} @enderror</span>
                          </div>

                          <div class="form-group">
                              <label for="is_active">Select Status</label>
                              <select class="form-control my-2" name="is_active">
                                  <option selected="true" disabled="disabled">-----------Select----------</option>
                                  <option value="1">Active</option>
                                  <option value="0">Not Active</option>
                              </select>
                              <span class="text-danger">@error('is_active'){{ $message }} @enderror</span>
                          </div>

                          <div class="form-group">
                              <button type="submit" class="btn btn-primary mt-2">Submit</button>
                              <a class="btn btn-primary mt-2 float-right" class="text-light" href="{{url('all-unit')}}">Back</a>
                          </div>

                          <br>
                      </form>
                    </div>

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
