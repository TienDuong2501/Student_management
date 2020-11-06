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
            <a href="{{ route('users.create') }}" class="btn btn-info">Create</a>
        </div>
        <hr>
        <div class="col-md-12">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr class="text-center">
                    <th class="text-center">Id</th>
                    <th class="text-center">name</th>
                    <th class="text-center">Fullname</th>
                    <th class="text-center">phone</th>
                    <th class="text-center">email</th>
                    <th colspan="2" class="text-center">action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="text-center">
                        <td>{{ $user->id }}</td>
                        <td>
                            <a href="{{ route('users.show', ['id' => $user->id]) }}">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td>{{ $user->fullname }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->email }}</td>
                        {{-- <td> --}}
                            <td>
                            @if ($authUser->role == 1 || $authUser->id == $user->id)
                                <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-primary">Edit</a>
                            @endif
                            </td>
                            @if($authUser->role == 1)
                            <td>
                                <a data-id="{{ $user->id }}" onClick="event.preventDefault();
                                        confirm('do you really want to delete this user?')
                                        var id = $(this).data('id');
                                        document.getElementById('delete-user' + id).submit();" class="btn btn-danger">Delete</a>
                                    <form id="{{'delete-user'. $user->id}}" action="{{ route('users.destroy', ['id' => $user->id]) }}" method="POST">
                                        <input type="hidden" name="_method" value="DELETE">
                                        @csrf
                                    </form>
                            </td>
                            @endif
                        {{-- </td> --}}
                    </tr>
                    @endforeach
                </tbody>
              </table>
              <div class="col-md-12">
                  {{ $users->links() }}
              </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection
