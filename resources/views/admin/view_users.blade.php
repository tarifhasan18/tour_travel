<!DOCTYPE html>
<html lang="en">
  <head>
   @include('admin.links')
   <style>
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
    a{
        border-radius: 10px;
    }
    .search_container{
        display: flex;
        justify-content: right;
        align-items: right;
    }
    .search_box{
        padding: 10px;
        width: 350px;
        border: 1px solid black;
    }
    .tour_packages{
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
                <h1>All Users</h1>
            </div>
            <div class="tour_packages">
                <table>
                    <tr>
                        <th>Username</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>User Type</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($user_data as $users )
                    <tr>
                        <td>{{$users->name}}</td>
                        <td>{{$users->phone}}</td>
                        <td>{{$users->email}}</td>
                        <td>{{$users->address}}</td>
                        <td>{{$users->usertype}}</td>
                        <td>
                            <a class="btn btn-primary" href="{{url('edit_users',$users->id)}}">Edit</a>
                            <a class="btn btn-danger" href="{{url('remove_users',$users->id)}}">Remove</a>
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
