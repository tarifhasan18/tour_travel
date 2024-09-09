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
    .my_bookings{
        margin-top: 10px;
    }
    .booking_heading{
        margin-top: 50px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .booking_heading a.btn{
        border-radius: 5px;
    }
    </style>
</head>

<body>

    @include('home.topbar')

    <div class="container">
        <div class="page-inner">
            <div class="booking_heading">
                <h3>{{Auth::user()->name}}'s all Bookings</h3>
                <a href="{{url('view_all_payments_users')}}" class="btn btn-primary">View All Payment</a>
            </div>
            {{-- <div class="search_container">
                <form action="{{url('search_packages')}}" method="get">
                  @csrf
                  <input class="search_box" type="text" name="search" placeholder="Search Here" required>
                  <input class="btn btn-primary" type="submit" value="Search">
                </form>
            </div> --}}
            <div class="my_bookings">
                @if ($data->isEmpty())
                    <p>No data available</p>
                @else
                <table>
                    <tr>
                        <th>Date</th>
                        <th>Tour Package</th>
                        <th>Location</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Image</th>
                        <th>Due</th>
                        <th>Pay Now</th>
                        <th>Status</th>
                    </tr>
                    @foreach($data as $bookings)
                    <tr>
                        <td> <span class="text-nowrap">{{$bookings->packages->startdate}}</span> to <span class="text-nowrap">{{$bookings->packages->enddate}}</span>  </td>
                        <td>{{$bookings->packages->name}}</td>
                        <td>{{$bookings->packages->location}}</td>
                        <td>{{$bookings->packages->description}}</td>
                        <td>${{$bookings->packages->price_dollar}} <br> BDT{{$bookings->packages->price_taka}}</td>
                        <td>{{ \Carbon\Carbon::parse($bookings->packages->startdate)->diffInDays(\Carbon\Carbon::parse($bookings->packages->enddate)) }}days</td>
                        <td>
                            <img width="200px" height="140px" src="tour_image/{{$bookings->packages->image}}" alt="">
                        </td>
                        <td>
                            {{$bookings->due}} Taka
                        </td>
                        <td>
                            @if ($bookings->due > 0 )
                            <a type="button" class="btn btn-primary getPaymentInfo" data-toggle="modal"
                            data-target="#payNowModals" data-log="{{ $bookings }}"
                            data-package-id="{{ $bookings->id }}">Pay Now</a></td>
                            @else
                            Paid
                            @endif
                        </td>
                        <td>
                           @if ($bookings->status == 'Rejected')
                           <span style="color: red;">Canceled</span>
                            @elseif ($bookings->status == 'Approved')
                            <span style="color: green;">Approved</span>
                            @else
                              {{$bookings->status}}
                           @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
                @endif
            </div>
        </div>
       </div>


       <!-- Modal -->
    <div class="modal fade" id="payNowModals" tabindex="-1" aria-labelledby="payNowModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="payNowModalLabel">Pay Now</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('usersPayNow',) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="booking_id" id="booking_id">
                            <label for="persons">Payment Type</label>
                            <select name="payment_type" id="payment_type" required>
                                <option value="" disabled selected>Please select one</option>
                                @foreach ($payment_type as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-right text-danger">Required</small>
                        </div>

                        <div class="form-group">
                            <label for="persons">Reference</label>
                            <input type="text" class="form-control" id="reference" placeholder="eg: Reference " name="reference" required>
                            <small class="form-text text-right text-danger">Required</small>
                        </div>

                        <div class="form-group">
                            <label for="persons">Paid Amount <span class="text-warning" id="current_due"></span></label>
                            <input type="text" class="form-control" id="paid_amount" placeholder="eg: Shrimp allergy " name="paid_amount" required>
                            <small class="form-text text-right text-danger">Required</small>
                        </div>

                        <div class="form-group">
                            <label for="persons">Payment Slip</label>
                            <input type="file" class="form-control" id="payment_id" name="payment_slip">
                            <small class="form-text text-right text-danger">Optional</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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


    {{-- Continue with other sections --}}
    {{-- @include('home.packages') --}}
    {{-- @include('home.team') --}}
    @include('home.footer')

</body>

</html>
