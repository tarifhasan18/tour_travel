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
    .add_users{
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 40px;
    }
    input[type='text'],input[type='number'], input[type='password'],input[type='email'],select
    {
         width: 500px;
         padding: 12px;
         border: 1px solid #ccc;
         border-radius: 4px;
         resize: vertical;
         margin-top: 10px;
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
        <h2>Add Users</h1>
        </div>
    <div class="add_users">
        <form action="{{url('submit_users')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="">User Name</label>
                <input type="text" name="name" placeholder="Username" required>
            </div>
            <div>
                <label for="">User Phone</label>
                <input type="number" name="phone" placeholder="Phone Number" required>
            </div>
            <div class="form_items">
                <label for="">Email</label>
                <input type="email" name="email" placeholder="Email Address" required>
            </div>
            <div>
                <label for="">User Address</label>
                <input type="text" name="address" placeholder="User Address" required>
            </div>
            <div class="form_items">
                <label for="">Password</label>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="form_items">
                <label for="">User Type</label>
                <select name="usertype" id="">
                    <option value="user" selected>User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form_items">
                <input class="btn btn-primary" type="submit" value="Add Admin">
            </div>
        </form>
    </div>
        </div>
       </div>
        @include('admin.footer')
  </body>
</html>
