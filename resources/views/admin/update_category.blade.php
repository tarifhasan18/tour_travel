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
       .update_packages{
           display: flex;
           justify-content: center;
           align-items: center;
           margin-top: 40px;
       }
       input[type='text'],input[type='number']
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
            <h1>Update Inventory Category Information</h1>
        </div>
        <div class="update_packages">
            <form action="{{url('update_category',$data->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="">Inventory Category Name</label>
                    <input type="text" name="category_name" value="{{$data->category_name}}" required>
                </div>
                <div class="form_items">
                    <input class="btn btn-primary" type="submit" value="Update Category">
                </div>
            </form>
        </div>
        </div>
       </div>
        @include('admin.footer')
  </body>
</html>
