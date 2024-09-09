@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120px">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-2" style="margin-top: 45px; ">
                <div class="card">
                    <div class="card-title">
                        <h4 class="p-3 text-center">Add Product Category</h4><hr
                    </div>
                    <div class="card-body">

                      <form action="{{ url('create-cat') }}" method="post" autocomplete="off" enctype="multipart/form-data">
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
                              <label for="name">Category Name</label>
                              <input type="text" class="form-control my-2" name="cat_name" placeholder="Enter Category Namee" value="{{ old('cat_name') }}">
                              <span class="text-danger">@error('cat_name'){{ $message }} @enderror</span>
                          </div>
                          <div class="form-group">
                              <label for="sample_image">Sample Image</label>
                              <input type="file" class="form-control my-2" name="sample_image" placeholder="Enter Sample Image">
                              <span class="text-danger">@error('sample_image'){{ $message }} @enderror</span>
                          </div>
                          <div class="form-group">
                              <label for="status">Select Status</label>
                              <select class="form-control my-2" name="status">
                                  <option selected="true" disabled="disabled">-----------Select----------</option>
                                  <option value="1">Active</option>
                                  <option value="0">Not Active</option>
                              </select>
                              <span class="text-danger">@error('status'){{ $message }} @enderror</span>
                          </div>

                          <div class="form-group">
                              <a class="btn btn-primary mt-2" class="text-light" href="{{url('all-product-cat')}}">Back</a>
                              <button type="submit" class="btn btn-primary my-2 float-right">Submit</button>
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
