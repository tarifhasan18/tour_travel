<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/public">
   @include('home.header')
   <style>

/*****************globals*************/

img {
  max-width: 100%; }

.preview {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }
  @media screen and (max-width: 996px) {
    .preview {
      margin-bottom: 20px; } }

.preview-pic {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
          flex-grow: 1; }

.preview-thumbnail.nav-tabs {
  border: none;
  margin-top: 15px; }
  .preview-thumbnail.nav-tabs li {
    width: 18%;
    margin-right: 2.5%; }
    .preview-thumbnail.nav-tabs li img {
      max-width: 100%;
      display: block; }
    .preview-thumbnail.nav-tabs li a {
      padding: 0;
      margin: 0; }
    .preview-thumbnail.nav-tabs li:last-of-type {
      margin-right: 0; }

.tab-content {
  overflow: hidden; }
  .tab-content img {
    width: 100%;
    -webkit-animation-name: opacity;
            animation-name: opacity;
    -webkit-animation-duration: .3s;
            animation-duration: .3s; }

.card {
  margin-top: 50px;
  background: #eee;
  padding: 3em;
  line-height: 1.5em; }

@media screen and (min-width: 997px) {
  .wrapper {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex; } }

.details {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }

.colors {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
          flex-grow: 1; }

.product-title, .price, .sizes, .colors {
  text-transform: UPPERCASE;
  font-weight: bold; }

.checked, .price span {
  color: #ff9f1a; }

.product-title, .rating, .product-description, .price, .vote, .sizes {
  margin-bottom: 15px; }

.product-title {
  margin-top: 0; }

.size {
  margin-right: 10px; }
  .size:first-of-type {
    margin-left: 40px; }

.color {
  display: inline-block;
  vertical-align: middle;
  margin-right: 10px;
  height: 2em;
  width: 2em;
  border-radius: 2px; }
  .color:first-of-type {
    margin-left: 20px; }

.add-to-cart, .like {
  background: #ff9f1a;
  padding: 1.2em 1.5em;
  border: none;
  text-transform: UPPERCASE;
  font-weight: bold;
  color: #fff;
  -webkit-transition: background .3s ease;
          transition: background .3s ease; }
  .add-to-cart:hover, .like:hover {
    background: #b36800;
    color: #fff; }

.not-available {
  text-align: center;
  line-height: 2em; }
  .not-available:before {
    font-family: fontawesome;
    content: "\f00d";
    color: #fff; }

.orange {
  background: #ff9f1a; }

.green {
  background: #85ad00; }

.blue {
  background: #0076ad; }

.tooltip-inner {
  padding: 1.3em; }

@-webkit-keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
            transform: scale(3); }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
            transform: scale(1); } }

@keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
            transform: scale(3); }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
            transform: scale(1); } }
.tour_packages{
    margin-top: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
}
/*# sourceMappingURL=style.css.map */
   </style>
</head>

<body>

    @include('home.topbar')

    <div class="tour_packages">
        <h1>Tour Package Details</h1>
    </div>
    <div class="container">
		<div class="card">
			<div class="container-fliud">
				<div class="wrapper row">
					<div class="preview col-md-6">
						<div class="preview-pic tab-content">
						  <div class="tab-pane active" id="pic-1"><img src="{{asset('tour_image/'.$data->image)}}" /></div>
						</div>
					</div>
					<div class="details col-md-6">
						<h3 class="product-title">{{$data->name}}</h3>
						<p class="product-description">{{$data->description}}</p>
						<h4 class="price">current price: <span>${{$data->price_dollar}} / BDT {{$data->price_taka}}</span></h4>
                        <h4 >Tour Duration: </h4> <label style="font-size: 20px; font-weight:bold;">{{$data->startdate}} to {{$data->enddate}} ( {{ \Carbon\Carbon::parse($data->startdate)->diffInDays(\Carbon\Carbon::parse($data->enddate)) }} days )</label>
                        <h4>Persons Capacity: <span>{{$data->capacity}}</span></h4>
                        <h4>Available: {{$data->available}}</h4>
                        <h4>Special Instruction</h4>
						<p class="vote">{{$data->special_instruction}}</p>
						<div class="action">
							@if ($data->available == 0)
                            <img width="120px" height="120px" src="{{asset('img/closedbooked.png')}}" alt="">
                            @else
                            <a class="btn btn-primary btn-lg" data-toggle="modal" data-target="#bookNowModal" data-package-id="{{$data->id}}">Book Now</a>
                            @endif
							{{-- <button class="like btn btn-default" type="button"><span class="fa fa-heart"></span></button> --}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<!-- Book Now Modal -->
<div class="modal fade" id="bookNowModal" tabindex="-1" role="dialog" aria-labelledby="bookNowModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookNowModalLabel">Book Now</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="bookNowForm" action="{{ url('book_now',$data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <h3 class="text-center">{{$data->name}}</h3>
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
                        <label for="persons">Number of Persons</label>
                        <input type="number" class="form-control" id="total_persons" name="total_persons" placeholder="eg: 5" required>
                    </div>
                    <div class="form-group">
                        <label for="persons">Number of Adult Persons</label>
                        <input type="number" class="form-control" id="adult_persons" name="adult_persons" placeholder="eg: 3" required>
                    </div>
                    <div class="form-group">
                        <label for="persons">Number of Child</label>
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

<script>
    $('#bookNowModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var packageId = button.data('package-id'); // Extract info from data-* attributes
        var modal = $(this);
        modal.find('.modal-body #package_id').val(packageId);
    });
</script>


    @include('home.footer')
</body>


</html>
