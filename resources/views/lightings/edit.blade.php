@extends('layouts.app-new')

@section('title', 'Edit Lighting Type')
@section('scripts')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Edit Lighting Type</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('lightings.update', $lighting->id) }}" method="post" id="screen-form">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" name="name" value="{{ $lighting->name }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Lighting Type:</label>
                                    <select name="lighting_type_id" id="lighting_type_id" class="form-control">
                                        <option value="">Select Lighting Type</option>
                                        @foreach ($lighting_types as $lighting_type)
                                            <option value="{{ $lighting_type->id }}" {{ $lighting_type->id == $lighting->lighting_type_id ? 'selected' : '' }}>{{ $lighting_type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Room:</label>
                                    <select name="room_id" id="room_id" class="form-control">
                                        <option value="">Select Room</option>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}" {{ $room->id == $lighting->room_id ? 'selected' : '' }}>{{ $room->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Scene:</label>
                                    <select name="scene_id" id="scene_id" class="form-control">
                                        <option value="">Select Scene</option>
                                        @foreach ($scenes as $scene)
                                            <option value="{{ $scene->id }}" {{ $scene->id == $lighting->scene_id ? 'selected' : '' }}>{{ $scene->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Command:</label>
                                    <select name="command_id" id="command_id" class="form-control">
                                        <option value="">Select Command</option>
                                        @foreach ($commands as $command)
                                            <option value="{{ $command->id }}" {{ $command->id == $lighting->command_id ? 'selected' : '' }}>{{ $command->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status:</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="0" {{ !$lighting->status ? 'selected' : '' }}>Inactive</option>
                                        <option value="1" {{ $lighting->status ? 'selected' : '' }}>Active</option>
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

{{-- @section('footer_script')
    <script>
        function getRoomCommand(roomId) {
            console.log(roomId);
            $.ajax({
                url: "{{ route('rooms.get_room_command') }}",
                method: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    room_id: roomId
                },
                success: function(response) {
                    console.log(response.length)
                    var html_txt = '<option value="">Select Command</option>'
                    for (var i = 0; i < response.length; i++) {
                        html_txt += '<option value="' + response[i].id + '">' + response[i].name + '</option>'
                    }
                    $('#command_id').empty().html(html_txt);
                }
            })
        }
    </script>
@endsection --}}
