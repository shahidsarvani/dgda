@extends('layouts.app-new')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Test</h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Connection Status: <small id="status">connection closed</small></h4>
                            <h4>Last Received Command: <small id="rec_command">None</small></h4>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="port">Listen to port</label>
                                <input type="text" class="form-control" value="58900" id="port">
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-primary" id="listen">Listen</button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="command">Send Command</label>
                                <input type="text" class="form-control" value="WSSpots80" id="command">
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-primary" id="send_command">Send Command</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_script')
    <script>
        $(document).ready(function() {
            $('#listen').click(function() {
                console.log(document.getElementById('port').value)
                $.ajax({
                    url: '{{ route('do_test') }}',
                    data: {
                        port: document.getElementById('port').value
                    },
                    dataType: 'json',
                    method: 'GET',
                    beforeSend: function() {
                        document.getElementById('status').innerHTML = '<span class="text-info">Listening...<span class="text-success">'
                        $('#listen').attr('disabled', 'disabled');
                    },
                    success: function(response) {
                        if (response.status) {
                            document.getElementById('status').innerHTML = '<span class="text-success">Connected!</span>'
                        } else {
                            alert('Error!' + response.msg)
                        }
                    },
                    error: function(xhr, status, error) {
                        var swalInit = swal.mixin({
                            buttonsStyling: false,
                            confirmButtonClass: 'btn btn-primary',
                            cancelButtonClass: 'btn btn-light'
                        });
                        swalInit.fire({
                            title: 'Error',
                            text: error,
                            type: 'error'
                        });
                        document.getElementById('status').innerHTML =
                            '<span class="text-warning">connection cannot be made!</span>'

                        $('#listen').removeAttr('disabled');
                    }
                })
            })
        })
    </script>
@endsection
