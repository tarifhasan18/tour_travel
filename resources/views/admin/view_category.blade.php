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
    .action-cell {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px; /* Optional: to add space between buttons */
}
    tr:nth-child(even){background-color: #e0dede}
    tr:nth-child(even):hover{background-color: ; cursor: pointer;color: }
    tr:nth-child(odd):hover{background-color: ; cursor: pointer;color: }
    /* a{
        border-radius: 10px;
        float: left;
        display: inline-block;
        width: 70px;
        margin: 2px;
    } */
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
    .inventory_categories{
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
            <div style="margin-top: 20px">
                <h1>All Inventory Categories</h1>
            </div>

            <div class="search_container">
                <form action="{{url('search_category')}}" method="get">
                  @csrf
                  <input class="search_box" type="text" name="search" placeholder="Search Here" required>
                  <input class="btn btn-primary" type="submit" value="Search">
                </form>
            </div>
            <div class="inventory_categories">
                <table>
                    <tr>
                        <th>Category Name</th>
                        <th>Action</th>
                    </tr>
                    @foreach($data as $categories)
                    <tr>
                        <td>{{ $categories->category_name}}</td>
                        <td class="action-cell">
                            <a  class="btn btn-primary" href="{{url('edit_category',$categories->id)}}">Edit</a>
                            <a  class="btn btn-danger" href="{{url('delete_category',$categories->id)}}">Delete</a>
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
