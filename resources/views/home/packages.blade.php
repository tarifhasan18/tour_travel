    <!-- Packages Start -->
    <style>
        .package-card-img{
            height: 225px;
            width: 100%;
            object-fit: cover;
        }
        .card-package-name {
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
        }
     </style>
    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Packages</h6>
                <h1>Perfect Tour Packages</h1>
            </div>
            <div class="row">
                {{-- @foreach ($data as $packages) --}}
                @foreach ($data as $packages)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="package-item bg-white mb-2">
                        {{-- <h5>{{$packages->name}}</h1> --}}
                        <img class="package-card-img" src="tour_image/{{$packages->image}}" alt="">
                        <div class="p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <small class="m-0"><i class="fa fa-map-marker-alt text-primary mr-2"></i>{{$packages->location}}</small>
                                <small class="m-0"><i class="fa fa-calendar-alt text-primary mr-2"></i> {{ \Carbon\Carbon::parse($packages->startdate)->diffInDays(\Carbon\Carbon::parse($packages->enddate)) }}days</small>
                                <small class="m-0"><i class="fa fa-user text-primary mr-2"></i>{{$packages->capacity}} Person</small>
                            </div>
                            <a class="card-package-name h5 text-decoration-none" href="{{url('view_details',$packages->id)}}">{{$packages->name}}</a>
                            <p style="font-size: 14px;">From {{$packages->startdate}} to {{$packages->enddate}}</p>
                            @if ($packages->available == 0)

                               @else
                               <p style="color: rgb(44, 42, 42); font-size: 18px">Available Seats: {{$packages->available}}</p>
                               @endif

                            <div class="border-top mt-4 pt-4">
                                <div class="d-flex justify-content-between">
                                    {{-- <h6 class="m-0"><i class="fa fa-star text-primary mr-2"></i>4.5 <small>(250)</small></h6> --}}
                                    <h5 class="m-0">${{$packages->price_dollar}} / BDT{{$packages->price_taka}}</h5>
                                </div>
                            </div>
                            <div>
                                <a class="btn btn-primary mt-3" href="{{url('view_details',$packages->id)}}">View Details</a>

                               @if ($packages->available == 0)
                                    <img style="margin-left: 30px" width="100px" height="100px" src="{{asset('img/closedbooked.png')}}" alt="">
                               @else
                                    <a class="btn btn-success mt-3" href="" data-toggle="modal" data-target="#bookNowModal{{$packages->id}}" data-package-id="{{$packages->id}}">Book Now</a>
                               @endif
                            </div>
                        </div>
                    </div>
                </div>


    <!-- Packages End -->

<!-- Book Now Modal -->
<div class="modal fade" id="bookNowModal{{$packages->id}}" tabindex="-1" role="dialog" aria-labelledby="bookNowModalLabel{{$packages->id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookNowModalLabel{{$packages->id}}">Book Now</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="bookNowForm{{$packages->id}}" action="{{ url('book_now',$packages->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <h3 class="text-center">{{$packages->name}} {{$packages->id}} </h3>
                    </div>
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="eg: Tarif Hasan" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Your Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="eg: tarifhasan@gmail.com" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Your Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="eg: 01790306513" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Your Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="eg: Dhaka" required>
                    </div>
                    <div class="form-group">
                        <label for="total_persons">Number of Persons</label>
                        <input type="number" class="form-control" id="total_persons" name="total_persons" placeholder="eg: 5" required>
                    </div>
                    <div class="form-group">
                        <label for="adult_persons">Number of Adult Persons</label>
                        <input type="number" class="form-control" id="adult_persons" name="adult_persons" placeholder="eg: 3" required>
                    </div>
                    <div class="form-group">
                        <label for="children">Number of Child</label>
                        <input type="number" class="form-control" id="children" name="children" placeholder="eg: 2" required>
                    </div>
                    <div class="form-group">
                        <label for="persons">Any Food Allergy?</label>
                        <input type="text" class="form-control" id="allergy" placeholder="eg: Shrimp allergy " name="allergy">
                        <small class="form-text text-right text-danger">Optional</small>
                    </div>

                    <div class="form-group">
                        <label for="persons">Payment Type</label>
                        <select name="payment_type" id="">

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
                        <label for="persons">Paid Amount</label>
                        <input type="text" class="form-control" id="paid_amount" placeholder="eg: Paid Amount " name="paid_amount">
                        <small class="form-text text-right text-danger">Required</small>
                    </div>

                    <div class="form-group">
                        <label for="persons">Payment Slip</label>
                        <input type="file" class="form-control" id="payment_slip" name="payment_slip">
                        <small class="form-text text-right text-danger">Optional</small>
                    </div>
                    {{-- <div class="form-group">
                        <label for="date">Booking Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div> --}}
                    <input type="submit" class="btn btn-success" value="Book Now">
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

</div>
</div>
</div>

{{-- <script>
    $('#bookNowModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var packageId = button.data('package-id'); // Extract info from data-* attributes
        var modal = $(this);
        modal.find('.modal-body #package_id').val(packageId);
    });
</script> --}}

<script>
    $('[data-toggle="modal"]').on('click', function() {
        var packageId = $(this).data('package-id'); // Extract package ID from data-package-id attribute
        var modal = $('#bookNowModal' + packageId); // Find the corresponding modal using its ID

        // Update modal content based on package ID
        modal.find('.modal-body #package_id').val(packageId);
    });
</script>

