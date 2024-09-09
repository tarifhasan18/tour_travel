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
       .add_product{
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
            <h2>Add Inventory Products</h1>
        </div>
        <div class="add_product">
            <form action="{{url('submit_product')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form_items">
                    <label for="">Select a Product Category</label>
                    <select name="category_id" id="" required>
                        <option value="">Choose a Category</option>
                        @foreach ($category as $categories)
                        <option value="{{$categories->id}}">{{$categories->category_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form_items">
                    <label for="">Inventory product Name</label>
                    <input type="text" name="product_name" placeholder="Inventory product Name" required>
                </div>
                <div class="form_items">
                    <label for="">Product Details</label>
                    <textarea name="product_details" id="" placeholder="Write here.."></textarea>
                </div>
                <div class="form_items" >
                    <label for="">Select Unit Type</label>
                    <select name="unit_id" id="" required>
                        <option value="">Choose an Unit</option>
                        @foreach ($units as $unit)
                        <option value="{{$unit->id}}">{{$unit->unit_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form_items">
                    <input class="btn btn-primary" type="submit" value="Add Product">
                </div>
            </form>
        </div>
        </div>
       </div>
@include('admin.footer')
  </body>
</html>
