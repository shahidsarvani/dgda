@extends('layouts.app-new')

@section('title', 'Edit Zone')
@section('scripts')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Edit Zone</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('zones.update', $zone->id) }}" method="post" id="screen-form">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Name (English):</label>
                                    <input type="text" class="form-control" name="name" value="{{ $zone->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Name (Arabic):</label>
                                    <input type="text" class="form-control" name="name_ar" value="{{ $zone->name_ar }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Room:</label>
                                    <select name="room_id" id="room_id" class="form-control"
                                        onchange="getRoomScenesAndPhases(this.value)" required>
                                        <option value="">Select Room</option>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}" {{ $zone->room_id == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Phase:</label>
                                    <select name="phase_id" id="phase_id" class="form-control" required>
                                        <option value="">Select Phase</option>
                                        @foreach ($phases as $phase)
                                            <option value="{{ $phase->id }}"
                                                {{ $zone->phase_id == $phase->id ? 'selected' : '' }}>{{ $phase->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Scene:</label>
                                    <select name="scene_id" id="scene_id" class="form-control" required>
                                        <option value="">Select Scene</option>
                                        @foreach ($scenes as $scene)
                                            <option value="{{ $scene->id }}"
                                                {{ $zone->scene_id == $scene->id ? 'selected' : '' }}>{{ $scene->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status:</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="0" {{ !$zone->status ? 'selected' : ''}}>Inactive</option>
                                        <option value="1" {{ $zone->status ? 'selected' : ''}}>Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update <i
                                    class="icon-plus-circle2 ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_script')
    <script>
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
                        scene_html_txt += '<option value="' + response.scenes[i].id + '">' + response.scenes[i]
                            .name + '</option>'
                    }
                    $('#scene_id').empty().html(scene_html_txt);
                    var phase_html_txt = '<option value="">Select Phase</option>'
                    for (var i = 0; i < response.phases.length; i++) {
                        phase_html_txt += '<option value="' + response.phases[i].id + '">' + response.phases[i]
                            .name + '</option>'
                    }
                    $('#phase_id').empty().html(phase_html_txt);
                }
            })
        }
    </script>
@endsection
