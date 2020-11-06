@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="{{route('games.update', ['id' => $game->id])}}" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="_method" value="PUT">
              @csrf
              <div class="form-group">
                <label for="name">Tên trò chơi</label>
                <input type="text" name="name" value="{{old('name') ?? $game->name}}" class="form-control" id="name" placeholder="Tên trò chơi">
                @if($errors->first('name'))
                  <p class="text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                  </p>
                @endif
              </div>
              <div class="form-group">
                <label for="suggestion">Gợi ý</label>
                <textarea class="form-control" name="suggestion" rows="3">
                  {{old('name') ?? $game->suggestion }}
                </textarea>
                @if($errors->first('suggestion'))
                  <p class="text-danger">
                    <strong>{{ $errors->first('suggestion') }}</strong>
                  </p>
                @endif
              </div>
              <div class="form-group">
                <label for="exampleInputFile">File input</label>
                <input type="file" id="exampleInputFile" name="file" value="{{old('file')}}">
                <p class="help-block">Click upload button to upload your file.</p>
                 @if($errors->first('file'))
                  <p class="text-danger">
                    <strong>{{ $errors->first('file') }}</strong>
                  </p>
                  @endif
              </div>
              <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
