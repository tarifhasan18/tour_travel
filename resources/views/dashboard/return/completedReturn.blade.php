@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120px">
    <div class="content-wrapper">
   <div class="page-header d-flex justify-content-between align-items-center">
     <h3 class="page-title" style="margin-left: 20px">Return</h3>
     <nav aria-label="breadcrumb">
       <ol class="breadcrumb mr-4">
         <li class="breadcrumb-item"><a href="#">Return</a></li>
         <li class="breadcrumb-item active" aria-current="page">All Return </li>
       </ol>
     </nav>
   </div>
   <div class="row">
     <div class="col-lg-12 grid-margin stretch-card">
       <div class="card">
         <div class="card-body">
           <h4 class="card-title text-center">Return List</h4>
           @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
           @endif
           @if (Session::get('fail'))
           <div class="alert alert-danger">
               {{ Session::get('fail') }}
           </div>
           @endif
           <div class="table-responsive">
             <table id="example" class="table table-striped table-bordered" width="100%">

               <thead>
                 <tr>
                   <td> Delivered by </td>
                   <td> Invoice </td>
                   <td> Return Date </td>
                   <td> Invoiced Quantity -> Amount </td>
                   <!--<td> Invoiced Amount </td>-->
                   <td> Returned Quantity -> Amount </td>
                   <!--<td> Returned Amount </td>-->
                   <td> Actual Amount </td>
                 </tr>

               </thead>
               <tbody>

                   @foreach($CartItemReturn as $info)
                     <tr>
                             <td>{{$info->full_name}}</td>
                             <td>{{$info->cart_id}}</td>
                             <td>{{$info->return_date}}</td>
                             <td>{{$info->cart_total_item_quantity}} -> {{$info->cart_total_amount}}</td>
                             <!--<td>{{$info->cart_total_amount}}</td>-->
                             <td>{{$info->total_return_qunatity}} -> {{$info->refund_amount}}</td>
                             <!--<td>{{$info->refund_amount}}</td>-->
                             <td>{{$info->new_total_amount}}</td>
                             <!--<td>-->
                             <!--    <a href="{{ route('view-return',Crypt::encryptString($info->cart_item_return_id)) }}" class="btn btn-primary">View</a>-->
                             <!--</td>-->
                     </tr>
                     @endforeach
               </tbody>

             </table>
           </div>
         </div>
       </div>
     </div>
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
@include('admin.footer')
