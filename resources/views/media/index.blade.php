@extends('layouts.app-new')

@section('title', 'Media Gallery')
@section('scripts')
    <style>
        .card-img {
            position: relative;
        }

        .card-img .video-content {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
@endsection
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
                <a href="{{ route('media.create') }}" type="button" class="btn btn-primary float-right"><i
                        class="icon-plus3 mr-2"></i>Add Media</a>
            </div>
        </div>
    </div>

    <div class="row">
         <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Media</h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="6"> 
                                    <form method="GET" action="{{ route('media.index') }}" class="mb-3">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                                            <span class="input-group-append">
                                                <button class="btn btn-primary" type="submit">Search</button>
                                                <button class="btn btn-link" type="button" onclick="window.location='{{ route('media.index') }}'">Clear</button>
                                            </span>
                                        </div>
                                    </form>
                                </th>
                                <th colspan="4">  </th>
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Room </th>
                                <th>File Name</th>
                                <th>Language</th>
                                <th>Media Type </th>
                                <th>Video Time</th>
                                <th>Phase</th>
                                <th>Zone</th>
                                <th>Uploaded On</th>
                                <th>Actions</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$media->isEmpty())
                                @foreach ($media as $k => $item)
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ ($item->getRoom) ? $item->getRoom->name : '' }}</td>
                                        <td> 
                                            <a class="media-modal-cls" data-media-item="{{ $item->id }}" data-toggle="modal" data-target="#media_remote_modal" href="javascript:void(0);">
                                                {{ $item->name }}
                                            </a> 
                                        </td>
                                        <td>{{ $item->lang }}</td>
                                        <td>{{ ($item->is_image == 1) ? "Image" : "Video" }}</td>
                                        <td>{{ ($item->is_image == 0) ?  $item->duration : '' }}</td> 
                                        <td>{{ ($item->getPhase) ? $item->getPhase->name : '' }}</td>
                                        <td>{{ ($item->getZone) ? $item->getZone->name : '' }}</td> 
                                        <td>{{ $item->updated_at }}</td> 
                                        <td>
                                            <div class="list-icons">                                                 
                                                <a class="media-modal-cls list-icons-item text-primary-600" data-media-item="{{ $item->id }}" data-toggle="modal" data-target="#media_remote_modal" href="javascript:void(0);">
                                                    @if ($item->is_image)
                                                        <i class="icon-search4"></i> 
                                                    @else
                                                        <i class="icon-play3"></i> 
                                                    @endif 
                                                </a> &nbsp; 
                                                <a href="{{ route('media.destroy', $item->id) }}"
                                                    onclick="event.preventDefault(); confirmDelete({{ $item->id }});"
                                                    class="list-icons-item text-danger-600"> <i class="icon-trash"></i> </a>

                                                <form action="{{ route('media.destroy', $item->id) }}" method="post"
                                                    class="d-none delete-form{{ $item->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form> 
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="10" style="text-align: center;">  
                                         {{ $media->links('pagination::bootstrap-4') }} 
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="10">No Data Available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
            function confirmDelete(itemId) {
                if (confirm('Are you sure you want to delete this item?')) {
                    document.querySelector('.delete-form' + itemId).submit();
                }
            }  
            jQuery(document).ready(function($) {
                if ($("a.media-modal-cls").length) {
                    let media_item_val;
                   
                    $('a.media-modal-cls').on('click', function() {
                        media_item_val = $(this).data('media-item');
                        $("#fetch_modal_remote_media").html('Loading...');
                        //$('#media_remote_modal').modal('show'); // Open the modal 
                        
                        // Modal show event handler to load the content
                        $('#media_remote_modal').on('show.bs.modal', function() {
                            const url = `${location.origin}/media/${media_item_val}`;
                            $(this).find('.modal-body').load(url);
                        });
                    }); 
                    
                }
            });
        </script>

        <!-- media_remote_modal -->
        <div id="media_remote_modal" class="modal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Media Detail </h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body" id="fetch_modal_remote_media"> Loading... </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </div>
        <!-- /media_remote_modal -->
      
        {{-- <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-img-actions m-1">
                    <div class="card-img embed-responsive embed-responsive-16by9">
                        <iframe allowfullscreen="" frameborder="0" mozallowfullscreen=""
                            src="https://player.vimeo.com/video/126945693?title=0&amp;byline=0&amp;portrait=0"
                            webkitallowfullscreen=""></iframe>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <!-- /video grid -->
@endsection
