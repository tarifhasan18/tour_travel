@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120px">
    <div class="content-wrapper">
   <div class="page-header justify-content-between">
     <h3 class="page-title ml-4">All Unit</h3>
     <nav aria-label="breadcrumb">
       <ol class="breadcrumb mr-4">
         <li class="breadcrumb-item"><a href="#">Definition</a></li>
         <li class="breadcrumb-item active" aria-current="page"> All Unit </li>
       </ol>
     </nav>
   </div>
   <div class="row">
     <div class="col-lg-12 grid-margin stretch-card">
       <div class="card">
         <div class="card-body">
           <div class="card-description btn btn-info">
               <a class="text-light" href="{{ url('add-unit')}}">Add New unit</a>
           </div>
           <h4 class="card-title text-center">Size List</h4>
           <div class="table-responsive custom-table-formatter">
             <table id="example" class="table table-striped table-bordered" width="100%">

               <thead>
                 <tr>
                   <th>Unit Name</th>
                   <th>Unit Symbol</th>
                   <th>Is Fractional</th>
                   <th>Status</th>
                   <th>Action</th>
                 </tr>

               </thead>
               <tbody>
                   @foreach($Unit as $values)
                     <tr>
                       <td>{{$values->unit_name}}</td>
                       <td>{{$values->unit_symbol}}</td>

                       @if($values->is_fractional==1)
                       <td>Fractional</td>
                       @else
                       <td>Not Fractional</td>
                       @endif

                       @if($values->is_active==1)
                       <td>Active</td>
                       @else
                       <td>Not Active</td>
                       @endif

                       <td><a class="btn btn-warning" class="text-light" href="{{ url('edit-unit',Crypt::encryptString($values->unit_id))}}">Edit</a></td>

                     </tr>
                   @endforeach
               </tbody>
               <tfoot>
                 <tr>
                   <th>Unit Name</th>
                   <th>Unit Symbol</th>
                   <th>Is Fractional</th>
                   <th>Status</th>
                   <th>Action</th>
                 </tr>
               </tfoot>

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
