<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DGDA - @yield('title')</title>

    <!-- /theme JS files -->
    @include('layouts.scripts')
    @yield('scripts')
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</head>

<body>
    @include('layouts.navbar')


    <!-- Page content -->
    <div class="page-content">
        @include('layouts.sidebar')


        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                    <div class="d-flex">
                        <div class="breadcrumb">
                            <a href="#" class="breadcrumb-item">
                                <i class="icon-home2 mr-2"></i>
                                Home
                            </a>
                            <span class="breadcrumb-item active">@yield('title')</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page header -->


            <!-- Content area -->
            <div class="content">
                @include('alert')
                @yield('content')
            </div>
            <!-- /content area -->


            <!-- Footer -->
            @include('layouts.footer')
            <!-- /footer -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->
    @yield('footer_script')
</body>

</html>
