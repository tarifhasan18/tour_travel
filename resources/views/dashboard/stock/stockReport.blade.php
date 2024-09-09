@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')

<div class="main-panels" style="padding: 120px">
    <div class="content-wrapper">
        <div class="page-header justify-content-between">
            <h3 class="page-title">Stock</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Stock</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> Stock Report </li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="card-description btn btn-info"><a class="text-light" href="{{ route('stock-transfer')}}">Stock Transfer</a></div>
                        <div class="card-description float-right">
                            <div class="input-group mb-3">
                                <select aria-label="Default" aria-describedby="inputGroup-sizing-default" class="form-control" name="category_id" id="category_id">
                                    <option selected disabled>-------Select-------</option>
                                    @foreach($product_cat as $cat)
                                        <option value="{{$cat->category_id}}">{{$cat->category_name}}</option>
                                    @endforeach
                                </select>
                                 <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-light" id="inputGroup-sizing-default">Category</span>
                                </div>
                            </div>

                        </div>
                        <h4 class="card-title text-center">Stock Report</h4>
                        @if (Session::get('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                        @endif
                        @if (Session::get('fail'))
                        <div class="alert alert-danger">
                            {{ Session::get('fail') }}
                        </div>
                        @endif

                        @php
                            $total_value = 0;
                        @endphp

                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered">

                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Location</th>
                                        <th>Purchased </th>
                                        <th>Sold </th>
                                        <th>Stock </th>
                                        <th>Unit Price</th>
                                        <th>Total Value</th>
                                    </tr>

                                </thead>
                                <tbody id="stock_table">
                                    @foreach($stock_report as $values)
                                    <tr>
                                        <td>{{$values->product_name }}</td>
                                        <td>{{$values->store_name }}</td>
                                        <td style="text-align:right;">{{$values->total_purchased_quantity ===null ? 0 : $values->total_purchased_quantity }}</td>
                                        <td style="text-align:right;">{{$values->total_sold_quantity === null ? 0 : $values->total_sold_quantity }}</td>
                                        <td style="text-align:right;">{{$values->final_quantity}}</td>
                                        <td style="text-align:right;">{{$values->purchase_price}}</td>
                                        <td style="text-align:right;">{{$values->final_quantity*$values->purchase_price}}</td>
                                        @php

                                            $total_value = $total_value + ($values->final_quantity*$values->purchase_price) ;
                                        @endphp
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Location</th>
                                        <th>Purchased </th>
                                        <th>Sold </th>
                                        <th>Stock </th>
                                        <th>Unit Price</th>
                                        <th>Total Value</th>
                                    </tr>

                                </tfoot>

                            </table>
                        </div>
                        <div id="total_Value_show">
                            Total Value = {{ number_format($total_value, 2, '.', ',')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
          <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>

<script type="text/javascript">
$(document).ready(function() {

$(document).on('change', '#category_id', function(e) {
    e.preventDefault();
    var category_id = $(this).val();

    // from store
    $.ajax({
        url: "cat-wise-stock/" + category_id,
        type: "GET",
        data: {
            "_token": "{{ csrf_token() }}"
        },
        dataType: "json",
        success: function(data) {
            console.log(data);
            $("#stock_table").empty();
            var stockhtml = "";
            var total_value = 0.00;

            $.each(data, function(key, value) {
                stockhtml += '<tr>';
                stockhtml += '<td>' + value.product_name + '</td>';
                stockhtml += '<td>' + value.store_name + '</td>';
                stockhtml += '<td style="text-align:right">' + value.total_purchased_quantity + '</td>';
                stockhtml += '<td style="text-align:right">' + value.total_sold_quantity + '</td>';
                stockhtml += '<td style="text-align:right">' + value.final_quantity + '</td>';
                stockhtml += '<td style="text-align:right">' + value.purchase_price + '</td>';
                stockhtml += '<td style="text-align:right">' + (value.purchase_price * value.final_quantity).toFixed(2) + '</td>';
                stockhtml += '</tr>';

                total_value += (value.purchase_price * value.final_quantity);
            });

            var total_text = "Total Value = " + total_value.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            $("#stock_table").append(stockhtml);
            $("#total_Value_show").text(total_text);
        }

    });
});

});
</script>



@include('admin.footer')
