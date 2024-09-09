
<!DOCTYPE html>
<html lang="en">
  <head>
   @include('admin.links')
<style>
    .mail_body{
        width: 600px;
        height: 100px;
    }
</style>
  </head>
  <body>

      <!-- Sidebar -->
       @include('admin.sidebar')

       @include('admin.navbar')
       <div class="container">
        <div class="page-inner">
       <div class="modal-body">
        <form id="bookNowForm" action="{{url('reply_message',$data->id)}}" method="POST">
            @csrf
            <div class="form-group">
                <h3 class="text-center">Reply Message to {{$data->email}}</h3>
            </div>
            {{-- <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="eg: Tarif Hasan" required>
            </div>
            <div class="form-group">
                <label for="email">Your Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="eg: tarifhasan@gmail.com" required>
            </div> --}}
            <div class="form-group">
                <label for="phone">Greetings</label>
                <input type="text" class="form-control" id="greeting" name="greetings" placeholder="eg: Hello" required>
            </div>
            <div class="form-group">
                <label for="address">Mail Body</label><br>
                {{-- <input type="text" class="form-control" id="mail_body" name="mail_body" placeholder="eg: Yes, Of Course" required> --}}
                <textarea class="form-control" name="mail_body" id="mail_body" placeholder="Write Body"></textarea>
            </div>
            <div class="form-group">
                <label for="persons">Action Text</label>
                <input type="text" class="form-control" id="action_text" name="action_text" placeholder="eg: Action text" required>
            </div>
            <div class="form-group">
                <label for="allergy">Action Url</label>
                <input type="text" class="form-control" id="action_url" placeholder="eg: action_url " name="action_url" required>
            </div>
            <div class="form-group">
                <label for="allergy">End Line</label>
                <input type="text" class="form-control" id="endline" placeholder="eg: endline " name="endline" required>
                {{-- <small class="form-text text-right text-danger">Optional</small> --}}
            </div>
            <input type="hidden" id="package_id" name="package_id">
            <input type="submit" class="btn btn-success" value="Reply">
        </form>
    </div>
    </div>
    </div>
        @include('admin.footer')
  </body>
</html>
