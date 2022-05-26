@extends('layouts.app-new')

@section('title', 'Edit Zone')
@section('scripts')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Edit Zone</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('zones.update', $zone->id) }}" method="post" id="screen-form">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name (English):</label>
                                    <input type="text" class="form-control" name="name" value="{{ $zone->name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name (Arabic):</label>
                                    <input type="text" class="form-control" name="name_ar" value="{{ $zone->name_ar }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phase:</label>
                                    <select name="phase_id" id="phase_id" class="form-control">
                                        <option value="">Select Phase</option>
                                        @foreach ($phases as $phase)
                                            <option value="{{ $phase->id }}"
                                                {{ $zone->phase_id == $phase->id ? 'selected' : '' }}>{{ $phase->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status:</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="0" {{ !$zone->status ? 'selected' : ''}}>Inactive</option>
                                        <option value="1" {{ $zone->status ? 'selected' : ''}}>Active</option>
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
