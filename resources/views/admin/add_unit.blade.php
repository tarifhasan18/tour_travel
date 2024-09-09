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
    .add_unit{
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
    table {
      border-collapse: collapse;
      border-spacing: 0;
      width: 70%;
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
    .inventory_units{
        margin-top: 20px;
        display: flex;
        justify-content:center;
        align-content: center;
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
            <h2>Add Inventory Unit Type</h1>
        </div>
        <div class="add_unit">
            <form action="{{url('submit_unit')}}" method="POST">
                @csrf
                <div>
                    <label for="">Inventory Unit Name</label>
                    <input type="text" name="unit_name" placeholder="eg: KG" required>
                </div>
                <div class="form_items">
                    <input class="btn btn-primary" type="submit" value="Add Unit">
                </div>
            </form>
        </div>
        <div class="inventory_units">
            <table>
                <tr>
                    <th>Unit Name</th>
                    <th>Action</th>
                </tr>
                @forelse($units as $unit)
                <tr>
                    <td>{{ $unit->unit_name }}</td>
                    <td class="action-cell">
                        <a class="btn btn-primary" href="{{url('edit_unit',$unit->id)}}">Edit</a>
                        {{-- <a class="btn btn-danger" href="{{url('delete_unit',$unit->id)}}">Delete</a> --}}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" style="text-align: center;">No data available</td>
                </tr>
                @endforelse
            </table>
        </div>
        </div>
       </div>

        @include('admin.footer')
  </body>
</html>
