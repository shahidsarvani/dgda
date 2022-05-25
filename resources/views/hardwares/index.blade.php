@extends('layouts.app-new')

@section('title', 'Hardwares')
@section('scripts')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Hardwares</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="btn btn-primary" type="button" href="{{ route('hardwares.create') }}"><i class="icon-plus-circle2 mr-2"></i>Add Hardware</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Device</th>
                                <th>Room</th>
                                <th>IP/Port</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$hardwares->isEmpty())
                                @foreach ($hardwares as $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->device }}</td>
                                        <td>{{ $value->room->name }}</td>
                                        <td>{{ $value->ip . ($value->port ? '/'.$value->port : '')  }}</td>
                                        <td>{{ $value->status ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            <div class="list-icons">
                                                <a href="{{ route('hardwares.edit', $value->id) }}"
                                                    class="list-icons-item text-primary-600">
                                                    <i class="icon-pencil7"></i>
                                                </a>
                                                <a href="{{ route('hardwares.destroy', $value->id) }}"
                                                    onclick="event.preventDefault(); $('.delete-form{{ $value->id }}').submit();"
                                                    class="list-icons-item text-danger-600">
                                                    <i class="icon-trash"></i>
                                                </a>
                                                <form action="{{ route('hardwares.destroy', $value->id) }}" method="post"
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
                                    <td colspan="7">No Data Available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
