@extends('layouts.app-new')

@section('title', 'Scenes')
@section('scripts')
    <script src="{{ asset('assets/js/plugins/notifications/sweet_alert.min.js') }}"></script>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Scenes</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Room</th>
                                <th>Command</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$scenes->isEmpty())
                                @foreach ($scenes as $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->room->name }}</td>
                                        <td>
                                            @if (!$value->commands->isEmpty())
                                                @if (phpversion() == '8.1.6')
                                                    {{ implode(', ', $value->commands_arr) }}
                                                @else
                                                    {{ implode($value->commands_arr, ', ') }}
                                                @endif
                                            @else
                                                No Commands attached
                                            @endif
                                        </td>
                                        <td>{{ $value->status ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            <div class="list-icons">
                                                {{-- <a href="{{ route('scenes.play', $value->id) }}"
                                                    onclick="event.preventDefault(); playScene(this.href)"
                                                    class="list-icons-item text-success-600">
                                                    <i class="icon-play3"></i>
                                                </a> --}}
                                                <a href="{{ route('scenes.edit', $value->id) }}"
                                                    class="list-icons-item text-primary-600">
                                                    <i class="icon-pencil7"></i>
                                                </a>
                                                <a href="{{ route('scenes.destroy', $value->id) }}"
                                                    onclick="event.preventDefault(); $('.delete-form{{ $value->id }}').submit();"
                                                    class="list-icons-item text-danger-600">
                                                    <i class="icon-trash"></i>
                                                </a>
                                                <form action="{{ route('scenes.destroy', $value->id) }}" method="post"
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

    {{-- <script src="/socket.io/socket.io.js"></script> --}}
    <script>
        // var swalInit = swal.mixin({
        //     buttonsStyling: false,
        //     confirmButtonClass: 'btn btn-primary',
        //     cancelButtonClass: 'btn btn-light'
        // });

        // function playScene(href) {
        //     // console.log(href);
        //     $.ajax({
        //         url: href,
        //         method: 'get',
        //         dataType: 'json',
        //         success: function(response) {
        //             var type = ''
        //             if (response.status) {
        //                 type = 'success'
        //             } else {
        //                 type = 'error'
        //             }
        //             swalInit.fire({
        //                 title: response.title,
        //                 text: response.msg,
        //                 type: type
        //             });

        //             // var socket = io();

        //             // form.addEventListener('submit', function(e) {
        //             //     e.preventDefault();
        //             // if (input.value) {
        //             //     socket.emit('chat message', input.value);
        //             //     input.value = '';
        //             // }
        //             // });

        //             // socket.on('chat message', function(msg) {
        //             //     var item = document.createElement('li');
        //             //     item.textContent = msg;
        //             //     messages.appendChild(item);
        //             //     window.scrollTo(0, document.body.scrollHeight);
        //             // });
        //         }
        //     })
        // }
    </script>
@endsection
