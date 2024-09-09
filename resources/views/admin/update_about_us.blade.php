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
    .update_about_us{
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
       {{-- @include('admin.body') --}}
       <div class="container">
        <div class="page-inner">
        <div>
            <h2>Update About Us Page</h1>
        </div>
        <div class="update_about_us">
            <form action="{{url('submit_about_us')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="">About us Key Sentence</label>
                    <input type="text" name="keysentence" value="{{$data->keysentence}}">
                </div>
                <div class="form_items">
                    <label for="">Description</label>
                    <textarea name="description" id="">{{$data->description}}</textarea>
                </div>
                <div class="form_items">
                    <label for="">About Us Current Main Image</label>
                   <img width="150px" height="100px" src="{{asset('tour_image/'.$data->mainimage)}}" alt="">
                </div>
                <div class="form_items">
                    <label for="">Update About Us Main Image</label>
                    <input width="150px" height="100px" type="file" name="mainimage">
                </div>

                <div class="form_items">
                    <label for="">Current About Us Other Image 1</label>
                    <img  width="150px" height="100px"  src="{{asset('tour_image/'.$data->otherimage1)}}" alt="">
                </div>

                <div class="form_items">
                    <label for="">About Us Other Image 1</label>
                    <input type="file" name="otherimage1">
                </div>
                <div class="form_items">
                    <label for="">Current About Us Other Image 2</label>
                    <img  width="150px" height="100px"  src="{{asset('/tour_image/'.$data->otherimage2)}}" alt="">
                </div>
                <div class="form_items">
                    <label for="">About Us Other Image 2</label>
                    <input type="file" name="otherimage2">
                </div>
                <div class="form_items">
                    <input class="btn btn-primary" type="submit" value="Update About Us">
                </div>
            </form>
        </div>
        </div>
       </div>

        @include('admin.footer')
  </body>
</html>
