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
    .add_category{
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 40px;
    }
    input[type='text']
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
</style>
  </head>
  <body>

      <!-- Sidebar -->
       @include('admin.sidebar')

       @include('admin.navbar')
       <div class="container">
        <div class="page-inner">
        <div>
            <h2>Add Inventory Category</h1>
        </div>
        <div class="add_category">
            <form action="{{url('submit_category')}}" method="POST">
                @csrf
                <div>
                    <label for="">Inventory Category Name</label>
                    <input type="text" name="category" placeholder="Inventory Category Name" required>
                </div>
                <div class="form_items">
                    <input class="btn btn-primary" type="submit" value="Add Category">
                </div>
            </form>
        </div>
        </div>
       </div>

        @include('admin.footer')
  </body>
</html>
