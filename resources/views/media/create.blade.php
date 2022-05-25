@extends('layouts.app-new')

@section('title', 'Add Media')
@section('scripts')
    <script src="{{ asset('assets/js/plugins/uploaders/fileinput/plugins/sortable.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/uploaders/fileinput/fileinput.min.js') }}"></script>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Add Media</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('media.store') }}" method="post" enctype="multipart/form-data"
                        id="screen-form">
                        @csrf
                        <div class="form-group">
                            <label>Upload Media:</label>
                            <input type="file" name="media" class="file-input-ajax" accept="video/*" multiple="multiple" data-fouc>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Add <i class="icon-plus-circle2 ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
