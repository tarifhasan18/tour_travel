<!DOCTYPE html>
<html lang="en">

<head>
   @include('home.header')
   <style>
    .service{
        margin-top: 50px;
    }
    p{
        max-width: 800px;
    }
   </style>
</head>

<body>

    @include('home.topbar')
    <div class="service">
        <div class="text-center mt-3 pb-3">
            <h5 class="text-primary text-uppercase" style="letter-spacing: 5px;">Service Details</h5>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
               <div>
                  <div style="padding: 20px" class="service_img">
                    <h3 style="text-align: center">{{$services->name}}</h3>
                     <figure><img style="width: 800px; height:400px;" src="{{asset('tour_image/'.$services->image)}}"/></figure>
                     <p>{{$services->description}}</p>
                  </div>
               </div>
            </div>
    </div>
    </div>
    @include('home.footer')
</body>

</html>
