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
                                    <input type="text" class="form-control" name="name" value="{{ $scene->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Room:</label>
                                    <select name="room_id" id="room_id" class="form-control"
                                        onchange="getRoomCommand(this.value)" required>
                                        <option value="">Select Room</option>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}"
                                                {{ $scene->room_id == $room->id ? 'selected' : '' }}>{{ $room->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
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
                            </div> --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status:</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="0" {{ !$scene->status ? 'selected' : '' }}>Inactive</option>
                                        <option value="1" {{ $scene->status ? 'selected' : '' }}>Active</option>
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label>Media (English):</label>
                                    <select name="media_en_id" id="media_en_id" class="form-control">
                                        <option value="">Select Media</option>
                                        @foreach ($media_en as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $scene->medias ? (collect($scene->medias)->where('lang', 'en')->first()->id == $item->id ? 'selected' : '') : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Media (Arabic):</label>
                                    <select name="media_ar_id" id="media_ar_id" class="form-control">
                                        <option value="">Select Media</option>
                                        @foreach ($media_ar as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $scene->medias ? (collect($scene->medias)->where('lang', 'ar')->first()->id == $item->id ? 'selected' : '') : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-md-6">
                                <div class="form-check mt-4">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="is_default" class="form-check-input" value="1" {{ $scene->is_default ? 'checked' : '' }}>Default Scene
                                    </label>
                                </div>
                            </div>
                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Model Up Time Delay</label>
                                    <input type="text" class="form-control" name="model_up_delay"
                                        value="{{ $scene->model_up_delay }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Model Down Time Delay</label>
                                    <input type="text" class="form-control" name="model_down_delay"
                                        value="{{ $scene->model_down_delay }}">
                                </div>
                            </div> --}}
                            <div class="col-md-12 mt-3">
                                <h6 class="font-weight-semibold">Select Commands:</h6>
                                <div id="commands">
                                    @foreach ($commands_grouped as $key => $command)
                                        <label class="font-weight-semibold">{{ $key }}</label>
                                        <div class="row">
                                            @foreach ($command as $item)
                                                <div class="col-md-4 command-wrapper">
                                                    <div class="row">
                                                        <div class="col-md-6 checkbox-wrapper">
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" name="command_ids[]"
                                                                        class="form-check-input" onchange="show_sort(this)" data-value="{{ $item->name }}"
                                                                        value="{{ $item->id }}"
                                                                        {{ in_array($item->id, $scene->commands_arr) ? 'checked' : '' }}>{{ $item->name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 sort-wrapper {{ in_array($item->id, $scene->commands_arr) ? '' : 'd-none' }}">
                                                            <div class="form-group">
                                                                <label>Sort</label>
                                                                <input type="text" name="sort_order[]"
                                                                    class="form-control" value="{{ in_array($item->id, $scene->commands_arr) ? $sort_arr[0] : '' }}">
                                                            </div>
                                                            @if ($item->name === 'MODELUP' && $scene->model_up_delay)
                                                            <div class="form-group modelup">
                                                                <label for="">Model Up Time Delay (English)</label>
                                                                <input type="text" class="form-control" name="model_up_delay" value="{{ $scene->model_up_delay }}">
                                                            </div>
                                                            @endif
                                                            @if ($item->name === 'MODELUP' && $scene->model_up_delay_ar)
                                                            <div class="form-group modelup">
                                                                <label for="">Model Up Time Delay (Arabic)</label>
                                                                <input type="text" class="form-control" name="model_up_delay_ar" value="{{ $scene->model_up_delay_ar }}">
                                                            </div>
                                                            @endif
                                                            @if ($item->name === 'MODELDOWN' && $scene->model_down_delay)
                                                            <div class="form-group modeldown">
                                                                <label for="">Model Down Time Delay (English)</label>
                                                                <input type="text" class="form-control" name="model_down_delay" value="{{ $scene->model_down_delay }}">
                                                            </div>
                                                            @endif
                                                            @if ($item->name === 'MODELDOWN' && $scene->model_down_delay_ar)
                                                            <div class="form-group modeldown">
                                                                <label for="">Model Down Time Delay (Arabic)</label>
                                                                <input type="text" class="form-control" name="model_down_delay_ar" value="{{ $scene->model_down_delay_ar }}">
                                                            </div>
                                                            @endif
                                                        </div>
                                                        @php
                                                            if (in_array($item->id, $scene->commands_arr)) {
                                                                array_shift($sort_arr);
                                                            }
                                                        @endphp
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
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
        function show_sort(elem) {
            console.log(elem)
            var _this = $(elem)
            if (_this.is(':checked')) {
                _this.parents('.command-wrapper').find('.sort-wrapper').removeClass('d-none');
                if(_this.data('value') === 'MODELUP') {
                    var model_up_html = '<div class="form-group modelup"><label for="">Model Up Time Delay (English)</label><input type="text" class="form-control" name="model_up_delay"></div>'
                    model_up_html += '<div class="form-group modelup"><label for="">Model Up Time Delay (Arabic)</label><input type="text" class="form-control" name="model_up_delay_ar"></div>'
                    _this.parents('.command-wrapper').find('.sort-wrapper').append(model_up_html)
                }
                if(_this.data('value') === 'MODELDOWN') {
                    var model_down_html = '<div class="form-group modeldown"><label for="">Model Down Time Delay (English)</label><input type="text" class="form-control" name="model_down_delay"></div>'
                    model_down_html += '<div class="form-group modeldown"><label for="">Model Down Time Delay (Arabic)</label><input type="text" class="form-control" name="model_down_delay_ar"></div>'
                    _this.parents('.command-wrapper').find('.sort-wrapper').append(model_down_html)
                }
            } else {
                _this.parents('.command-wrapper').find('.sort-wrapper').addClass('d-none');
                _this.parents('.command-wrapper').find('.sort-wrapper input').val(null);
                if(_this.data('value') === 'MODELUP') {
                    _this.parents('.command-wrapper').find('.sort-wrapper .modelup').remove()
                }
                if(_this.data('value') === 'MODELDOWN') {
                    _this.parents('.command-wrapper').find('.sort-wrapper .modeldown').remove()
                }
            }
        }

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
                    var html_txt = ''
                    for (var i = 0; i < response.length; i++) {
                        console.log(response[i])
                        // console.log(response[i].name)
                        html_txt += '<label class="font-weight-semibold">' + response[i].hardware_name +
                            '</label>'
                        html_txt += '<div class="row">'
                        var commands = response[i].commands
                        for (var j = 0; j < commands.length; j++) {
                            html_txt += '<div class="col-md-4 command-wrapper">' +
                                '<div class="row">' +
                                '<div class="col-md-6 checkbox-wrapper">' +
                                '<div class="form-check">' +
                                '<label class="form-check-label">' +
                                '<input type="checkbox" name="command_ids[]" class="form-check-input" onchange="show_sort(this)" value="' +
                                commands[j].id + '">' + commands[j].name +
                                '</label>' +
                                '</div>' +
                                '</div>' +
                                '<div class="col-md-6 d-none sort-wrapper">' +
                                '<div class="form-group">' +
                                '<label>Sort</label>' +
                                '<input type="text" name="sort_order[]" class="form-control">' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
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
