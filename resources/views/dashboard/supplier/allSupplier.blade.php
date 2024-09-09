@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120px">
    <div class="content-wrapper">
   <div class="page-header justify-content-between">
     <h3 class="page-title ml-4">Suppliers</h3>
     <nav aria-label="breadcrumb">
       <ol class="breadcrumb mr-4">
         <li class="breadcrumb-item"><a href="#">Delivery</a></li>
         <li class="breadcrumb-item active" aria-current="page"> Suppliers </li>
       </ol>
     </nav>
   </div>
   <div class="row">
     <div class="col-md-12 grid-margin stretch-card">
       <div class="card">
         <div class="card-body">
           <div class="card-description btn btn-info"><a class="text-light" href="{{ url('add-supplier')}}">Add New Supplier</a></div>
           <h4 class="card-title text-center">Supplier List</h4>
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
           <div class="table-responsive custom-table-formatter">
             <table id="example" class="table table-striped table-bordered">

               <thead>
                 <tr>
                   <th>Supplier Name</th>
                   <th>Supplier Address</th>
                   <th>Supplier Contact Person</th>
                   <th>Supplier Contact No</th>
                   <th>Status</th>
                   <th>Action</th>
                 </tr>

               </thead>
               <tbody>
                   @foreach($Supplier as $values)
                     <tr>
                       <td>{{$values->supplier_name	}}</td>
                       <td>{{$values->supplier_address}}</td>
                       <td>{{$values->supplier_contact_person}}</td>
                       <td>{{$values->supplier_contact_no}}</td>
                       @if($values->is_active==1)
                       <td>Active</td>
                       @else
                       <td>Not Active</td>
                       @endif

                       <td><a class="btn btn-warning" class="text-light" href="{{ url('edit-supplier',Crypt::encryptString($values->supplier_id))}}">Edit</a></td>

                     </tr>
                   @endforeach
               </tbody>
               <tfoot>
                 <tr>
                   <th>Supplier Name</th>
                   <th>Supplier Address</th>
                   <th>Supplier Contact Person</th>
                   <th>Supplier Contact No</th>
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
