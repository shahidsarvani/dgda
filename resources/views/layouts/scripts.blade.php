<!-- Global stylesheets -->
<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/layout.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
<!-- /global stylesheets -->

<!-- Core JS files -->
<script src="{{ asset('assets/js/main/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/main/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/loaders/blockui.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/ui/ripple.min.js') }}"></script>
<!-- /core JS files -->

<!-- Theme JS files -->
<script src="{{ asset('assets/js/plugins/forms/selects/select2.min.js') }}"></script>
{{-- <script src="{{ asset('assets/js/plugins/forms/styling/switchery.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/plugins/ui/moment/moment.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/plugins/pickers/daterangepicker.js') }}"></script> --}}

<script src="{{ asset('assets/js/app.js') }}"></script>
<script>
    var upload_medial_url = "{{ route('upload_media') }}"
    var csrf_token = "{{ csrf_token() }}"
</script>
