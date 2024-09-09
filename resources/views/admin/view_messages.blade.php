<!DOCTYPE html>
<html lang="en">
  <head>
   @include('admin.links')
    <style>
            table {
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
      border: 1px solid #ddd;
    }
    th{
        text-align: center;
        padding: 8px;
        background: #2c3e50;
        color:  white;

    }

    td {
      text-align: center;
      padding: 8px;
    }

    tr:nth-child(even){background-color: #e0dede}
    tr:nth-child(even):hover{background-color: ; cursor: pointer;color: }
    tr:nth-child(odd):hover{background-color: ; cursor: pointer;color: }
    a{
        border-radius: 10px;
    }
    .search_container{
        display: flex;
        justify-content: right;
        align-items: right;
    }
    .search_box{
        padding: 10px;
        width: 350px;
        border: 1px solid black;
    }
    .tour_packages{
        margin-top: 10px;
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
                <h1>All Tour Packages</h1>
            </div>
            <div class="search_container">
                <form action="{{url('search_contact')}}" method="get">
                  @csrf
                  <input class="search_box" type="text" name="search" placeholder="Search Here" required>
                  <input class="btn btn-primary" type="submit" value="Search">
                </form>
            </div>
            <div class="tour_packages">
                <table>
                    <tr>
                        <th>Sender's Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Action</th>
                        <th>Remove</th>
                    </tr>
                    @foreach ( $contact as $contacts)
                    <tr>
                        <td>{{$contacts->name}}</td>
                        <td>{{$contacts->phone}}</td>
                        <td>{{$contacts->email}}</td>
                        <td>{{$contacts->subject}}</td>
                        <td>{{$contacts->message}}</td>
                        <td>
                            {{-- <a class="btn btn-primary" data-toggle="modal" data-target="#bookNowModal" data-package-id="{{$contacts->id}}">Reply</a> --}}
                            <a href="{{url('reply_email',$contacts->id)}}" class="btn btn-primary">Reply</a>
                        </td>
                        <td>
                            <a class="btn btn-danger" href="{{url('remove_message',$contacts->id)}}">Remove</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
       </div>


<!-- Book Now Modal -->
<div class="modal fade" id="bookNowModal" tabindex="-1" role="dialog" aria-labelledby="bookNowModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookNowModalLabel">Book Now</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="bookNowForm" action="{{url('reply_message',$contacts->id)}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <h3 class="text-center">Reply Message to {{$contacts->id}}</h3>
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
                        <input type="text" class="form-control" id="greeting" name="greeting" placeholder="eg: Hello" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Mail Body</label>
                        <input type="text" class="form-control" id="mail_body" name="mail_body" placeholder="eg: Yes, Of Course" required>
                    </div>
                    <div class="form-group">
                        <label for="persons">Action Text</label>
                        <input type="number" class="form-control" id="action_text" name="action_text" placeholder="eg: Action text" required>
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
</div>

<script>
    $('#bookNowModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var packageId = button.data('package-id'); // Extract info from data-* attributes
        var modal = $(this);
        modal.find('.modal-body #package_id').val(packageId);
    });
</script>

        @include('admin.footer')
  </body>
</html>
