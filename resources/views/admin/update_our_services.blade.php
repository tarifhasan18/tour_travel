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
    .update_our_services{
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
    textarea{
         width: 500px;
         height: 100px;
         padding: 12px;
         border: 1px solid #ccc;
         border-radius: 4px;
         resize: vertical;
         vertical-align: middle;

    }
    table {
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
      border: 1px solid #ddd;
    }
    th{
        text-align: center;
        padding: 8px;
        background: #2c3e50;
        color:  white;

    }

    td {
      text-align: center;
      padding: 8px;
    }

    tr:nth-child(even){background-color: #e0dede}
    tr:nth-child(even):hover{background-color: ; cursor: pointer;color: }
    tr:nth-child(odd):hover{background-color: ; cursor: pointer;color: }
    .service_list{
        margin-top: 40px;
    }
    a{
        border-radius: 10px;
        margin-top: 10px;
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
            <h2>Update Our Services Page</h1>
        </div>
        <div class="update_our_services">
            <form action="{{url('update_our_services',$data->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form_items">
                    <label for="">Service Name</label>
                    <input type="text" name="name" value="{{$data->name}}">
                </div>

                <div class="form_items">
                    <label for="">Service Description</label>
                   <textarea name="description">{{$data->description}}</textarea>
                </div>

                <div class="form_items">
                    <label for="">Service Description</label>
                    <img width="200px" height="140px" src="{{asset('tour_image/'.$data->image)}}" alt="">
                </div>

                <div class="form_items">
                    <label for="">Update Image</label>
                    <input type="file" name="image">
                </div>

                <div class="form_items">
                    <input class="btn btn-primary" type="submit" value="Update Services">
                </div>
            </form>
        </div>
        </div>
       </div>

        @include('admin.footer')
  </body>
</html>
