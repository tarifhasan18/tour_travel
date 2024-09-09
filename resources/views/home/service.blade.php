@php
    use Illuminate\Support\Str;
@endphp
    <!-- Service Start -->
    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Services</h6>
                <h1>Tours & Travel Services</h1>
            </div>
            <div class="row">
                @foreach ($data as $services)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-item bg-white text-center mb-2 py-5 px-4">
                        {{-- <i class="fa fa-2x fa-route mx-auto mb-4"></i> --}}
                        <img class="mb-4" src="tour_image/{{$services->image}}" height="200px" width="300px" alt="">
                        <h5 class="mb-4">{{$services->name}}</h5>
                        <p class="m-0">
                            {!!Str::limit($services->description,60)!!}
                        </p>
                        <a class="btn btn-primary mt-2" href="{{url('service_details',$services->id)}}">View Details</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Service End -->
