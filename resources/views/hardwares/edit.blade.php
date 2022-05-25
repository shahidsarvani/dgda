@extends('layouts.app-new')

@section('title', 'Edit Hardware')
@section('scripts')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Edit Hardware</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('hardwares.update', $hardware->id) }}" method="post" id="screen-form">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" name="name" value="{{ $hardware->name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Device:</label>
                                    <input type="text" class="form-control" name="device" value="{{ $hardware->device }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>IP:</label>
                                    <input type="text" class="form-control" name="ip" value="{{ $hardware->ip }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Port:</label>
                                    <input type="text" class="form-control" name="port" value="{{ $hardware->port }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Room:</label>
                                    <select name="room_id" id="room_id" class="form-control">
                                        <option value="">Select Room</option>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}"  {{ $hardware->room_id == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status:</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="0" {{ !$hardware->status ? 'selected' : '' }}>Inactive</option>
                                        <option value="1" {{ $hardware->status ? 'selected' : '' }}>Active</option>
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
