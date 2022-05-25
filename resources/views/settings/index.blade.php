@extends('layouts.app-new')

@section('title', 'Settings')
@section('scripts')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Settings</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('settings.update', $setting->id) }}" method="post" id="screen-form">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Room Count:</label>
                                    <input type="number" class="form-control" name="room_count" value="{{ $setting->room_count }}">
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
