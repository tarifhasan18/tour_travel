<meta http-equiv="X-UA-Compatible" content="IE=edge" />
{{-- <title>{{$site_settings->ui_site_name}}</title> --}}
<title>Eastern Tours & Travels</title>
<meta
  content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
  name="viewport"
/>
<link rel="icon" href="{{asset('img/eastern_logo.png')}}" type="image/gif/png">
{{-- <link rel="icon" href="{{asset('../img/'.$site_settings->ui_logo)}}" type="image/gif/png"> --}}

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Fonts and icons -->
<script src="{{ asset('/Admincss/assets/js/plugin/webfont/webfont.min.js') }}"></script>
<script>
  WebFont.load({
    google: { families: ["Public Sans:300,400,500,600,700"] },
    custom: {
      families: [
        "Font Awesome 5 Solid",
        "Font Awesome 5 Regular",
        "Font Awesome 5 Brands",
        "simple-line-icons",
      ],
      urls: [{{ asset('/Admincss/assets/css/fonts.min.css') }}],
    },
    active: function () {
      sessionStorage.fonts = true;
    },
  });
</script>

<!-- CSS Files -->
<link rel="stylesheet" href="{{ asset('/Admincss/assets/css/bootstrap.min.css') }}"  />
<link rel="stylesheet" href="{{ asset('/Admincss/assets/css/plugins.min.css') }}"  />
<link rel="stylesheet" href="{{ asset('/Admincss/assets/css/kaiadmin.min.css') }}"  />


{{-- CSS Files from Possie --}}
<link rel="stylesheet" href="{{ asset('backend/assets/vendors/mdi/css/materialdesignicons.min.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/vendors/css/vendor.bundle.base.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/vendors/font-awesome/css/font-awesome.min.css') }}" />
 <!--CSS files for data table-->
 <link type="text/css" rel="stylesheet"
 href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
<link type="text/css" rel="stylesheet"
 href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
 integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
 crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
<link href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}" /> --}}


<!-- CSS Just for demo purpose, don't include it in your project -->
<link rel="stylesheet" href="{{ asset('/Admincss/assets/css/demo.css') }}" />
<!-- Bootstrap CSS -->
{{-- SWEET ALERT --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script> --}}
<script type="text/javascript" src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
<link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}" />
<link href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css" rel="stylesheet">

<style>
    .main-panels {
        padding: 2rem;
    }
</style>
