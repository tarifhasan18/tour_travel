<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.links')
    <style>
        .tour_packages {
            overflow-x: auto;
            margin: 0 auto;
            /* Optional: centers the table horizontally */
            width: 100%;
            /* Optional: ensures the container takes full width */
            margin-top: 10px;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            /* width: 800px; */
            border: 1px solid #ddd;
            width: 100%;
            /* Change to 100% for responsiveness */
            max-width: 1200px;
            /* Maximum width for the table */
        }

        th {
            text-align: center;
            padding: 8px;
            background: #2c3e50;
            color: white;

        }

        td {
            text-align: center;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #e0dede
        }

        tr:nth-child(even):hover {
            background-color: ;
            cursor: pointer;
            color:
        }

        tr:nth-child(odd):hover {
            background-color: ;
            cursor: pointer;
            color:
        }

        a {
            border-radius: 10px;
        }

        .search_container {
            display: flex;
            justify-content: right;
            align-items: right;
        }

        .search_box {
            padding: 10px;
            width: 350px;
            border: 1px solid black;
        }

        .packages_option {
            display: flex;
            justify-content: left;
            align-items: left;
            float: left;
            /* margin-top: 10px; */
            margin: 20px;
        }
        .approved_rejected_booking{
            display: flex;
            justify-content: right;
            align-items: right;
            float: right;
            /* margin-top: 10px; */
            margin: 20px;
        }

        select {
            height: 40px;
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
                <h1>All Tour Bookings</h1>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-5">
                <form class="d-flex gap-2" action="{{ url('approved_rejected_booking') }}" method="get">
                    <select class="p-2" name="search" id="select-packages" required>
                        <option value="" selected disabled>Select Approved/Rejected</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                            <option value="in progress">In Progress</option>
                    </select>
                    <input class="btn btn-primary" type="submit" value="Submit">
                </form>
                <form class="d-flex gap-2" action="{{ url('submit_selected_packages') }}" method="get">
                    <select class="p-2" name="search" id="select-packages" required>
                        <option value="">Select a Package</option>
                        @foreach ($packages as $packages_items)
                            <option value="{{ $packages_items->name }}">{{ $packages_items->name }}</option>
                        @endforeach
                    </select>
                    <input class="btn btn-primary" type="submit" value="Submit">
                </form>
                <form class="d-flex gap-2" action="{{ url('search_booking') }}" method="get">
                    @csrf
                    <input class="search_box" type="text" name="search" placeholder="Search Here" required>
                    <input class="btn btn-primary" type="submit" value="Search">
                </form>
            </div>
            <div class="tour_packages table-responsive">
                <table id="searchable" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#Sr.</th>
                        <th>User Details</th>
                        <th>Total Persons</th>
                        <th>Adults</th>
                        <th>Children</th>
                        <th>Allergy</th>
                        <th>Tour Package</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Due</th>
                        <th>Pay Now</th>
                        <th>Change Status</th>
                        <th>Remove Package</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($booking as $bookings)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $bookings->customer_name }} <br> {{ $bookings->phone }} <br> {{ $bookings->email }}
                                <br> {{ $bookings->address }}
                            </td>
                            <td>{{ $bookings->no_of_travellers }}</td>
                            <td>{{ $bookings->no_of_adult }}</td>
                            <td>{{ $bookings->no_of_child }}</td>
                            <td>{{ $bookings->allergy }}</td>
                            <td>{{ $bookings->packages->name }}</td>
                            <td>${{ $bookings->packages->price_dollar }} <br> BDT{{ $bookings->packages->price_taka }}
                            </td>
                            <td>
                                <img width="100px" height="80px"
                                    src="{{ asset('tour_image/' . $bookings->packages->image) }}" alt="">
                            </td>
                            <td>{{ $bookings->status }}</td>
                            <td>{{ $bookings->due }}</td>
                            <td><a type="button" style="color:white" class="btn btn-primary getPaymentInfo" data-bs-toggle="modal"
                                    data-bs-target="#payNowModal" data-log="{{ $bookings }}"
                                    data-package-id="{{ $bookings->id }}">Pay Now</a></td>
                            <td>
                                <a class="btn btn-success"
                                    href="{{ url('approve_booking', $bookings->id) }}">Approve</a>
                                <a class="btn btn-warning mt-2"
                                    href="{{ url('reject_booking', $bookings->id) }}">Rejected</a>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="{{ url('remove_booking', $bookings->id) }}">Remove</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="payNowModal" tabindex="-1" aria-labelledby="payNowModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="payNowModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('addPayment') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="booking_id" id="booking_id">
                            <label for="persons">Payment Type</label>
                            <select name="payment_type" id="payment_type">
                                <option value="" disabled selected>Please select one</option>
                                @foreach ($payment_type as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-right text-danger">Required</small>
                        </div>

                        <div class="form-group">
                            <label for="persons">Reference</label>
                            <input type="text" class="form-control" id="reference" placeholder="eg: Reference " name="reference">
                            <small class="form-text text-right text-danger">Required</small>
                        </div>

                        <div class="form-group">
                            <label for="persons">Paid Amount <span class="text-warning" id="current_due"></span></label>
                            <input type="text" class="form-control" id="paid_amount" placeholder="eg: Shrimp allergy " name="paid_amount">
                            <small class="form-text text-right text-danger">Required</small>
                        </div>

                        <div class="form-group">
                            <label for="persons">Payment Slip</label>
                            <input type="file" class="form-control" id="payment_id" name="payment_slip">
                            <small class="form-text text-right text-danger">Optional</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="Submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.getPaymentInfo').on('click', function(e) {
                var data = $(this).data('log');
                console.log(data);

                $('#booking_id').val(data.id);
                $('#current_due').text(`(Current Due: ${data.due})`);
                $('#paid_amount').val(data.due);
            });
        });
    </script>

    @include('admin.footer')
</body>

</html>
