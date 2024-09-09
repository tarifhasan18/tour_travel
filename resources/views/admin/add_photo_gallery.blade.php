<!DOCTYPE html>
<html lang="en">
<head>
   @include('admin.links')
   <style>
      label {
         display: inline-block;
         width: 200px;
         font-weight: bold;
      }

      .add_category {
         display: flex;
         justify-content: center;
         align-items: center;
         margin-top: 40px;
      }

      input[type='text'],
      input[type='file'] {
         width: 500px;
         padding: 12px;
         border: 1px solid #ccc;
         border-radius: 4px;
         resize: vertical;
      }

      .form_items {
         margin-top: 20px;
      }

      /* Add this CSS for form border */
      form {
         border: 2px solid #ccc; /* You can change the color and thickness */
         padding: 20px; /* Add padding to create some space inside the border */
         border-radius: 8px; /* Optional: Add rounded corners to the border */
         background-color: #ffffff; /* Optional: Add a background color */
         width: fit-content; /* Adjust the form's width based on its content */
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
            <h2>Add Photo Gallery</h2>
         </div>
         <div class="add_category">
            <form action="{{url('submit_photo_gallery')}}" method="POST" enctype="multipart/form-data">
               @csrf
               <div>
                  <label for="gallery_photo">Photo</label>
                  <input type="file" name="gallery_photo" required>
               </div>
               <div class="form_items">
                  <input class="btn btn-primary" type="submit" value="Add Photo">
               </div>
            </form>
         </div>
      </div>
   </div>

   @include('admin.footer')
</body>
</html>
