<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.links')
    <style>
        .invoice-body {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }

        .invoice-body h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2em;
            color: #333;
        }

        .section-container {
            display: flex;
            justify-content: space-between;
        }

        .left-section, .right-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .left-section {
            width: 49%;
            height: auto;
        }

        .right-section {
            width: 49%;
            height: auto;
        }

        /* .section {
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #fafafa;
            max-height: 800px;
            overflow-y: auto;
            height: 500px;
        } */
        .category_section
        {
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #fafafa;
            /* max-height: 800px;
            overflow-y: auto; */
            height: 200px;
        }
        .category_scroll{
            max-height: 200px;
            overflow-y: auto;
            height: 100px;
        }
        .products_section{
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #fafafa;
            max-height: 800px;
            overflow-y: auto;
            height: 400px;
        }
        .purchased_products_section
        {
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #fafafa;
            max-height: 800px;
            overflow-y: auto;
            height: 250px;
        }
        .total_purchase_info{
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #fafafa;
            max-height: 800px;
            overflow-y: auto;
            height: 400px;
        }

        .section h2 {
            margin-bottom: 15px;
            font-size: 1.5em;
            color: #555;
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
    .action-cell {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px; /* Optional: to add space between buttons */
}
    tr:nth-child(even){background-color: #e0dede}
    tr:nth-child(even):hover{background-color: ; cursor: pointer;color: }
    tr:nth-child(odd):hover{background-color: ; cursor: pointer;color: }

        /* .category-item {
            cursor: pointer;
            padding: 10px;
            background-color: blue;
            color: white;
            margin: 10px;
            display: inline-block;
        } */

        /* .category-item:hover {
            background-color: darkblue;
        } */
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    @include('admin.sidebar')
    @include('admin.navbar')
    <div class="container">
        <div class="page-inner">
            <div class="invoice-body">
                <h1>Purchase Invoice</h1>
                <div class="section-container">
                    <div class="left-section">
                        <div class="category_section" id="category">
                            <h2>Category</h2>
                            <div class="category_scroll">
                                @foreach ($categories as $category)
                                <div class="category-item btn btn-outline-primary m-2" data-id="{{ $category->id }}">{{ $category->category_name }}</div>
                            @endforeach
                            </div>
                        </div>

                        <div class="products_section" id="products">
                            <h2>Products</h2>
                            <div id="productResults">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            {{-- <th>Product Details</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productList">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="right-section">
                        <div class="purchased_products_section" id="purchased-products">
                            <h2>Purchased Products</h2>
                            <div class="table-responsive">
                                <table>
                                    {{-- <thead class="table-success"> --}}
                                        <tr>
                                            <th style="font-size: 10px" scope="col">Name</th>
                                            <th style="font-size: 10px" scope="col">Unit Price</th>
                                            <th style="font-size: 10px" scope="col">Qty</th>
                                            <th style="font-size: 10px" scope="col">Total</th>
                                            <th style="font-size: 10px" scope="col">Actions</th>
                                        </tr>
                                    {{-- </thead> --}}
                                    {{-- <tbody> --}}
                                        <tr>
                                            <td scope="row">1</th>
                                            <td>John</td>
                                            <td>Doe</td>
                                            <td>100</td>
                                            <td>add</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">2</th>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td>200</td>
                                            <td>add</td>
                                        </tr>
                                        <tr>
                                            <td scope="row">3</th>
                                            <td>Jacob</td>
                                            <td>Thornton</td>
                                            <td>300</td>
                                            <td>add</td>
                                        </tr>
                                    {{-- </tbody> --}}
                                </table>
                            </div>
                        </div>
                        <div class="total_purchase_info" id="total-purchase-info">
                            <h2>Total Purchase Information</h2>
                        </div>
                        <div class="bg-light p-4" id="payment-info">
                            <h2>Payment Information</h2>
                            <form>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-4 col-form-label">Payment Type</label>
                                    <div class="col-sm-8">
                                        <select class="form-control bg-white" name="" id="">
                                            <option value="">Cash</option>
                                            <option value="">Bank</option>
                                            <option value="">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-4 col-form-label">Total Amount</label>
                                    <div class="col-sm-8">
                                        <input type="" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-4 col-form-label">Total Payable</label>
                                    <div class="col-sm-8">
                                        <input type="" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-4 col-form-label">Due Amount</label>
                                    <div class="col-sm-8">
                                        <input type="" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-4 col-form-label">Reference No (If Any)</label>
                                    <div class="col-sm-8">
                                        <input type="" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-4 col-form-label">Supplier</label>
                                    <div class="col-sm-8">
                                        <select class="form-control bg-white" name="" id="">
                                            <option selected disabled>Select</option>
                                            <option value="">Habib</option>
                                            <option value="">Tarif</option>
                                            <option value="">Raihan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-4 col-form-label">Date</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-4 col-form-label">Supply Memo No</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-4 col-form-label">Note</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="" id="" style="height: 100px;"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.footer')

    <script>
        $(document).ready(function() {
            $('.category-item').click(function() {
                var categoryId = $(this).data('id');
                var categoryName = $(this).text(); // Fetch category name from clicked element

                $.ajax({
                    url: '{{ route("fetch.products") }}',
                    type: 'GET',
                    data: { category_id: categoryId },
                    success: function(response) {
                        var products = response.products;
                        var html = '<h4>' + categoryName + '</h4>';

                        if (products.length > 0) {
                            html += '<table class="table"><thead><tr><th>Product Name</th><th>Action</th></tr></thead><tbody>';

                            $.each(products, function(index, product) {
                                html += '<tr>';
                                html += '<td>' + product.product_name + '</td>';
                                // html += '<td>' + product.product_details + '</td>';
                                html += '<td><a href="#" class="btn btn-outline-primary m-2" data-bs-toggle="modal" data-bs-target="#myModal">+</a> ';
                                html += '</tr>';
                            });

                            html += '</tbody></table>';
                        } else {
                            html += '<p>No products found.</p>';
                        }

                        $('#productResults').html(html);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>


        <!-- The Modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Product1</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <label for="" class="col-sm-4 col-form-label">Purchase Price</label>
                            <div class="col-sm-8">
                                <input type="" class="form-control" id="" placeholder="Purchase Price">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="" class="col-sm-4 col-form-label">Quantity</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="" placeholder="Quantity">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </form>

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

                </div>
            </div>
            </div>

</body>
</html>



    {{-- <script>
        $(document).ready(function() {
            $('.category-item').click(function() {
                var categoryId = $(this).data('id');
                var categoryName = $(this).text(); // Fetch category name from clicked element

                $.ajax({
                    url: '{{ route("fetch.products") }}',
                    type: 'GET',
                    data: { category_id: categoryId },
                    success: function(response) {

                        var products = response.products;
                        var html = '<h4>' + categoryName + '</h4><ul>';
                        $.each(products, function(index, product) {
                            html += '<li>' + product.id + product.product_name + ' - Quantity: ' + product.quantity + '</li>';
                        });
                        html += '</ul>';
                        $('#productResults').html(html);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script> --}}
