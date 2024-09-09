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
        margin: 5px;
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
            <form action="{{url('submit_our_services')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form_items">
                    <label for="">Service Name</label>
                    <input type="text" name="name" placeholder="Write Service Name" required>
                </div>

                <div class="form_items">
                    <label for="">Service Image</label>
                    <input type="file" name="image" required>
                </div>

                <div class="form_items">
                    <label for="">Service Description</label>
                   <textarea name="description" required placeholder="Write Service Description"></textarea>
                </div>

                <div class="form_items">
                    <input class="btn btn-primary" type="submit" value="Add Services">
                </div>
            </form>
        </div>
        <div class="service_list">
            <table>
                <tr>
                    <th>Service Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                @foreach($data as $services)
                <tr>
                    <td>{{$services->name}}</td>
                    <td>{{$services->description}}</td>
                    <td>
                        <img width="200px" height="140px" src="{{asset('tour_image/'.$services->image)}}" alt="">
                    </td>
                    <td>
                        <a class="btn btn-primary btn-block" href="{{url('edit_service',$services->id)}}">Edit</a>
                        <a class="btn btn-danger btn-block" href="{{url('delete_service',$services->id)}}">Delete</a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        </div>
       </div>

        @include('admin.footer')
  </body>
</html>
