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
       .update_unit{
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
            <h1>Update Product Unit Information</h1>
        </div>
        <div class="update_unit">
            <form action="{{url('update_unit',$units->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="">Product Unit Name</label>
                    <input type="text" name="unit_name" value="{{$units->unit_name}}" required>
                </div>
                <div class="form_items">
                    <input class="btn btn-primary" type="submit" value="Update Unit">
                </div>
            </form>
        </div>
        </div>
       </div>
        @include('admin.footer')


  </body>
</html>
