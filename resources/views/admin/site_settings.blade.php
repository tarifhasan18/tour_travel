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
    .site_settings{
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
    </style>
  </head>
  <body>

      <!-- Sidebar -->
       @include('admin.sidebar')

       @include('admin.navbar')
       <div class="container">
        <div class="page-inner">
            <div>
                <h2>Update Site Settings Information</h1>
            </div>

            <div class="site_settings">
                <form action="{{url('update_site_settings',$site_settings->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="">Email</label>
                        <input type="text" name="email" value="{{$site_settings->email}}" required>
                    </div>
                    <div class="form_items">
                        <label for="">Phone Number</label>
                        <input type="text" name="phone" value="{{$site_settings->phone}}" required>
                    </div>
                    <div class="form_items">
                        <label for="">Address</label>
                        <input type="text" name="address" value="{{$site_settings->address}}" required>
                    </div>

                    <div class="form_items">
                        <label for="">Facebook</label>
                        <input type="text" name="facebook" value="{{$site_settings->facebook}}" required>
                    </div>
                    <div class="form_items" >
                        <label for="">Twitter</label>
                        <input type="text" name="twitter" value="{{$site_settings->twitter}}" required>
                    </div>
                    <div class="form_items">
                        <label for="">Linked In</label>
                        <input type="text" name="linkedin" value="{{$site_settings->linkedin}}" required>
                    </div>

                    <div class="form_items">
                        <label for="">YouTube</label>
                        <input type="text" name="youtube" value="{{$site_settings->youtube}}" required>
                    </div>

                    <div class="form_items">
                        <label for="">Instagram</label>
                        <input type="text" name="instagram" value="{{$site_settings->instagram}}" required>
                    </div>
                    <div class="form_items">
                        <label for="">Copyright</label>
                        <input type="text" name="copyright" value="{{$site_settings->copyright}}" required>
                    </div>

                    <div class="form_items">
                        <label for="">Copyright Link</label>
                        <input type="text" name="copyright_links" value="{{$site_settings->copyright_links}}" required>
                    </div>

                    <div class="form_items">
                        <label for="">Current Website Logo</label>
                        <img width="50px" src="{{asset('tour_image/'.$site_settings->ui_logo)}}" alt="">
                    </div>
                    <div class="form_items">
                        <label for="">Update Website Logo</label>
                        <input type="file" name="website_logo">
                    </div>


                    <div class="form_items">
                        <label for="">Website Name</label>
                        <input type="text" name="website_name" value="{{$site_settings->ui_site_name}}" required>
                    </div>

                    <div class="form_items">
                        <label for="">Current Admin Logo</label>
                        <img width="40px" src="{{asset('tour_image/'.$site_settings->admin_logo)}}" alt="">
                    </div>

                    <div class="form_items">
                        <label for="">Update Admin Logo</label>
                        <input type="file" name="admin_logo" value="{{$site_settings->admin_logo}}">
                    </div>

                    <div class="form_items">
                        <label for="">Admin Site Name</label>
                        <input type="text" name="admin_site_name" value="{{$site_settings->admin_site_name}}" required>
                    </div>


                    <div class="form_items">
                        <label for="">Website Footer Name</label>
                        <input type="text" name="website_footer_name" value="{{$site_settings->footer_ui_name}}" required>
                    </div>

                    <div class="form_items">
                        <label for="">Website Footer Short Note</label>
                        <input type="text" name="ui_footer_note" value="{{$site_settings->ui_footer_note}}">
                    </div>

                    <div class="form_items">
                        <label for="">Contact Google Map Links</label>
                        <input type="text" name="contact_google_map" value="{{$site_settings->contact_google_map}}">
                    </div>

                    <div class="form_items">
                        <label for="">Contact Opening and Closing</label>
                        <input type="text" name="contact_open_close" value="{{$site_settings->contact_open_close}}">
                    </div>

                    <div class="form_items">
                        <label for="">Slider Keyword 1</label>
                        <input type="text" name="slider_keyword1" value="{{$site_settings->slider_keyword1}}">
                    </div>

                    <div class="form_items">
                        <label for="">Current Slider Image 1 </label>
                        <img width="100px" height="150px" src="{{asset('tour_image/'.$site_settings->slider_image1)}}" alt="">
                    </div>

                    <div class="form_items">
                        <label for="">Update Slider Image 1 </label>
                        <input type="file" name="slider_image1">
                    </div>

                    <div class="form_items">
                        <label for="">Slider Keyword 2</label>
                        <input type="text" name="slider_keyword2" value="{{$site_settings->slider_keyword2}}">
                    </div>

                    <div class="form_items">
                        <label for="">Current Slider Image 2 </label>
                        <img width="100px" height="150px" src="{{asset('tour_image/'.$site_settings->slider_image2)}}" alt="">
                    </div>

                    <div class="form_items">
                        <label for="">Update Slider Image 2</label>
                        <input type="file" name="slider_image2" value="">
                    </div>

                    <div class="form_items">
                        <label for="">Slider Keyword 3</label>
                        <input type="text" name="slider_keyword3" value="{{$site_settings->slider_keyword3}}">
                    </div>

                    <div class="form_items">
                        <label for="">Current Slider Image 3 </label>
                        <img width="100px" height="150px" src="{{asset('tour_image/'.$site_settings->slider_image3)}}" alt="">
                    </div>

                    <div class="form_items">
                        <label for="">Update Slider Image 3</label>
                        <input type="file" name="slider_image3" value="">
                    </div>

                    <div class="form_items">
                        <input class="btn btn-primary" type="submit" value="Update Site Settings">
                    </div>
                </form>
            </div>
        </div>
       </div>

        @include('admin.footer')
  </body>
</html>
