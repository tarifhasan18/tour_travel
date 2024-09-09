@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120px">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="margin-top: 45px; ">
                <div class="card">
                    <div class="card-title">
                        <h4 class="p-3 text-center">Add Item</h4>
                        <hr>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('create-product') }}" method="post"
                            enctype="multipart/form-data">
                            @if (Session::get('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                            @endif

                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="product_name">Item Name</label>
                                                <input type="text" class="form-control my-2"
                                                    name="product_name" placeholder="Enter Product Name"
                                                    value="{{ old('product_name') }}" required="required">
                                                <span class="text-danger">
                                                    @error('product_name')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="unit_type">Select Unit Type</label>
                                                <select class="form-control my-2" name="unit_type"
                                                    required="required">
                                                    <option selected="true" disabled="disabled">
                                                        ----------Select---------</option>
                                                    @foreach ($UnitDefinition as $values)
                                                        <option value="{{ $values->unit_id }}">
                                                            {{ $values->unit_name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    @error('unit_type')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="sc_one_id">Product Sub Category</label>
                                                <select class="form-control my-2" name="sc_one_id"
                                                    required="required">
                                                    <option selected="true" disabled="disabled">
                                                        ----------Select---------
                                                    </option>
                                                    @foreach ($subCategoryOne as $sc1)
                                                        <option value="{{ $sc1->sc_one_id }}">
                                                            {{ $sc1->sc_one_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    @error('sc_one_id')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="images" class="form-label">Upload Product
                                                    Images:</label>
                                                <input type="file" name="images[]" accept="image/*"
                                                    class="form-control" multiple>
                                                <span class="text-danger">
                                                    @error('images')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="status">Select Status</label>
                                                <select class="form-control my-2" name="status"
                                                    required="required">
                                                    <option selected="true" disabled="disabled">
                                                        -----------Select----------</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Not Active</option>
                                                </select>
                                                <span class="text-danger">
                                                    @error('status')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="product_name">Bar Code</label>
                                                <input type="text" class="form-control my-2"
                                                    name="product_bar_code" placeholder="Enter Bar Code"
                                                    value="{{ old('product_bar_code') }}">
                                                <span class="text-danger">
                                                    @error('product_bar_code')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pt-5">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <a class="btn btn-primary mt-2" class="text-light"
                                                    href="{{ url('all-products') }}">Back</a>
                                                <button type="submit"
                                                    class="btn btn-primary mt-2 float-right">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
</div>
{{-- @include('admin.footer') --}}
