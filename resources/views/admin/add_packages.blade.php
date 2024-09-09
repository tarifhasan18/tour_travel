<!DOCTYPE html>
<html lang="en">
  <head>
   @include('admin.links')
   <style>
       label{
           display: inline-block;
           width: 200px;
           font-weight: bold;
       }
       .add_packages{
           display: flex;
           justify-content: center;
           align-items: center;
           margin-top: 40px;
       }
       input[type='text'],input[type='number'], input[type='date']
       {
            width: 500px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
       }
       input[type='date']
       {
           width: 300px;
           height: 50px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;

       }
       .form_items{
           margin-top: 20px;
       }
       textarea{
            width: 500px;
            height: 100px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
            vertical-align: middle;

       }
   </style>
  </head>
  <body>

      <!-- Sidebar -->
       @include('admin.sidebar')

       @include('admin.navbar')
       <div class="container">
        <div class="page-inner">
        <div>
            <h2>Add Tour Packages</h1>
        </div>
        <div class="add_packages">
            <form action="{{url('submit_packages')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="">Tour Package Name</label>
                    <input type="text" name="name" placeholder="Tour Package Name" required>
                </div>
                <div class="form_items">
                    <label for="">Location</label>
                    <input type="text" name="location" placeholder="Tour Package Location" required>
                </div>
                <div class="form_items">
                    <label for="">Price in Dollar</label>
                    <input type="text" name="price_dollar" placeholder="Tour Package Price in dollar" required>
                </div>
                <div class="form_items">
                    <label for="">Price in Taka</label>
                    <input type="text" name="price_taka" placeholder="Tour Package Price in Taka" required>
                </div>
                <div class="form_items">
                    <label for="">Description</label>
                    <textarea name="description" id="" placeholder="Write here.."></textarea>
                </div>
                <div class="form_items" >
                    <label for="">Enter Tour Package Capacity</label>
                    <input type="number" name="capacity" placeholder="Capacity of Travellers" required>
                </div>

                <div class="form_items">
                    <label for="">Start Date</label>
                    <input type="date" name="startdate" placeholder="Tour Start Date" required>
                </div>
                <div class="form_items">
                    <label for="">End Date</label>
                    <input type="date" name="enddate" placeholder="Tour End Date" required>
                </div>

                <div class="form_items">
                    <label for="">Package Image</label>
                    <input type="file" name="image" required>
                </div>
                <div class="form_items">
                    <label for="">Special Instruction</label>
                    <textarea name="special_instruction" placeholder="Write here.."></textarea>
                </div>
                <div class="form_items">
                    <input class="btn btn-primary" type="submit" value="Add Package">
                </div>
            </form>
        </div>
        </div>
       </div>
@include('admin.footer')
  </body>
</html>
