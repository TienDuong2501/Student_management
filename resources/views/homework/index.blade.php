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
        @if($authUser->role == 1)
            <div class="col-md-offset-10 col-md-2">
                <a href="{{ route('homeworks.create') }}" class="btn btn-info">Create</a>
            </div>
        @endif
        <hr>
        <div class="col-md-12">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th class="text-center">Id</th>
                        <th class="text-center">Link</th>
                        <th class="text-center">Create At</th>
                        <th class="text-center">Updated At</th>
                        <th class="text-center" colspan="3">Action</th>
                    </tr>
                    </thead>
                <tbody>
                    @foreach($homeworks as $homework)
                        <tr class="text-center">
                            <td>{{ $homework->id }}</td>
                            <td>
                                <a href="{{ $homework->link }}" target="_blank">
                                    {{ $homework->name }}
                                </a>
                            </td>
                            <td>{{ $homework->created_at }}</td>
                            <td>{{ $homework->updated_at }}</td>
                            {{-- <td> --}}
                                @if($authUser->role == 1)
                                <td>
                                <a href="{{ route('homeworks.edit', ['id' => $homework->id]) }}" class="btn btn-primary">Edit</a>
                                </td>
                                <td>
                                <a data-id="{{ $homework->id }}" onClick="event.preventDefault();
                                        confirm('do you really want to delete this homework?')
                                        var id = $(this).data('id');
                                        document.getElementById('delete-homework' + id).submit();" class="btn btn-danger">Delete</a>
                                    <form id="{{'delete-homework'. $homework->id}}" action="{{ route('homeworks.destroy', ['id' => $homework->id]) }}" method="POST">
                                        <input type="hidden" name="_method" value="DELETE">
                                        @csrf
                                    </form>
                                </td>
                                @endif
                                <td>
                                    <a href="{{ route('homeworks.download', ['id' => $homework->id]) }}" class="btn btn-primary">Download</a>
                                </td>
                            {{-- </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
                  <div class="col-md-12">
                  {{ $homeworks->links() }}
              </div>
        </div>
    </div>
</div>
@endsection
