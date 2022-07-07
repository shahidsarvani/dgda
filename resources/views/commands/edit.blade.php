@extends('layouts.app-new')

@section('title', 'Edit Command')
@section('scripts')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Edit Command</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('commands.update', $command->id) }}" method="post" id="screen-form">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Command:</label>
                                    <input type="text" class="form-control" name="name" value="{{ $command->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Room:</label>
                                    <select name="room_id" id="room_id" class="form-control"
                                        onchange="getRoomHardware(this.value)" required>
                                        <option value="">Select Room</option>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}"
                                                {{ $command->room_id == $room->id ? 'selected' : '' }}>{{ $room->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Hardware:</label>
                                    <select name="hardware_id" id="hardware_id" class="form-control" required>
                                        <option value="">Select Hardware</option>
                                        @foreach ($hardwares as $hardware)
                                            <option value="{{ $hardware->id }}"
                                                {{ $command->hardware_id == $hardware->id ? 'selected' : '' }}>{{ $hardware->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description:</label>
                                    <textarea name="description" id="description" class="form-control" cols="30"
                                        rows="3" required>{{ $command->description }}</textarea>
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
        function getRoomHardware(roomId) {
            console.log(roomId);
            $.ajax({
                url: "{{ route('rooms.get_room_hardware') }}",
                method: 'post',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    room_id: roomId
                },
                success: function(response) {
                    console.log(response.length)
                    var html_txt = '<option value="">Select Hardware</option>'
                    for (var i = 0; i < response.length; i++) {
                        html_txt += '<option value="' + response[i].id + '">' + response[i].name + '</option>'
                    }
                    $('#hardware_id').empty().html(html_txt);
                }
            })
        }
    </script>
@endsection
