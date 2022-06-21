@extends('layouts.app-new')

@section('title', 'Zones')
@section('scripts')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Add Zone</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('zones.store') }}" method="post" id="screen-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Name (English):</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Name (Arabic):</label>
                                    <input type="text" class="form-control" name="name_ar">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Room:</label>
                                    <select name="room_id" id="room_id" class="form-control"
                                        onchange="getRoomScenesAndPhases(this.value)">
                                        <option value="">Select Room</option>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Scene:</label>
                                    <select id="scene_id" name="scene_id" class="form-control">
                                        <option value="">Select Scene</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Phase:</label>
                                    <select id="phase_id" name="phase_id" class="form-control">
                                        <option value="">Select Phase</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status:</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="0">Inactive</option>
                                        <option value="1">Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Add <i
                                    class="icon-plus-circle2 ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Zones</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name (English)</th>
                                <th>Name (Arabic)</th>
                                <th>Phase</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$zones->isEmpty())
                                @foreach ($zones as $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->name_ar }}</td>
                                        <td>{{ $value->phase->name }}</td>
                                        <td>{{ $value->status ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            <div class="list-icons">
                                                <a href="{{ route('zones.edit', $value->id) }}"
                                                    class="list-icons-item text-primary-600">
                                                    <i class="icon-pencil7"></i>
                                                </a>
                                                <a href="{{ route('zones.destroy', $value->id) }}"
                                                    onclick="event.preventDefault(); $('.delete-form{{ $value->id }}').submit();"
                                                    class="list-icons-item text-danger-600">
                                                    <i class="icon-trash"></i>
                                                </a>
                                                <form action="{{ route('zones.destroy', $value->id) }}" method="post"
                                                    class="d-none delete-form{{ $value->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    {{-- <input type="hidden" name="id" value="{{ $value->id }}"> --}}
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">No Data Available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
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
