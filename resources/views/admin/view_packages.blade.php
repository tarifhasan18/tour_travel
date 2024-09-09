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
                <h1>All Tour Packages</h1>
            </div>
            
            <div class="search_container">
                <form action="{{url('search_packages')}}" method="get">
                  @csrf
                  <input class="search_box" type="text" name="search" placeholder="Search Here" required>
                  <input class="btn btn-primary" type="submit" value="Search">
                </form>
            </div>
            <div class="tour_packages">
                <table>
                    <tr>
                        <th>Package Title</th>
                        <th>Location</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Capacity</th>
                        <th>Available</th>
                        <th>Duration</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    @foreach($data as $packages)
                    <tr>
                        <td>{{$packages->name}}</td>
                        <td>{{$packages->location}}</td>
                        <td>${{$packages->price_dollar}} <br>BDT{{$packages->price_taka}} </td>
                        <td>{{$packages->description}}</td>
                        <td>{{$packages->capacity}} </td>
                        <td>{{$packages->available}}</td>
                        <td>{{$packages->startdate}} to {{$packages->enddate}}
                           <br> {{ \Carbon\Carbon::parse($packages->startdate)->diffInDays(\Carbon\Carbon::parse($packages->enddate)) }} days
                        </td>
                        <td>
                            <img width="200px" height="140px" src="{{asset('tour_image/'.$packages->image)}}" alt="">
                        </td>
                        <td>
                            <a class="btn btn-primary btn-block" href="{{url('edit_packages',$packages->id)}}">Edit</a>
                            <a class="btn btn-danger btn-block mt-2" href="{{url('delete_packages',$packages->id)}}">Delete</a>
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
