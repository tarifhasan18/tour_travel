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
    input[type='text'],input[type='number'], input[type='email'],select
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
            <h2>Update User Information</h1>
        </div>
        <div class="update_our_services">
            <form action="{{url('update_users',$data->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form_items">
                    <label for="">User Name</label>
                    <input type="text" name="name" value="{{$data->name}}">
                </div>

                <div class="form_items">
                    <label for="">Email</label>
                    <input type="email" name="email" value="{{$data->email}}">
                </div>

                <div class="form_items">
                    <label for="">Phone</label>
                    <input type="number" name="phone" value="{{$data->phone}}">
                </div>

                <div class="form_items">
                    <label for="">Address</label>
                    <input type="text" name="address" value="{{$data->address}}">
                </div>
                <div class="form_items">
                    <label for="">Current User Type</label>
                    <label for="">{{$data->usertype}}</label>
                </div>

                <div class="form_items">
                    <label for="">Change User Type</label>
                    <select name="usertype" id="">
                        <option value="">Select User Type</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="form_items">
                    <input class="btn btn-primary" type="submit" value="Update users">
                </div>
            </form>
        </div>
        </div>
       </div>

        @include('admin.footer')
  </body>
</html>
