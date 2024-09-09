@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120px">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-2" style="margin-top: 45px; ">
                <div class="card">
                    <div class="card-title">
                        <h4 class="p-3 text-center">Edit Sub Category</h4><hr
                    </div>
                    <div class="card-body">

                      <form action="{{ url('update-subCat1') }}" method="post" enctype="multipart/form-data">
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
                        @foreach($subCategoryOne as $Category)
                          <input name="id" type="hidden" value="{{ $Category->sc_one_id}}">
                          <div class="form-group">
                              <label for="sub_cat1_name">Sub Category Name</label>
                              <input type="text" class="form-control my-2" name="sub_cat1_name" placeholder="Enter Sub Category Name" value="{{ $Category->sc_one_name }}">
                              <span class="text-danger">@error('sub_cat1_name'){{ $message }} @enderror</span>
                          </div>
                          <div class="form-group">
                              <label for="category_id">Select Category</label>
                              <select class="form-control my-2" name="category_id">
                                  <option selected="true" disabled="disabled">-----------Select----------</option>
                                  @foreach($Categories as $values)
                                  <option value="{{$values->category_id}}" {{ $Category->category_id == $values->category_id ? 'selected' : '' }}>{{$values->category_name}}</option>
                                  @endforeach
                              </select>
                              <span class="text-danger">@error('category_id'){{ $message }} @enderror</span>
                          </div>
                          <div class="form-group">
                              <label for="sc_one_image">Sample Image</label>
                              <input type="file" class="form-control my-2" name="sc_one_image" placeholder="Enter Sample Image" value="{{ $Category->sc_one_image }}">
                              <span class="text-danger">@error('sc_one_image'){{ $message }} @enderror</span>
                          </div>
                          <div class="form-group">
                              <label for="sub_cat1_status">Select Status</label>
                              <select class="form-control my-2" name="sub_cat1_status">
                                  <option selected="true" disabled="disabled">-----------Select----------</option>
                                  @if($Category->is_active==1)
                                  <option value="1" selected="selected">Active</option>
                                  <option value="0">Not Active</option>
                                  @else
                                  <option value="1">Active</option>
                                  <option value="0" selected="selected">Not Active</option>
                                  @endif
                              </select>
                              <span class="text-danger">@error('sub_cat1_status'){{ $message }} @enderror</span>
                          </div>

                          <div class="form-group">
                              <button type="submit" class="btn btn-warning my-2">Update</button>
                              <a class="btn btn-primary mt-2 float-right" class="text-light" href="{{url('all-subCat1')}}">Back</a>
                          </div>
                          <br>
                          @endforeach
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
