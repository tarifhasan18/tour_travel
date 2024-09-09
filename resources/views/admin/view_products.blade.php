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
    /* a{
        border-radius: 10px;
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
    .product_list{
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
            <div style="margin-top:20px">
                <h1>All Product List</h1>
            </div>

            <div class="search_container">
                <form action="{{url('search_products')}}" method="get">
                  @csrf
                  <input class="search_box" type="text" name="search" placeholder="Search Here" required>
                  <input class="btn btn-primary" type="submit" value="Search">
                </form>
            </div>
            <div class="product_list">
                {{-- <table>
                    <tr>
                        <th>Product Name</th>
                        <th>Product Category</th>
                        <th>Product Details</th>
                        <th>Unit Type</th>
                        <th>Action</th>
                    </tr>
                    @foreach($products as $product)
                    <tr>
                        <td>{{$product->product_name}}</td>
                        <td>{{$product->categories->category_name}}</td>
                        <td>{{$product->product_details}} </td>
                        <td>{{$product->quantity}}</td>
                        <td>{{$product->price}}</td>
                        <td>
                            <a class="btn btn-primary" href="{{url('edit_product',$product->id)}}">Edit</a>
                            <a class="btn btn-danger" href="{{url('delete_product',$product->id)}}">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                     @foreach($categories as $product)
                    <tr>
                        <td>{{$product->product_name}}</td>
                        <td>{{$product->categories->category_name}}</td>
                        <td>{{$product->product_details}} </td>
                        <td>{{$product->unit_type->unit_name}}</td>
                        <td>
                            <a class="btn btn-primary" href="{{url('edit_product',$product->id)}}">Edit</a>
                            <a class="btn btn-danger" href="{{url('delete_product',$product->id)}}">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                @foreach($categories as $category)
                        <div class="category-section">
                            <h2>{{ $category->category_name }}</h2>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Product Details</th>
                                        <th>Unit Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($category->products as $product)
                                        <tr>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ $product->product_details }}</td>
                                            <td>{{ $product->unitType->unit_name}}</td>
                                            <td class="action-cell">
                                                <a class="btn btn-primary" href="">Edit</a>
                                                <a class="btn btn-danger" href="">Delete</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No products available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endforeach --}}

                    <table>
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Product Name</th>
                                <th>Product Details</th>
                                <th>Unit Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->product_details }}</td>
                                    <td>{{ $product->unitType->unit_name ?? 'N/A' }}</td>
                                    <td class="action-cell">
                                        <a class="btn btn-primary" href="{{ url('edit_product', $product->id) }}">Edit</a>
                                        <a class="btn btn-danger" href="{{ url('delete_product', $product->id) }}">Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No products available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
            </div>
        </div>
       </div>

        @include('admin.footer')
  </body>
</html>
