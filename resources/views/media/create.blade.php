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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Language *</label>
                                <select id="lang" class="form-control">
                                    <option value="">Select Language</option>
                                    <option value="ar">Arabic</option>
                                    <option value="en">English</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Room *</label>
                                <select id="room_id" class="form-control">
                                    <option value="">Select Room</option>
                                    @foreach ($rooms as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Scene *</label>
                                <select id="scene_id" class="form-control">
                                    <option value="">Select Scene</option>
                                    {{-- @foreach ($scenes as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Phase</label>
                                <select id="phase_id" class="form-control">
                                    <option value="">Select Phase</option>
                                    {{-- @foreach ($phases as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Zone</label>
                                <select id="zone_id" class="form-control">
                                    <option value="">Select Zone</option>
                                    {{-- @foreach ($zones as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                <label>Projector Video *</label>
                                <select id="is_projector" class="form-control">
                                    <option value="">Select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div> --}}
                    </div>
                    <div class="form-group">
                        <label>Upload Media:</label>
                        {{-- <input type="file" name="media" class="file-input-ajax" accept="video/*" multiple="multiple" data-fouc> --}}
                        <form action="{{ route('upload_media') }}" class="dropzone" id="dropzone_multiple">
                        </form>

                        <form action="{{ route('media.store') }}" method="post" id="mediaForm">
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
        var err = 0;
        $('.add_media').click(function(e) {
            e.preventDefault();
            var form = document.getElementById('mediaForm')
            if(!$('input[name=lang]').length) {
                err = 1;
            }
            // if(!$('input[name=is_projector]').length) {
            //     err = 1;
            // }
            if(!$('input[name=room_id]').length) {
                err = 1;
            }
            if(!$('input[name=scene_id]').length) {
                err = 1;
            }
            if(!err) {
                form.submit();
            } else {
                alert('Please complete required fields')
            }
        })
        // function submitForm(e) {
        //     // alert(e)
        //     e.preventDefault();
        // }
        var list = $('#file-upload-list');
        console.log(list)
        // Multiple files
        Dropzone.options.dropzoneMultiple = {
            paramName: "media", // The name that will be used to transfer the file
            dictDefaultMessage: 'Drop files to upload <span>or CLICK</span>',
            maxFilesize: 10000000000000, // MB
            addRemoveLinks: true,
            chunking: true,
            chunkSize: 10000000,
            // If true, the individual chunks of a file are being uploaded simultaneously.
            parallelChunkUploads: true,
            acceptedFiles: 'video/*, image/*',
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
                                    uploadResponse.name + '" ><input type="hidden" name="durations[]" value="' +
                                    uploadResponse.duration + '" ><input type="hidden" name="is_images[]" value="' +
                                    uploadResponse.is_image + '" >')
                            }
                        }
                    })
            }
        };

        $('#room_id').change(function() {
            getRoomScenesAndPhases(this.value)
            if($("input[name=room_id]").length) {
                $("input[name=room_id]").remove();
            }
            list.append('<input type="hidden" name="room_id" value="' + this.value + '" >')
            err = 0
        })
        
        $('#scene_id').change(function() {
            if($("input[name=scene_id]").length) {
                $("input[name=scene_id]").remove();
            }
            list.append('<input type="hidden" name="scene_id" value="' + this.value + '" >')
            err = 0
        })
        
        $('#phase_id').change(function() {
            getPhaseZones(this.value)
            if($("input[name=phase_id]").length) {
                $("input[name=phase_id]").remove();
            }
            list.append('<input type="hidden" name="phase_id" value="' + this.value + '" >')
        })
        
        $('#zone_id').change(function() {
            if($("input[name=zone_id]").length) {
                $("input[name=zone_id]").remove();
            }
            list.append('<input type="hidden" name="zone_id" value="' + this.value + '" >')
        })
        
        $('#lang').change(function() {
            if($("input[name=lang]").length) {
                $("input[name=lang]").remove();
            }
            list.append('<input type="hidden" name="lang" value="' + this.value + '" >')
            err = 0
        })
        
        // $('#is_projector').change(function() {
        //     if($("input[name=is_projector]").length) {
        //         $("input[name=is_projector]").remove();
        //     }
        //     list.append('<input type="hidden" name="is_projector" value="' + this.value + '" >')
        //     err = 0
        // })


        function getRoomScenesAndPhases(roomId) {
            console.log(roomId);
            $.ajax({
                url: "{{ route('rooms.get_room_scenes_and_phases') }}",
                method: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    room_id: roomId
                },
                success: function(response) {
                    // console.log(response.length)
                    var scene_html_txt = '<option value="">Select Scene</option>'
                    for (var i = 0; i < response.scenes.length; i++) {
                        scene_html_txt += '<option value="' + response.scenes[i].id + '">' + response.scenes[i].name + '</option>'
                    }
                    $('#scene_id').empty().html(scene_html_txt);
                    var phase_html_txt = '<option value="">Select Phase</option>'
                    for (var i = 0; i < response.phases.length; i++) {
                        phase_html_txt += '<option value="' + response.phases[i].id + '">' + response.phases[i].name + '</option>'
                    }
                    $('#phase_id').empty().html(phase_html_txt);
                }
            })
        }

        function getPhaseZones(phaseId) {
            console.log(phaseId);
            $.ajax({
                url: "{{ route('phases.get_phase_zones') }}",
                method: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    phase_id: phaseId
                },
                success: function(response) {
                    // console.log(response.length)
                    var html_txt = '<option value="">Select Zone</option>'
                    for (var i = 0; i < response.length; i++) {
                        html_txt += '<option value="' + response[i].id + '">' + response[i].name + '</option>'
                    }
                    $('#zone_id').empty().html(html_txt);
                }
            })
        }
    </script>
@endsection
