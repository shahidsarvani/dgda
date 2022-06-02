@extends('layouts.app-new')

@section('title', 'Edit Scene')
@section('scripts')
<style>
    .select2 {
        border: 1px solid #ddd;
        border-width: 1px 0;
        border-top-color: transparent !important;
    }
</style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Edit Scene</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('scenes.update', $scene->id) }}" method="post" id="screen-form">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" name="name" value="{{ $scene->name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Room:</label>
                                    <select name="room_id" id="room_id" class="form-control"
                                        onchange="getRoomCommand(this.value)">
                                        <option value="">Select Room</option>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}"
                                                {{ $scene->room_id == $room->id ? 'selected' : '' }}>{{ $room->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Command:</label>
                                    <select name="command_ids[]" id="command_id" class="form-control select" multiple>
                                        <option value="">Select Command</option>
                                        @foreach ($commands as $command)
                                            <option value="{{ $command->id }}"
                                                {{ in_array($command->id, $scene->commands_arr) ? 'selected' : '' }}>{{ $command->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status:</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="0" {{ !$scene->status ? 'selected' : ''}}>Inactive</option>
                                        <option value="1" {{ $scene->status ? 'selected' : ''}}>Active</option>
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
@endsection
