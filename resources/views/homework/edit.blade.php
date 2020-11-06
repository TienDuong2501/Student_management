@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="{{route('homeworks.update', ['id' => $homeWork->id])}}" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="_method" value="PUT">
              @csrf
              <div class="form-group">
                <label for="name">Tên bài tập</label>
                <input type="text" name="name" value="{{$homeWork->name ?? old('name')}}" class="form-control" id="name" placeholder="Tên bài tập">
                @if($errors->first('name'))
                  <p class="text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                  </p>
                @endif
              </div>
              <div class="form-group">
                <label for="exampleInputFile">File input</label>
                <input type="file" id="exampleInputFile" name="home_work">
                <p class="help-block">Click upload button to upload your file.</p>
                 @if($errors->first('home_work'))
                  <p class="text-danger">
                    <strong>{{ $errors->first('home_work') }}</strong>
                  </p>
                  @endif
              </div>
              <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
