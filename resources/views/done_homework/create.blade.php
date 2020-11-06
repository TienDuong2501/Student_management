@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="{{ route('done_homeworks.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label for="name">Tên bài tập</label>
                <select class="form-control" name="home_work_id">
                  <option value="">choose your homework</option>
                  @foreach($homeworks as $homework)
                    <option value="{{$homework->id}}">{{ $homework->name }}</option>
                  @endforeach
                </select>
                @if($errors->first('home_work_id'))
                  <p class="text-danger">
                    <strong>{{ $errors->first('home_work_id') }}</strong>
                  </p>
                @endif
              </div>
              <div class="form-group">
                <label for="name">Mô tả</label>
                <textarea class="form-control" rows="3" value="{{ old('description') }}" name="description"></textarea>
                @if($errors->first('description'))
                  <p class="text-danger">
                    <strong>{{ $errors->first('description') }}</strong>
                  </p>
                @endif
              </div>
              <div class="form-group">
                <label for="result">Bài làm</label>
                <input type="file" id="result" name="result">
                <p class="help-block">Click upload button to upload your file.</p>
                @if($errors->first('result'))
                  <p class="text-danger">
                    <strong>{{ $errors->first('result') }}</strong>
                  </p>
                @endif
              </div>
              <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
