@include('admin.links')
@include('admin.sidebar')
@include('admin.navbar')
<div class="main-panels" style="padding-top: 120px">
    <div class="content-wrapper">
   <div class="page-header d-flex justify-content-between align-items-center">
     <h3 class="page-title" style="margin-left: 20px">Product Categories</h3>
     <nav aria-label="breadcrumb">
       <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="#">Product Categories</a></li>
         <li class="breadcrumb-item active" aria-current="page"> All Categories </li>
       </ol>
     </nav>
   </div>
   <div class="row">
     <div class="col-lg-12 grid-margin stretch-card">
       <div class="card">
         <div class="card-body">
           <div class="card-description btn btn-info"><a class="text-light" href="{{ route('addProductCat')}}">Add Product Category</a></div>
           <h4 class="card-title text-center">Category List</h4>
           <div class="table-responsive custom-table-formatter">
             <table id="product_cat_table"  class="table table-striped table-bordered">
               <thead>
                 <tr>
                    <th></th>
                   <th>Name</th>
                   <th>Sample Image</th>
                   <th>Status</th>
                   <th>Action</th>
                 </tr>

               </thead>
               <tbody>
                   @foreach($Productcat as $values)
                     <tr>
                        <td></td>
                       <td>{{$values->category_name}}</td>

                       <td>
                           <img height="40px" width="40px" src="{{ asset('backend/images/CategoryWise/'.$values->sample_image) }}">
                       </td>
                       @if($values->is_active==1)
                       <td>Active</td>
                       @else
                       <td>Not Active</td>
                       @endif

                       <td><a class="btn btn-warning" class="text-light" href="{{ url('edit-category',Crypt::encryptString($values->category_id))}}">Edit</a></td>

                     </tr>
                   @endforeach
               </tbody>
               <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Sample Image</th>
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
<script>
    var table = $('#product_cat_table').DataTable({
        'columnDefs': [
          {
             'targets': 0,
             'checkboxes': {
                'selectRow': true
             }
          }
        ],
        'select': {
          'style': 'multi'
        },
        'order': [[1, 'asc']],

        });
    </script>
