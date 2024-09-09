        <!-- gallery -->
        <div  class="gallery">
            <div class="container">

            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="gallery_img">
                        @foreach ($photo_gallery as $photos)
                            <figure>
                                <img src="{{ asset('photo_gallery/' . $photos->photo) }}" alt="{{ $photos->name }}"/>
                            </figure>
                        @endforeach
                    </div>
                </div>
            </div>
            </div>
        </div>
        <!-- end gallery -->
