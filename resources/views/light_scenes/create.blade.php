@extends('layouts.app-new')

@section('title', 'Add Scene')
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
                    <h5 class="card-title">Add Scene</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('light_scenes.store') }}" method="post" id="screen-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Room:</label>
                                    <select name="room_id" id="room_id" class="form-control"
                                        onchange="getRoomCommand(this.value)">
                                        <option value="">Select Room</option>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}">{{ $room->name }}
                                            </option>
                                        @endforeach
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
                            <div class="col-md-12">
                                <h6 class="font-weight-semibold">Select Commands:</h6>
                                <div id="commands">
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
                    // var html_txt = '<option value="">Select Command</option>'
                    var html_txt = ''
                    for (var i = 0; i < response.length; i++) {
                        console.log(response[i])
                        console.log(response[i].name)
                        html_txt += '<label class="font-weight-semibold">' + response[i].hardware_name +
                            '</label>'
                        html_txt += '<div class="d-flex" style="gap: 10px; flex-wrap: wrap;">'
                        var commands = response[i].commands
                        for (var j = 0; j < commands.length; j++) {
                            html_txt += '<div class="form-check">' +
                                '<label class="form-check-label">' +
                                '<input type="checkbox" name="command_ids[]" class="form-check-input" value="' +
                                commands[j].id + '">' +
                                commands[j].name +
                                '</label>' +
                                '</div>'
                        }
                        html_txt += '</div>'
                    }
                    $('#commands').empty().html(html_txt);
                }
            })
        }
    </script>
@endsection
