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
        <div class="col-md-12">
            <form>
              <div class="form-group">
                <label for="name">Tên trò chơi</label>
                <input type="text" name="name" value="{{ $game->name }}" class="form-control" id="name" placeholder="Tên trò chơi">
              </div>
              <div class="form-group">
                <label for="suggestion">Gợi ý</label>
                <textarea class="form-control" name="suggestion" rows="3">
                  {{ $game->suggestion }}
                </textarea>
              </div>
            </form>
            <hr>
            <form action="{{ route('games.play_game', ['id' => $game->id]) }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="answer">Điền đáp án</label>
                <input type="text" name="answer" value="{{ old('answer') }}" class="form-control" id="answer" placeholder="Tên trò chơi">
              </div>
              <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
