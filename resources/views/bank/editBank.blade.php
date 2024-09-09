@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120px">
    <div class="content-wrapper pb-0">

<!--Bank Section Start---->

<div class="card">
    <div class="card-title">
        <h4 class="p-3 text-center">Edit Bank</h4>
        <hr>
    </div>
    <div class="card-body">

      <form action="{{route('update-bank',$getdatas->bank_id)}}" method="post" enctype="multipart/form-data">

        @if (session()->has('updatefail'))

        <div class="alert alert-danger">{{session()->get('updatefail')}}</div>

        @endif

        @csrf
        @method('put')
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Bank Name:</label>
                <div class="col-sm-9">
                  <input required type="text" class="form-control" name="bank_name" placeholder="Enter Bank Name" value="{{$getdatas->bank_name}}">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Select Status</label>
                <div class="col-sm-9">
                  <select  class="form-control" name="is_active" required>
                    <option value=""  selected="true" disabled="disabled">-----------Select----------</option>
                    <option @if ($getdatas->is_active==1) selected @endif value="1">Active</option>
                    <option @if ($getdatas->is_active==0) selected @endif value="0">Not Active</option>
                </select>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
              <a class="btn btn-primary mt-2" class="text-light" href="{{route('bank_list')}}">Back</a>
              <button type="submit" class="btn btn-warning mt-2 float-right">Update</button>
          </div>

          <br>
      </form>
    </div>

</div>






<!--Bank Section End---->
</div>

</div>


@include('admin.footer')
