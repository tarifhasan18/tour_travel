
<style>
    /* Basic reset and styles */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .contactus_container {
        max-width: 800px;
        margin: 0 auto;
        /* background-color: #fff; */
        padding: 20px;
        border-radius: 8px;
        /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
        margin-top: 50px
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    .contact-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .contact-info p {
        margin-bottom: 5px;
    }
    .map {
        width: 100%;
        height: 400px;
        margin-bottom: 20px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid gray;
    }
    iframe {
        width: 100%;
        height: 100%;
        border: 0;
    }
    i{
        font-size: 20px;
        margin-right: 10px;
    }
</style>
<!-- Contact Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mb-3 pb-3">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Contact</h6>
            <h1>Contact For Any Query</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact-form bg-white" style="padding: 30px;">
                    <div id="success"></div>
                    <form action="{{url('send_contact_message')}}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="control-group col-sm-6">
                                <input type="text" class="form-control p-4" name="name" id="name" placeholder="Your Name"
                                    required="required" data-validation-required-message="Please enter your name" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group col-sm-6">
                                <input type="email" class="form-control p-4" id="email" name="email" placeholder="Your Email"
                                    required="required" data-validation-required-message="Please enter your email" />
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <input type="text" class="form-control p-4" id="phone" name="phone" placeholder="Phone Number"
                                required="required" data-validation-required-message="Please enter your phone number" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="text" class="form-control p-4" id="subject" name="subject" placeholder="Subject"
                                required="required" data-validation-required-message="Please enter a subject" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <textarea class="form-control py-3 px-4" rows="5" id="message" name="message" placeholder="Message"
                                required="required"
                                data-validation-required-message="Please enter your message"></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="text-center">
                            <input class="btn btn-primary py-3 px-4" type="submit" id="sendMessageButton" value="Send Message"></input>
                        </div>
                    </form>
                </div>

                <div class="contactus_container">
                    <h1>Contact Information</h1>
                    <div class="contact-info">
                        <div>
                            <p><i class="fas fa-map-marker-alt"></i><strong> Address:</strong> {{$site_settings->address}}</p>
                            <p><i class="fas fa-envelope"></i> <strong>Email:</strong> {{$site_settings->email}}</p>
                            <p><i class="fas fa-phone"></i><strong> Phone:</strong> {{$site_settings->phone}}</p>
                            <p><i class="fas fa-clock"></i><strong> Hours:</strong> {{$site_settings->contact_open_close}}</p>
                        </div>
                    </div>
                    <div class="map">
                        <!-- Replace with your Google Maps iframe embed code -->
                        <iframe src="{{$site_settings->contact_google_map}}"></iframe>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

