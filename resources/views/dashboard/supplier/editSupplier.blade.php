@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120px">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-2" style="margin-top: 45px; ">
                <div class="card">
                    <div class="card-title">
                        <h4 class="p-3 text-center">Edit Supplier</h4>
                        <hr
                    </div>
                    <div class="card-body">

                      <form action="{{ url('update-supplier') }}" method="post">

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

                          @foreach($Supplier as $values)

                          <input name="id" value="{{$values->supplier_id}}" type="hidden">
                          <div class="form-group">
                              <label for="supplier_name">Supplier Name</label>
                              <input type="text" class="form-control my-2" name="supplier_name" placeholder="Enter Supplier Name" value="{{ $values->supplier_name }}">
                              <span class="text-danger">@error('supplier_name'){{ $message }} @enderror</span>
                          </div>

                          <div class="form-group">
                              <label for="supplier_address">Supplier Address</label>
                              <input type="text" class="form-control my-2" name="supplier_address" placeholder="Enter Supplier Address" value="{{ $values->supplier_address }}">
                              <span class="text-danger">@error('supplier_address'){{ $message }} @enderror</span>
                          </div>

                          <div class="form-group">
                              <label for="supplier_contact_person">Supplier Contact Person</label>
                              <input type="text" class="form-control my-2" name="supplier_contact_person" placeholder="Supplier Contact Person" value="{{ $values->supplier_contact_person }}">
                              <span class="text-danger">@error('supplier_contact_person'){{ $message }} @enderror</span>
                          </div>

                          <div class="form-group">
                              <label for="supplier_contact_no">Supplier Contact No</label>
                              <input type="text" class="form-control my-2" name="supplier_contact_no" placeholder="Supplier Contact No" value="{{ $values->supplier_contact_no }}">
                              <span class="text-danger">@error('supplier_contact_no'){{ $message }} @enderror</span>
                          </div>

                          <div class="form-group">
                              <label for="is_active">Select Status</label>
                              <select class="form-control my-2" name="is_active">
                                  <option selected="true" disabled="disabled">-----------Select----------</option>
                                  @if($values->is_active==1)
                                  <option value="1" selected="selected">Active</option>
                                  <option value="0">Not Active</option>
                                  @else
                                  <option value="1">Active</option>
                                  <option value="0" selected="selected">Not Active</option>
                                  @endif
                              </select>
                              <span class="text-danger">@error('is_active'){{ $message }} @enderror</span>
                          </div>

                          <div class="form-group">
                              <a class="btn btn-primary mt-2" class="text-light" href="{{url('all-suppliers')}}">Back</a>
                              <button type="submit" class="btn btn-primary mt-2 float-right">Submit</button>

                          </div>
                          @endforeach
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
