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
                <h1>Tour Booking List of {{$view_customer_bookings[0]->name}}</h1>
            </div>
            <div class="search_container">
                <form action="#" method="get">
                    @csrf
                    <input class="search_box" type="text" name="search" placeholder="Search Here" required>
                    <input class="btn btn-primary" type="submit" value="Search">
                </form>
            </div>
            {{-- <div class="packages_option">
                <form action="{{ url('submit_selected_packages') }}" method="get">
                    <select name="search" id="select-packages" required>
                        <option value="">Select a Package</option>
                        @foreach ($packages as $packages_items)
                            <option value="{{ $packages_items->name }}">{{ $packages_items->name }}</option>
                        @endforeach
                    </select>
                    <input class="btn btn-primary" type="submit" value="Submit">
                </form>
            </div>
            <div class="approved_rejected_booking">
                <form action="{{ url('approved_rejected_booking') }}" method="get">
                    <select name="search" id="select-packages" required>
                        <option value="">Select Approved/Rejected</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                            <option value="in progress">In Progress</option>
                    </select>
                    <input class="btn btn-primary" type="submit" value="Submit">
                </form>
            </div> --}}
            <div class="tour_packages table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Booking Name</th>
                            <th>Booking Email</th>
                            {{-- <th>Address</th> --}}
                            <th>Phone Number</th>
                            <th>Tour Package</th>
                            <th>Paid Amount</th>
                            <th>Due</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @dump($view_customer_bookings) --}}
                        @forelse($view_customer_bookings as $booking)
                            <tr>
                                <td>{{ $loop->iteration + ($view_customer_bookings->currentPage() - 1) * $view_customer_bookings->perPage() }}</td>
                                <td>{{ $booking->customer_name }}</td>
                                <td>{{ $booking->email }}</td>
                                {{-- <td>{{ $booking->address }}</td> --}}
                                <td>{{ $booking->phone }}</td>
                                <td>{{ $booking->package_name }}</td>
                                <td>{{ $booking->paid_amount }}</td>
                                <td>{{ $booking->due }}</td>
                                <td>{{ $booking->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">No bookings found for this email.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- <div class="d-flex justify-content-end">
                {{ $view_customer_bookings->links() }}
            </div> --}}
            <div class="d-flex justify-content-end">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        {{ $view_customer_bookings->links('pagination::bootstrap-5') }}
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    {{-- <!-- Modal -->
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
    </script> --}}

    @include('admin.footer')
</body>

</html>
