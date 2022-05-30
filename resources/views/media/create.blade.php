@extends('layouts.app-new')

@section('title', 'Add Media')
@section('scripts')
    <script src="{{ asset('assets/js/plugins/uploaders/dropzone.min.js') }}"></script>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Add Media</h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Room</label>
                                <select id="room_id" class="form-control">
                                    <option value="">Select Room</option>
                                    @foreach ($rooms as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Scene</label>
                                <select id="scene_id" class="form-control">
                                    <option value="">Select Scene</option>
                                    @foreach ($scenes as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Phase</label>
                                <select id="phase_id" class="form-control">
                                    <option value="">Select Phase</option>
                                    @foreach ($phases as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Zone</label>
                                <select id="zone_id" class="form-control">
                                    <option value="">Select Zone</option>
                                    @foreach ($zones as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Upload Media:</label>
                        {{-- <input type="file" name="media" class="file-input-ajax" accept="video/*" multiple="multiple" data-fouc> --}}
                        <form action="{{ route('upload_media') }}" class="dropzone" id="dropzone_multiple">
                        </form>

                        <form action="{{ route('media.store') }}" method="post">
                            @csrf
                            <ul id="file-upload-list" class="list-unstyled">
                            </ul>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary add_media">Add <i
                                class="icon-plus-circle2 ml-2"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_script')
    <script>
        var list = $('#file-upload-list');
        console.log(list)
        // Multiple files
        Dropzone.options.dropzoneMultiple = {
            paramName: "media", // The name that will be used to transfer the file
            dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
            maxFilesize: 400000000, // MB
            addRemoveLinks: true,
            chunking: true,
            chunkSize: 4000000,
            // If true, the individual chunks of a file are being uploaded simultaneously.
            parallelChunkUploads: true,
            acceptedFiles: 'video/*',
            init: function() {
                this.on('addedfile', function() {
                        list.append('<li>Uploading</li>')
                    }),
                    this.on('sending', function(file, xhr, formData) {
                        formData.append("_token", csrf_token);

                        // This will track all request so we can get the correct request that returns final response:
                        // We will change the load callback but we need to ensure that we will call original
                        // load callback from dropzone
                        var dropzoneOnLoad = xhr.onload;
                        xhr.onload = function(e) {
                            dropzoneOnLoad(e)
                            // Check for final chunk and get the response
                            var uploadResponse = JSON.parse(xhr.responseText)
                            if (typeof uploadResponse.name === 'string') {
                                list.append('<li>Uploaded: ' + uploadResponse.path + uploadResponse.name +
                                    '</li><input type="hidden" name="file_names[]" value="' +
                                    uploadResponse.name + '" >')
                            }
                        }
                    })
            }
        };

        $('#room_id').change(function() {
            list.append('<input type="hidden" name="room_id" value="' + this.value + '" >')
        })

        $('#scene_id').change(function() {
            list.append('<input type="hidden" name="scene_id" value="' + this.value + '" >')
        })

        $('#phase_id').change(function() {
            list.append('<input type="hidden" name="phase_id" value="' + this.value + '" >')
        })

        $('#zone_id').change(function() {
            list.append('<input type="hidden" name="zone_id" value="' + this.value + '" >')
        })


        // $('.add_media').click(function() {
        //     var room_id = $('#room_id').val();
        //     var scene_id = $('#scene_id').val();
        //     var phase_id = $('#phase_id').val();
        //     var zone_id = $('#zone_id').val();
        //     var files = $('input[name="file_names"]').val();
        //     console.log(files);
        //     $.ajax({
        //         url: "{{ route('media.store') }}",
        //         method: "POST",
        //         data: {
        //             room_id: room_id,
        //             scene_id: scene_id,
        //             phase_id: phase_id,
        //             zone_id: zone_id,
        //             files: files,
        //         },
        //         dataType: "json",
        //         success: function(response) {
        //             if(response.status == 1) {
        //                 window.location.href = response.location
        //             } else {
        //                 alert(JSON.strigify(response))
        //             }
        //         }
        //     })
        // })
    </script>
@endsection
