@extends('layouts.app-new')

@section('title', 'Edit Room')
@section('scripts')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Edit Room</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('rooms.update', $room->id) }}" method="post" id="screen-form"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name (English):</label>
                                    <input type="text" class="form-control" name="name" value="{{ $room->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name (Arabic):</label>
                                    <input type="text" class="form-control" name="name_ar"
                                        value="{{ $room->name_ar }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image (English):</label>
                                    <input type="file" class="form-control" name="image" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image (Arabic):</label>
                                    <input type="file" class="form-control" name="image_ar" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type:</label>
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="1" {{ $room->type == 1 ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ $room->type == 2 ? 'selected' : '' }}>2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status:</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="0" {{ !$room->status ? 'selected' : '' }}>Inactive</option>
                                        <option value="1" {{ $room->status ? 'selected' : '' }}>Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Model Controller:</label>
                                    <select name="has_model" id="has_model" class="form-control" required>
                                        <option value="0" {{ !$room->has_model ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ $room->has_model ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Scene:</label>
                                    <select name="scene_id" id="scene_id" class="form-control" required>
                                        <option value="">Select Scene</option>
                                        @foreach ($scenes as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $room->scene_id ? 'selected' : '' }}>{{ $item->name }}
                                            </option>
                                        @endforeach
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
