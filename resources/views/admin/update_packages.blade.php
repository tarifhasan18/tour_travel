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
       input[type='text'],input[type='number']
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
            <h1>Update Tour Packages Information</h1>
        </div>
        <div class="add_packages">
            <form action="{{url('update_packages',$data->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="">Tour Package Name</label>
                    <input type="text" name="name" value="{{$data->name}}" required>
                </div>
                <div class="form_items">
                    <label for="">Location</label>
                    <input type="text" name="location" value="{{$data->location}}" required>
                </div>
                <div class="form_items">
                    <label for="">Price in Dollar</label>
                    <input type="text" name="pricedollar" value="{{$data->price_dollar}}" required>
                </div>

                <div class="form_items">
                    <label for="">Price in Taka</label>
                    <input type="text" name="pricetaka" value="{{$data->price_taka}}" required>
                </div>

                <div class="form_items">
                    <label for="">Description</label>
                    <textarea name="description" id="">{{$data->description}}</textarea>
                </div>
                <div class="form_items" >
                    <label for="">Capacity of Travellers</label>
                    <input type="number" name="capacity" value="{{$data->capacity}}" required>
                </div>
                {{-- <div class="form_items">
                    <label for="">Travel Duration</label>
                    <input type="number" name="duration" value="{{$data->no_of_persons}}" required>
                </div> --}}
                <div class="form_items">
                    <label for="">Start Date</label>
                    <input type="date" name="startdate" value="{{$data->startdate}}" required>
                </div>
                <div class="form_items">
                    <label for="">End Date</label>
                    <input type="date" name="enddate" value="{{$data->enddate}}"  required>
                </div>
                <div class="form_items">
                    <label for="">Current Image</label>
                    <img width="240px" height="100px" src="{{asset('tour_image/'.$data->image)}}" alt="">
                </div>
                <div class="form_items">
                    <label for="">Update Image</label>
                    <input type="file" name="image">
                </div>
                <div class="form_items">
                    <label for="">Special Instruction</label>
                    <textarea name="special_instruction" id="">{{$data->special_instruction}}</textarea>
                </div>
                <div class="form_items">
                    <input class="btn btn-primary" type="submit" value="Update Package">
                </div>
            </form>
        </div>
        </div>
       </div>
        @include('admin.footer')
  </body>
</html>
