@php
    use Illuminate\Support\Facades\Auth;

@endphp
<!-- home.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.header')
    <style>
        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
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

        .my_bookings {
            margin-top: 10px;
        }

        .booking_heading {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .booking_heading a.btn {
            border-radius: 5px;
        }
    </style>
</head>

<body>

    @include('home.topbar')

    <div class="container">
        <div class="page-inner">
            <div class="booking_heading">
                <h3>{{ Auth::user()->name }}'s all Transactions</h3>
                {{-- <a href="{{url('view_all_payments_users')}}" class="btn btn-primary">View All Payment</a> --}}
            </div>
            {{-- <div class="search_container">
            <form action="{{url('search_packages')}}" method="get">
              @csrf
              <input class="search_box" type="text" name="search" placeholder="Search Here" required>
              <input class="btn btn-primary" type="submit" value="Search">
            </form>
        </div> --}}
            <div class="my_bookings">
                @if ($view_all_payments->isEmpty())
                    <p>No data available</p>
                @else
                    <table>
                        <tr>
                            <th>SL No</th>
                            <th>Date</th>
                            <th>Package Name</th>
                            <th>Payment Type</th>
                            <th>Reference</th>
                            <th>Payment Slip</th>
                            <th>Paid Amount</th>
                            <th>Status</th>
                        </tr>
                        @foreach ($view_all_payments as $key => $all_payments)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td> {{ $all_payments->created_at }}</td>
                                <td> {{ $all_payments->package_name }}</td>
                                <td>{{ $all_payments->payment_type_name }}</td>
                                <td>{{ $all_payments->reference }}</td>
                                <td><img style="height: 60px; width: auto;"
                                        src="{{ asset('payment_slip_image/' . $all_payments->payment_slip) }}"
                                        alt="{{ $all_payments->payment_slip }}"></td>
                                <td>{{ $all_payments->paid_amount }}</td>
                                <td>
                                    @if ($all_payments->is_verified == 1)
                                        Paid
                                    @elseif ($all_payments->is_verified == 2)
                                        Rejected
                                    @else
                                        Pending
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
        </div>
    </div>
    @include('home.footer')

</body>

</html>
