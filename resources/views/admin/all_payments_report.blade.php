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
            /* background-color: ; */
            cursor: pointer;
            /* color: */
        }

        tr:nth-child(odd):hover {
            /* background-color: ; */
            cursor: pointer;
            /* color: */
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

        select {
            height: 40px;
        }
        .img-modal {
            position: fixed;
            justify-content: center;
            align-items: center;
            height: 100dvh;
            width: 100dvw;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #2c3e5075;
            z-index: 1999;
            display: none;
        }

        .img-box {
            padding: 32px;
            background-color: #f9f9f9;
        }

        .img-main-box img {
            max-height: 75vh;
        }

        .show {
            display: flex;
        }
    </style>
</head>

<body>
    @php
        use Carbon\Carbon;
    @endphp
    <!-- Sidebar -->
    @include('admin.sidebar')

    @include('admin.navbar')
    <div class="container">
        <div class="page-inner">
            <div>
                <h1>All Payment Reports</h1>
            </div>
            <div class="packages_option">
                {{-- <form action="{{url('submit_selected_packages')}}" method="get">
                    <select name="search" id="select-packages" required>
                        <option value="">Select a Package</option>
                        @foreach ($packages as $packages_items)
                            <option value="{{$packages_items->name}}">{{$packages_items->name}}</option>
                        @endforeach
                    </select>
                    <input class="btn btn-primary" type="submit" value="Submit">
                </form> --}}
            </div>
            <div class="search_container">
                <form action="{{ url('search_booking') }}" method="get">
                    @csrf
                    <input class="search_box" type="text" name="search" placeholder="Search Here" required>
                    <input class="btn btn-primary" type="submit" value="Search">
                </form>
            </div>
            <div class="tour_packages">
                <table>
                    <tr>
                        <th>SL No</th>
                        <th>Date</th>
                        <th>Payment Type</th>
                        <th>Reference</th>
                        <th>Payment Slip</th>
                        <th class="text-end">Paid Amount</th>
                        <th>Status</th>

                    </tr>
                    @foreach ($payment_details as $payment_detail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Carbon::parse($payment_detail->date)->toDateString() }}</td>
                            <td>{{ $payment_detail->payment_type_name }}</td>
                            <td >{{ $payment_detail->reference }}</td>
                            <td>
                                <img onclick="img_full_viewer(this)" style="height: 60px; width: auto;"
                                    src="{{ asset('payment_slip_image/' . $payment_detail->payment_slip) }}"
                                    alt="{{ $payment_detail->payment_slip }}">
                            </td>
                            <td class="text-end">{{ $payment_detail->paid_amount }}</td>
                            <td>
                               @if ($payment_detail->is_verified == 1)
                                    Approved
                               @else
                                    Rejected
                               @endif
                            </td>

                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="img-modal">
        <div class="img-body">
            <div class="img-box">
                <div class="img-head d-flex justify-content-between align-items-center">
                    <p>Payment Slip</p> <p style="cursor: pointer; font-size: 24px" onclick="img_full_viewer(this)"><i class="fa-solid fa-xmark"></i></p>
                </div>
                <div class="img-main-box">
                    <img src="{{ asset('img/1720872197_sajek.jpg') }}" alt="">
                </div>
                <div class="img-footer text-end pt-3">
                    <button onclick="img_full_viewer(this)" class="btn btn-primary">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
    <script>
        function img_full_viewer(ele) {
            var modalBox = $(".img-modal");

            // Check if the modal does not have the 'show' class
            if (!modalBox.hasClass("show")) {
                // Add the 'show' class to the modal
                modalBox.addClass('show');

                // Get the 'src' attribute of the clicked element
                var imgSrc = $(ele).attr('src');

                // Set the 'src' attribute of the image in the modal
                $(".img-main-box img").attr("src", imgSrc);
            } else {
                // Remove the 'show' class to hide the modal
                modalBox.removeClass('show');
            }
        }
    </script>



    @include('admin.footer')

    <!-- modal for view full screen image -->


</body>

</html>
