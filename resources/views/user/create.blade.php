@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label for="name">Tên đăng nhập</label>
                <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="Tên đăng nhập">
                @if($errors->first('name'))
                  <p class="text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                  </p>
                @endif
              </div>
              <div class="form-group">
                <label for="fullname">Họ và tên</label>
                <input type="text" class="form-control" value="{{old('fullname')}}" id="fullname" name="fullname" placeholder="Họ và tên">
                @if($errors->first('fullname'))
                  <p class="text-danger">
                    <strong>{{ $errors->first('fullname') }}</strong>
                  </p>
                @endif
              </div>
              <div class="form-group">
                <label for="phone">Phone</label>
                <input type="phone" name="phone" value="{{old('phone')}}" class="form-control" id="phone" placeholder="Số điện thoại">
                @if($errors->first('phone'))
                  <p class="text-danger">
                    <strong>{{ $errors->first('phone') }}</strong>
                  </p>
                @endif
              </div>
              <div class="form-group">
                <label for="role">Vai trò</label>
                <input type="role" name="role" value="{{old('role')}}" class="form-control" id="role" placeholder="Vai trò">
                @if($errors->first('role'))
                  <p class="text-danger">
                    <strong>{{ $errors->first('role') }}</strong>
                  </p>
                @endif
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" value="{{old('email')}}" class="form-control" id="role" placeholder="email">
                @if($errors->first('email'))
                  <p class="text-danger">
                    <strong>{{ $errors->first('email') }}</strong>
                  </p>
                @endif
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" value="{{old('password')}}" id="password" placeholder="Mật khẩu">
                @if($errors->first('password'))
                  <p class="text-danger">
                    <strong>{{ $errors->first('password') }}</strong>
                  </p>
                @endif
              </div>
              <div class="form-group">
                <label for="password_confirmation">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation"value="{{old('password_confirmation')}}" class="form-control" id="password_confirmation" placeholder="Xác nhận mật khẩu">
                @if($errors->first('confirm_password'))
                  <p class="text-danger">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                  </p>
                @endif
              </div>
              <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
