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
        @if ($role == 1)
            <div class="col-md-offset-10 col-md-2">
                <a href="{{ route('games.create') }}" class="btn btn-info">Create</a>
            </div>
        @endif
        <hr>
        <div class="col-md-12">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr class="text-center">
                    <th class="text-center col-md-3">Id</th>
                    <th class="text-center col-md-3">name</th>
                    <th class="text-center col-md-3">gợi ý</th>
                    <th class="text-center col-md-3" colspan="3">action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($games as $game)
                    <tr class="text-center">
                        <td>{{ $game->id }}</td>
                        <td>
                            {{ $game->name }}
                        </td>
                        <td>
                            {{ $game->suggestion }}
                        </td>
                            @if ($role == 1)
                            <td>
                                <a href="{{ route('games.edit', ['id' => $game->id]) }}" class="btn btn-primary">Edit</a>
                            </td>
                            <td>
                                <a onClick="event.preventDefault();
                                        confirm('do you really want to delete this game?')
                                        document.getElementById('delete-game').submit();" class="btn btn-danger">Delete</a>
                                    <form id="delete-game" action="{{ route('games.destroy', ['id' => $game->id]) }}" method="POST">
                                        <input type="hidden" name="_method" value="DELETE">
                                        @csrf
                                    </form>
                            </td>
                            @endif
                            <td>
                                <a href="{{ route('games.show_game', ['id' => $game->id]) }}" class="btn btn-warning">Play game</a>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
              <div class="col-md-12">
                  {{ $games->links() }}
              </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection
