@php
    $banner = \App\Models\BannerInformation::first();
@endphp
<html>

<head>
    <title>Invoice</title>
    <style>
        @media print {
            @page {
                size: portrait;
            }

            html, body {
                width: 54mm;
                height: auto;
                margin: 0;
                margin-block: 5px;
                padding: 10px;
                overflow: hidden; /* Hide content overflow */
            }
        }

        table {
            font-size: 12px;
        }

        .wrapper {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            grid-auto-rows: minmax(100px, auto);
        }

        .one {
            grid-row-start: 1;
            grid-row-end: 1;
            grid-column-start: 2;
            grid-column-end: 4;
        }

        .two {
            grid-row-start: 1;
            grid-row-end: 1;
            grid-column-start: 1;
            grid-column-end: 2;
        }

        .dotted {
            border: none;
            border-top: 1px dotted #000000;
            height: 1px;
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div id="print" xmlns:margin-top="http://www.w3.org/1999/xhtml">
        {{--    Company Details --}}
        <div style="text-align: center;">
            <img width="100px" src="{{ asset('backend/unipos_logo.png') }}" alt="Restaurant Image">
            <!-- <h2 style="line-height: 0;">Pure N Pretty</h2>
            <p style="letter-spacing: 3px; line-height: 0;">Fashion & Beauty</p> -->
        </div>
        <table style="margin-top: 10px;">
            <tr>
                <td>
                    Address
                </td>
                <td>
                    {{ $banner->banner_address }}
                </td>
            </tr>
            <tr>
                <td>
                    Phone
                </td>
                <td>
                    {{ $banner->banner_mobile }}
                </td>
            </tr>
        </table>
        <hr>
        <table style="margin-top: 10px;">
            <tr>
                <td>
                    Order No
                </td>
                <td>
                    : IN#0000{{ $CartInformtion->cart_id }}
                </td>
            </tr>
            <tr>
                <td>
                    Delivered By
                </td>
                <td>
                    : {{ $CartInformtion->waiter->full_name }}
                </td>
            </tr>
            <tr>
                <td>
                    Date
                </td>
                <td>
                    :  {{ $CartInformtion->cart_date->format('M j, Y g:i A') }}
                </td>
            </tr>

        </table>
        <hr>
        <?php $i = 1; ?>
        <table style="margin-top: 10px; text-align: center;">
            <tr>
                <th>
                    SL
                </th>
                <th style="padding-left:10px; padding-right:10px;">
                    Item
                </th>
                <th style="padding-left:10px; padding-right:10px;">
                    Qty
                </th>
                <th style="padding-left:10px; padding-right:10px;">
                    Amount
                </th>
            </tr>

            @foreach ($CartInformtionForPrint as $item)
                <tr>
                    <td style="padding-right:10px;">
                        {{ $i++ }}
                    </td>
                    <td style="padding-left:10px; padding-right:10px;">
                        {{ $item->product_name }}
                    </td>
                    <td style="padding-left:10px; padding-right:10px;text-align:right">
                        @if ($CartInformtion->sales_type == 2)
                            {{ $item->quantity }} X {{ $item->unit_sales_cost }}
                        @endif
                    </td>
                    <td style="padding-left:10px; padding-right:10px; text-align:right">
                        @if ($CartInformtion->sales_type == 2)
                            {{ $item->unit_sales_cost * $item->quantity }}
                        @endif
                    </td>
                </tr>
                <!--tr>
                    <td style="padding-right:10px;">

                    </td>
                    <td style="padding-left:10px; padding-right:10px;">

                    </td>
                    <td style="padding-left:10px; padding-right:10px;">
                        Vat
                    </td>
                    <td style="padding-left:10px; padding-right:10px;">
                        {{ $item->vat }}
                    </td>
                </tr-->
            @endforeach
            <!--tr>
                <td style="padding-right:10px;">

                </td>
                <td style="padding-left:10px; padding-right:10px;">

                </td>
                <td style="padding-left:10px; padding-right:10px;">
                    Subtotal
                </td>
                <td style="padding-left:10px; padding-right:10px;">
                    {{ $item->total_cart_amount }}
                </td>
            </tr>
            <tr>
                <td>

                </td>
                <td>

                </td>
                <td style="padding-left:10px; padding-right:10px;">
                    Vat Total
                </td>
                <td style="padding-left:10px; padding-right:10px;">
                    {{ $item->vat_amount }}
                </td>
            </tr-->
            <tr>
                <td style="padding-right:10px;">

                </td>
                <td colspan="2" style="padding-left:10px; padding-right:10px; text-align: end;">
                    Grand Total
                </td>
                <td style="padding-left:10px; padding-right:10px;text-align:right">
                    {{ $item->total_cart_amount + $item->vat_amount }}
                </td>
            </tr>
            <tr>
                <td style="padding-right:10px;">

                </td>
                <td style="padding-left:10px; padding-right:10px;">

                </td>
                <td style="padding-left:10px; padding-right:10px;">
                    Discount
                </td>
                <td style="padding-left:10px; padding-right:10px;text-align:right">
                    {{ $item->total_discount }}
                </td>
            </tr>
            <tr>
                <td style="padding-right:10px;">

                </td>
                <td style="padding-left:10px; padding-right:10px;">

                </td>
                <td style="padding-left:10px; padding-right:10px;">
                    Payble
                </td>
                <td style="padding-left:10px; padding-right:10px;text-align:right">
                    {{ $item->total_payable_amount }}
                </td>
            </tr>

        </table>

        <div class="dotted">

        </div>
        <div style="font-size: 12px; text-align: center;">We are happy to serve you</div>
        <hr>
        <div style="font-size: 12px; text-align: center;">* NO CHANGE * NO REFUND * NO RETURN *</div>
        <hr>
        <div style="font-size: 12px; text-align: center;">Powered by Unicorn Software and Solutions Ltd.</div>
    </div>


    <script>
        window.print();
    </script>
</body>

</html>
