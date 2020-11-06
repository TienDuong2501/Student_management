@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(Session::has('success'))
            <div class="col-md-12 alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        @if(Session::has('error'))
            <div class="col-md-12 alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
        <div class="col-md-offset-10 col-md-2">
            <a href="{{ route('done_homeworks.create') }}" class="btn btn-info">Create</a>
        </div>
        <hr>
        <div class="col-md-12">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th class="text-center">Id</th>
                        <th class="text-center">User Name</th>
                        <th class="text-center">HomeWork Name</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Link</th>
                        <th class="text-center">Create At</th>
                        <th class="text-center">Updated At</th>
                        <th colspan="2" class="text-center">Action</th>
                    </tr>
                    </thead>
                <tbody>
                    @foreach($done_homeworks as $done)
                        <tr class="text-center">
                            <td>{{ $done->id }}</td>
                            <td>{{ $done->user->fullname }}</td>
                            <td>{{ $done->homeworks->name }}</td>
                            <td>{{ $done->description }}</td>
                            <td>
                                <a href="{{ $done->link }}" target="_blank">
                                    {{ $done->result }}
                                </a>
                            </td>
                            <td>{{ $done->created_at }}</td>
                            <td>{{ $done->updated_at }}</td>
                            <td>
                                <a href="{{ route('done_homeworks.edit', ['id' => $done->id]) }}" class="btn btn-primary">Edit</a>
                            </td>
                            <td>
                                <a onClick="event.preventDefault();
                                        confirm('do you really want to delete this done?')
                                        document.getElementById('delete-done').submit();" class="btn btn-danger">Delete</a>
                                    <form id="delete-done" action="{{ route('done_homeworks.destroy', ['id' => $done->id]) }}" method="POST">
                                        <input type="hidden" name="_method" value="DELETE">
                                        @csrf
                                    </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
                  <div class="col-md-12">
                  {{ $done_homeworks->links() }}
              </div>
        </div>
    </div>
</div>
@endsection
