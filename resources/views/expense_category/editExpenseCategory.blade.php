@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')

<div class="main-panels" style="padding-top: 120px">
    <div class="content-wrapper pb-0">


<!--Expense Section Start---->




<div class="card">
    <div class="card-title">
        <h4 class="p-3 text-center">Edit  Expense Category</h4>
        <hr>
    </div>
    <div class="card-body">

      <form action="{{url('update-expense-category',$getdatas->expense_category_id)}}" method="post" enctype="multipart/form-data">

        @if (session()->has('updatefail'))

        <div class="alert alert-danger">{{session()->get('updatefail')}}</div>

        @endif

        @csrf
        @method('put')
         <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Category Name:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control my-2" name="expense_category_name" placeholder="Enter Expense Category Name" value="{{$getdatas->expense_category_name	}}" required>
                </div>
              </div>
            </div>
            {{-- <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Select Default</label>
                <div class="col-sm-9">
                  <select required class="form-control mt-2" name="is_default">
                    <option value="" selected="true" disabled="disabled">-----------Select----------</option>
                    <option @if ($getdatas->is_default==1) selected @endif value="1">Default</option>
                    <option @if ($getdatas->is_default==0) selected @endif value="0">Not Default</option>
                </select>
                </div>
              </div>
            </div> --}}
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Select Action</label>
                <div class="col-sm-9">
                  <select required class="form-control my-2" name="is_active">
                    <option value="" selected="true" disabled="disabled">-----------Select----------</option>
                    <option @if ($getdatas->is_active==1) selected @endif value="1">Active</option>
                    <option @if ($getdatas->is_active==0) selected @endif value="0">Not Active</option>
                </select>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
              <button type="submit" class="btn btn-primary mt-2">Submit</button>
              <a class="btn btn-primary mt-2 float-right" class="text-light" href="{{ url('expense_category_list') }}">Back</a>
          </div>

          <br>
      </form>
    </div>

</div>






<!--Expense Section End---->
</div>

</div>
{{-- @include('admin.footer') --}}
