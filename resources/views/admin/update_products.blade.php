<!DOCTYPE html>
<html lang="en">
  <head>
   @include('admin.links')
   <style>
        label{
           display: inline-block;
           width: 200px;
           font-weight: bold;
       }
       .update_product{
           display: flex;
           justify-content: center;
           align-items: center;
           margin-top: 40px;
       }
       input[type='text'],input[type='number'], select
       {
            width: 500px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
       }
       input[type='date']
       {
           width: 300px;
           height: 50px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;

       }
       .form_items{
           margin-top: 20px;
       }
       textarea{
            width: 500px;
            height: 100px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
            vertical-align: middle;
       }
   </style>

  </head>
  <body>

      <!-- Sidebar -->
       @include('admin.sidebar')

       @include('admin.navbar')

       <div class="container">
        <div class="page-inner">
        <div>
            <h1>Update Product Information</h1>
        </div>
        <div class="update_product">
            <form action="{{url('update_product',$products->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="">Product Name</label>
                    <input type="text" name="product_name" value="{{$products->product_name}}" required>
                </div>

                <div class="form_items">
                    <label for="">Product Category</label>
                    <select name="category_id" id="" required>
                        <option value="">Choose Product Category</option>
                        @foreach ($categories as $category)
                        {{-- <option value="{{$product->unitType->unit_name }}">{{$product->unitType->unit_name }}</option> --}}
                        <option value="{{ $category->id }}" {{ $products->category_id == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form_items">
                    <label for="">Product Details</label>
                    {{-- <input type="text" name="product_details" value="{{$data->product_details}}" required> --}}
                    <textarea name="product_details" id="">{{$products->product_details}}</textarea>
                </div>
                <div class="form_items">
                    <label for="">Unit Type</label>
                    <select name="unit_id" id="" required>
                        <option value="">Choose an Unit</option>
                        @foreach ($units as $unit)
                        {{-- <option value="{{$product->unitType->unit_name }}">{{$product->unitType->unit_name }}</option> --}}
                        <option value="{{ $unit->id }}" {{ $products->unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->unit_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form_items">
                    <input class="btn btn-primary" type="submit" value="Add Package">
                </div>
            </form>
        </div>
        </div>
       </div>
        @include('admin.footer')
  </body>
</html>
