@extends('layouts.app-new')

@section('title', 'Media Gallery')

<!-- Theme JS files -->
{{-- <script src="../../../../global_assets/js/plugins/media/fancybox.min.js"></script> --}}
{{-- <script src="../../../../global_assets/js/demo_pages/gallery.js"></script> --}}
@section('content')
    <!-- Video grid -->
    <div class="mb-3 pt-2">
        <div class="row">
            <div class="col-md-6">
                <h6 class="mb-0 font-weight-semibold">
                    Media Gallery
                </h6>
                {{-- <span class="text-muted d-block">Video grid with 4 - 2 - 1 columns</span> --}}
            </div>
            <div class="col-md-6">
                <a href="{{ route('media.create') }}" type="button" class="btn btn-primary float-right"><i class="icon-plus3 mr-2"></i>Add Media</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-img-actions m-1">
                    <div class="card-img embed-responsive embed-responsive-16by9">
                        <iframe allowfullscreen="" frameborder="0" mozallowfullscreen=""
                            src="https://player.vimeo.com/video/126945693?title=0&amp;byline=0&amp;portrait=0"
                            webkitallowfullscreen=""></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /video grid -->
@endsection
